@foreach ($topics as $topic)
    <ul class="sub-topic">
        @if($topic->child->count())
            <li><a href="{{ route('topic', ['path' => $topic->path]) }}"><i class="uil uil-angle-down"></i>{{ $topic->title }}</a></li>
            <li class="topic-items"><x-topics parent="{{ $topic->id }}" /></li>
        @else
            <li><a href="{{ route('topic', ['path' => $topic->path]) }}">{{ $topic->title }}</a></li>
        @endif
    </ul>
@endforeach
