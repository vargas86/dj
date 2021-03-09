@extends('layouts.app')

@section('head')
{{-- 
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('pk_test_51HyEKeH8lKAxcwKmYpz0yzc8KQnaZbLB7NdpnuaC16DCxry5Qr4D1TOPZb6XCVHJrsk4N5pA3M7VbkGo0mMHfDDO00jHABcRf8');
    var elements = stripe.elements();
</script>
--}}
@stop

@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    " $instructor->lastname $instructor->firstname " => route('channel.course' , ['channel' => $instructor->channel()->id]),
    'Subscribe' => route('subscribe', ['channel' => $instructor->channel()->id])
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="channel-subscribe">
                    <div class="sub-header">
                        <div class="avatar">
                            <img src="{{ $instructor->avatar }}" alt="">
                        </div>
                        <h3>Subscribe to: {{ $instructor->firstname." ".$instructor->lastname }}</h3>
                    </div>
                    <div class="sub-formula selected">
                        <label for="formula_1">
                            {{--<h4>Monthly Subscription</h4>
                            <p class="price"><sup>${{number_format( (float) $pack->price, 2, '.', '')}}</sup></p>
                            --}}
                            {!! nl2br($pack->privileges) !!}
                        </label>
                        {{-- <input type="radio" id="formula_1" checked> --}}
                    </div>
                    <button class="bt bt-1 bt-block" id="subscribe">
                        Complete subscription
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- 
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{env("STRIPE_PUBLISHABLE_KEY")}}');
        var createCheckoutSession = function(packId , channelId) {
            return fetch("{{route('checkout_session.create')}}", {
                method: "POST",
                headers: {
                "Content-Type": "application/json"
                },
                body: JSON.stringify({
                _token: '{{csrf_token()}}',
                packId: packId,
                channelId: channelId,
                })
            }).then(function(result) {
                return result.json();
            });
            };

            document
                .getElementById("subscribe")
                .addEventListener("click", function(evt) {
                    createCheckoutSession('{{$pack->id}}', '{{$channel->id}}').then(function(data) {
                    // Call Stripe.js method to redirect to the new Checkout page
                    stripe
                        .redirectToCheckout({
                        sessionId: data.sessionId
                        })
                        .then(function(result){
                            console.log(result);
                        });
                    });
                });
</script>
--}}
@stop

@section('script')
<script>
document.getElementById("subscribe").addEventListener("click", function(evt) {
    var channelUrl = "{{ route('channel.course', ['channel' => $instructor->channel()->id]) }}" ;
    var csrfElement = document.querySelector('meta[name="csrf-token"]');
    if(csrfElement) {
        var csrf = csrfElement.getAttribute('content');

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "{{ route('channel.subscribe', ['channel_id' => $instructor->channel()->id]) }}", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrf);

        xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                window.location.replace(channelUrl) ; 
            }
        }
        xhr.send();
    }
});
</script>

{{-- 
<script>
    var style = {
        base: {
            color: '#32325D',
            fontWeight: 500,
            fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
            fontSize: '16px',
            fontSmoothing: 'antialiased',

            '::placeholder': {
                color: '#CFD7DF',
            },
            ':-webkit-autofill': {
                color: '#e39f48',
            },
            },
            invalid: {
            color: '#E25950',

            '::placeholder': {
                color: '#FFCCA5',
            },
        },
    };

    var card = elements.create('card', {
        iconStyle: 'solid',
        style: style
    });
    card.mount('#card-element');
</script>
--}}
@stop