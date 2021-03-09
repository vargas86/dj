<?php

namespace App\Actions\API\Member\Profile;

use Image;
use Exception;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
            'school_name' => ['nullable', 'string'],
            'school_location' => ['nullable', 'string'],
            'nationality' => ['nullable', 'string'],
            'biography' => ['nullable', 'string', 'min:0'],
            'facebook' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'string'],
            'twitter' => ['nullable', 'string'],
            'school_lat' => ['nullable'],
            'school_lng' => ['nullable'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 422);
        }
        try {

            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $phone = $request->get('phone');
            $school_name = $request->get('school_name');
            $school_location = null;
            if ($request->get('school_lat') and $request->get('school_lng')) {
                $school_location = $request->get('school_lat') . ',' . $request->get('school_lng');
            }
            $nationality = $request->get('nationality');
            $biography = $request->get('biography');
            $facebook = $request->get('facebook');
            $instagram = $request->get('instagram');
            $linkedin = $request->get('linkedin');
            $twitter = $request->get('twitter');
            $avatar = $request->get('avatar');


            $user = \Auth::user();
            $user->firstname = $first_name;
            $user->lastname = $last_name;
            $user->phone = $phone;
            $user->school_name = $school_name;
            $user->school_location = $school_location;
            $user->nationality = $nationality;
            $user->biography = $biography;
            $user->facebook = $facebook;
            $user->instagram = $instagram;
            $user->linkedin = $linkedin;
            $user->twitter = $twitter;
            if ($request->avatar) {
                Storage::disk('s3')->delete('users/' . $user->avatar);

                $sizeMin = min(getimagesize($request->file('avatar'))[0], getimagesize($request->file('avatar'))[1]);
                $sizeMax = max(getimagesize($request->file('avatar'))[0], getimagesize($request->file('avatar'))[1]);
                $space = ($sizeMax - $sizeMin) / 2;
                $avatar_path = 'users/' . time() . Str::random(10, 100) . '.' . $request->file('avatar')->getClientOriginalExtension();

                if (getimagesize($request->file('avatar'))[0] > getimagesize($request->file('avatar'))[1]) {
                    $avatar = Image::make($request->file('avatar'))->crop($sizeMin, $sizeMin, $space, 0, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                } else {
                    $avatar = Image::make($request->file('avatar'))->crop($sizeMin, $sizeMin, 0, $space, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode();
                }

                Storage::disk('s3')->put($avatar_path, $avatar, 'public');
                $user->avatar = Storage::disk('s3')->url($avatar_path);
            }
            $user->save();
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 422);
        }
        return response()->json(
            [],
            200
        );
    }
}
