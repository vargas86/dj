<?php

namespace App\Actions\Web\Member\Profile;

use Image;
use Exception;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Action;
use Illuminate\Support\Facades\Storage;

class Update extends Action
{
    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the action.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Execute the action and return a result.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'topic' => ['required', 'numeric'],
            'school_name' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],
            'biography' => ['nullable', 'string', 'min:0'],
            'facebook' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'string'],
            'twitter' => ['nullable', 'string'],
            'school_lat' => ['nullable'],
            'school_lng' => ['nullable'],
            'password' => ['nullable', 'confirmed', 'min:8', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ]);

        if ($validator->fails()) {
            return redirect(route('profile.edit'))
                ->withInput()
                ->withErrors($validator->errors()->first());
        }

        try {

            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $phone = $request->get('phone');
            $school_name = $request->get('school_name');
            $nationality = $request->get('nationality');
            $biography = $request->get('biography');
            $facebook = $request->get('facebook');
            $instagram = $request->get('instagram');
            $linkedin = $request->get('linkedin');
            $twitter = $request->get('twitter');
            $avatar = $request->get('avatar');
            $topic = $request->get('topic');
            $school_lat = $request->get('school_lat');
            $school_lng = $request->get('school_lng');
            $password = $request->get('password');

            $user = \Auth::user();
            $user->firstname = $first_name;
            $user->lastname = $last_name;
            $user->phone = $phone;
            $user->school_name = $school_name;
            $user->school_lat = $school_lat;
            $user->school_lng = $school_lng;
            $user->nationality = $nationality;
            $user->topic_id = $topic;
            $user->biography = $biography;
            $user->facebook = $facebook;
            $user->instagram = $instagram;
            $user->linkedin = $linkedin;
            $user->twitter = $twitter;
            if ($password)
                $user->password = Hash::make($password);

            if ($request->avatar) {
                Storage::disk('s3')->delete('users/' . $user->avatar);
                $sizeMin = min(getimagesize($request->file('avatar'))[0], getimagesize($request->file('avatar'))[1]);
                $sizeMax = max(getimagesize($request->file('avatar'))[0], getimagesize($request->file('avatar'))[1]);
                $space = intval(($sizeMax - $sizeMin) / 2);
                $avatar_path = 'users/' . time() . Str::random(10, 100) . '.' . $request->file('avatar')->getClientOriginalExtension();

                if (getimagesize($request->file('avatar'))[0] > getimagesize($request->file('avatar'))[1]) {
                    $avatar = Image::make($request->file('avatar'))->crop($sizeMin, $sizeMin, $space, 0)->encode();
                } else {
                    $avatar = Image::make($request->file('avatar'))->crop($sizeMin, $sizeMin, 0, $space)->encode();
                }

                Storage::disk('s3')->put($avatar_path, $avatar, 'public');
                $user->avatar = Storage::disk('s3')->url($avatar_path);
            }
            $user->save();
        } catch (Exception $e) {
            return redirect(route('profile.edit'))->withErrors([
                'Operation failed.'
            ]);
        }
        return redirect(route("profile"));
    }
}
