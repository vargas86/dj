<?php

namespace App\Actions\Web\Member\Channel;

use App\Models\Channel;
use App\Models\Pack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Lorisleiva\Actions\Action;
use Validator;

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
            'subscription_price' => ['required', 'numeric'],
            'subscription_privileges' => ['required', 'min:20'],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg',
                'max:4000',
                'dimensions:min_width=1200,min_height=500,max_width:4000,max_height=1000',
            ],
        ]);

        if ($validator->fails()) {
            return redirect(route('channel.edit'))
                ->withInput()
                ->withErrors($validator);
        }

        try {
            $subscription_price = $request->get('subscription_price');
            $channel = Channel::where('user_id', \Auth::user()->id)->first();
            $newChannell = false;
            if (!$channel) {
                $newChannell = true;
                $channel = new Channel();
                $channel->user_id = \Auth::user()->id;
                $channel->active = true;
                $channel->save();
            }
            $pack = Pack::updateOrCreate(
                [
                    'user_id' => \Auth::user()->id,
                    'price' => $subscription_price,
                ]
            );
            $pack->privileges = $request->get('subscription_privileges');
            $pack->save();
            $channel->active = true;
            $channel->pack_id = $pack->id;
            // (1830 x 270)
            if ($request->cover_image) {

                // Delete old cover
                Storage::disk('s3')->delete('channel_covers/' . $channel->cover_image);

                $cover_image_path = 'cover_image/' . time() . Str::random(10, 100) . '.' . $request->file('cover_image')->getClientOriginalExtension();

                // Resize picture to 1200 width
                $cover_image = Image::make($request->file('cover_image'))->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
                
                $original_height = $cover_image->height();
                $y = intval(($original_height - 300) / 2);

                $cover_image = Image::make($cover_image)->crop(1200, 300, 0, $y, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode();
       

                Storage::disk('s3')->put($cover_image_path, $cover_image, 'public');
                $channel->cover_image = Storage::disk('s3')->url($cover_image_path);
            }
            $channel->save();
        } catch (Exception $e) {
            return redirect(route('channel.edit'))->withErrors([
                //'Operation failed.',
                $e->getMessage()
            ]);
        }
        if ($newChannell) {
            return redirect(route("channel.active4"));
        } else {
            return redirect(route("channel"));
        }

    }
}
