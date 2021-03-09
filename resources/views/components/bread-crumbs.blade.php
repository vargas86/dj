<div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-1 mb-2">
            <ul class="breadcrumbs">
                @foreach ($crumbs as $name => $path)
                    <li><a href="{{$path}}">{{$name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>