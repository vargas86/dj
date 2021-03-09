@extends("layouts.app")

@section('content')

<main class="manage-courses">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="/member/channel/videos" class="bt bt-outline">
                        <i class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12">
            
            
            <h2>
                @if(isset($_GET["course"]))<span>Course: Boxing 101</span> <br>@endif
                Edit video
            </h2>

            <form action="" id="edit_course">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <textarea class="form-control" type="text"></textarea>
                </div>
                <div class="form-group">
                    <a href="/" target="_blank">
                        <i class="uil uil-video"></i>
                        Watch video
                    </a>
                </div>
                <div class="form-group">
                    <label for="cat">Category</label>
                    <select name="cat" id="cat" class="form-control" {{ isset($_GET["course"]) ? 'disabled' : '' }}>
                        <option value="" {{ !isset($_GET["course"]) ? ' selected disabled' : '' }}>Select a category</option>
                        <option value="" {{ isset($_GET["course"]) ? 'selected' : '' }}>Martial Arts</option>
                        <option value="">Fitness</option>
                        <option value="">Health</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sub_cat">Sub category</label>
                    <select name="sub_cat" id="sub_cat" class="form-control" {{ isset($_GET["course"]) ? 'disabled' : '' }}>
                        <option value="" {{ !isset($_GET["course"]) ? ' selected disabled' : '' }}>Select a sub category</option>
                        <option value="" {{ isset($_GET["course"]) ? 'selected' : '' }}>Brazilian Jiu-Jitsu</option>
                        <option value="">Boxing</option>
                        <option value="">Muay Thai</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lang">Language</label>
                    <select name="lang" id="lang" class="form-control" {{ isset($_GET["course"]) ? 'disabled' : '' }}>
                        <option value="" {{ !isset($_GET["course"]) ? ' selected disabled' : '' }}>Select a language</option>
                        <option value="en" {{ isset($_GET["course"]) ? 'selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="update information" class="bt bt-1 bt-block">
                </div>
            </form>    
        </div>
    </div>
</main>
@stop

