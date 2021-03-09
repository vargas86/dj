<li class='@if($notification->viewed)viewed @endif'>
    <h6><a class="notification-url" data-notification-id="{{$notification->id}}"
            href="{{$notification->target_url}}">{{$notification->title}}</a></h6>
    <p>{{$notification->message}}</p>
</li>