<div class="message">
    <div class="heading">
        <div class="img">
            <img src="{{$message->user->avatar}}" alt="{{$message->user->name}}">
        </div>
        <h5>{{$message->user->name}}</h5>
    </div>
    <div class="row">
        <div class="col-8">
            <p>{{$message->message}}</p>
        </div>
        <div class="col-4">
            <p>{{$message->created_at->format('H:i:s')}}</p>
        </div>
    </div>

</div>