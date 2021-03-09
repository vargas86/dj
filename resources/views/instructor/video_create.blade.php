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
            <h2>New video</h2>

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
                    <label for="title">Upload video</label>
                    <input class="form-control" type="file" name="video" id="video">
                    <div class="ajax-progress" id="ajax_progress">
                        {{-- <div class="progress">
                            <div class="bar" style="width: 30%"></div>
                        </div>
                        <div class="ajax-error">
                            <i class="uil uil-info-circle"></i>
                            <small>There was an issue uploading your video.</small>
                        </div> --}}
                        {{-- <div class="ajax-success">
                            <i class="uil uil-check-circle"></i>
                            <small>Upload complete</small>
                        </div> --}}
                    </div>
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
                    <input type="submit" value="Submit video" class="bt bt-1 bt-block">
                </div>
            </form>    
        </div>
    </div>
</main>
@stop

@section("script")
    <script src="/js/video_upload.js"></script>
@stop

