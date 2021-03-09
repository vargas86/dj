<?php

namespace App\Actions\Web\Member\Channel;

use App\Models\Channel;
use App\Models\Pack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Action;
use Stripe\Price;
use Image;
use Stripe\Product;
use Stripe\Stripe;
use Validator;
use Illuminate\Support\Str;

class Create extends Action
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
            'cover_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4000', 'dimensions:min_width=1220,min_height=180,max_width:2000,max_height:1000'],
        ]);
        if ($validator->fails()) {
            return redirect(route('channel.active3'))
                ->withInput()
                ->withErrors($validator);
        }
        try {
            $subscription_price = $request->get('subscription_price');
            $subscription_privileges = $request->get('subscription_privileges');
            $pack = new Pack();
            $pack->user_id = \Auth::user()->id;
            $pack->price = $subscription_price;
            $pack->privileges = $subscription_privileges;

            $nickname = \Auth::user()->firstname . ' ' . \Auth::user()->lastname;

            // Create Stripe product and price 
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $product = Product::create(['name' =>  'Subscription to ' . $nickname . "'s channel [" . auth()->user()->id . "]"]);
            $price = Price::create([
                'nickname' => $nickname,
                'product' => $product->id,
                'unit_amount' => $subscription_price * 100,
                'currency' => 'USD',
                'recurring' => [
                    'interval' => 'month',
                ],
            ]);
            $pack->price_stripe_id = $price->id;
            $pack->save();
            $channel = new Channel();
            $channel->user_id = \Auth::user()->id;
            $channel->pack_id = $pack->id;
            $channel->active = true;

            if ($request->cover_image) {
                
                $cover_image_path = 'cover_image/' . time() . \Str::random(10, 100) . '.' . $request->file('cover_image')->getClientOriginalExtension();

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
            return redirect(route('channel.active3'))->withErrors([
                // 'Operation failed.'
                $e->getMessage()
            ])->withInput();
        }
        return redirect(route("channel.active4"));
    }
}
