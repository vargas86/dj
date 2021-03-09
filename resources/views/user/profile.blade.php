@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="profile">

@component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        'Profile' => route('profile'),
    ]
])
@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <section class="user-info">
                <div class="img">
                    <img src="/images/placeholders/avatars/2.png" alt="">
                </div>
                <h3>Rani Yahya</h3>
                <ul class="info-list">
                    <li>
                        <a href="/subscriptions">
                            <i class="uil uil-graduation-cap"></i>
                            <strong>Active subscriptions:</strong> <span>5</span>
                        </a>
                    </li>
                    <li>
                        <i class="uil uil-user"></i>
                        <strong>Subscribers:</strong> <span>231</span>
                    </li>
                    <li>
                        <i class="uil uil-upload"></i>
                        <strong>Videos uploaded:</strong> <span>33</span>
                    </li>
                    <li>
                        <i class="uil uil-calendar-alt"></i>
                        <strong>Member since:</strong> <span>07/12/2020</span>
                    </li>
                    <li>
                        <i class="uil uil-map-marker"></i>
                        <strong>From:</strong> <span>United States</span>
                    </li>
                    <li>
                        <a href="/profile/edit">Edit profile</a>
                    </li>
                </ul>
                <hr>
                <article>
                    <h4>Biography</h4>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo soluta vero dolorum repellendus aspernatur sint quae, dicta maiores harum veniam laboriosam sapiente, totam ut, amet inventore tempore a officiis culpa! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus nostrum aperiam non consectetur, vero laudantium. Quae culpa repudiandae fugit, itaque laborum nemo doloremque aperiam corporis expedita magnam quisquam, officia unde.</p>
                </article>
                <a href="/profile/edit#bio_anchor">Edit Bio</a>
            </section>
            {{-- <section class="curriculum">
                <h2>Curriculum</h2>
                <div>
                    <h4>BJJ Blackbelt</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. In natus alias doloribus magni earum, reiciendis distinctio impedit repudiandae quisquam tenetur quam suscipit, rerum possimus. Repellendus aliquid eveniet voluptas deserunt praesentium?
                    </p>
                    <div class="date">
                        <i class="uil uil-calendar-alt"></i>
                        <strong>Obtained:</strong> 12/31/2020 
                    </div>
                </div>
                <div>
                    <h4>BJJ Blackbelt</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. In natus alias doloribus magni earum, reiciendis distinctio impedit repudiandae quisquam tenetur quam suscipit, rerum possimus. Repellendus aliquid eveniet voluptas deserunt praesentium?
                    </p>
                </div>
            </section> --}}
            <section class="revenue">
                <h3>Your revenue</h3>
                <ul class="profile-revenue">
                    <li><h3><span>Subscriptions:</span> 231</h3></li>
                    <li><h3><span>Current balance:</span> &dollar;2310</h3></li>
                    <li><h3><span>Withdrawn:</span> &dollar;4310</h3></li>
                    <li><h3><span>Total:</span> &dollar;6620</h3></li>
                </ul>
                <hr>
                <h3>Estimated income for this month</h3>
                <ul class="profile-revenue">
                    <li><h3><span>Estimate:</span> &dollar;310</h3></li>
                </ul>
            </section>
        </div>
        <div class="col-lg-8">
            <section class="gallery">
                <h2>Gallery</h2>
                <ul id="gallery_items" class="gallery-items">
                @for($i=1; $i <= 20; $i++)
                    <li>
                        <div class="delete" onClick="confirm('delete item?')">
                            <i class="uil uil-times"></i>
                        </div>
                        <img src="/images/placeholders/gallery/{{rand(1,6)}}.jpeg" alt="image">
                    </li>
                @endfor
                <li class="uploading" id="gallery_add">
                    <div class="progress">
                        <div class="bar" style="width: 20%"></div>
                    </div>
                </li>
                <li class="add-gallery" id="gallery_add">
                    <form action="">
                        <input type="file" name="gallery_file" id="gallery_file">
                    </form>
                </li>
                </ul>
            </section>
        </div>
    </div>
</div>
</main>
@stop

@section('script')
    <script src="/js/gallery.js"></script>
@stop
