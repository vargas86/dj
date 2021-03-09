const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({
    node: {
        fs: "empty"
    }
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/video.js', 'public/js')
    .js('resources/js/datepicker.js', 'public/js')
    .js('resources/js/manage_courses.js', 'public/js')
    .js('resources/js/courses_list.js', 'public/js')
    .js('resources/js/manage_streams.js', 'public/js')
    .js('resources/js/gallery.js', 'public/js')
    .js('resources/js/subscriptions.js', 'public/js')
    .js('resources/js/video_upload.js', 'public/js')
    .js('resources/js/video_chat.js', 'public/js')
    .js('resources/js/profile_edit.js', 'public/js')
    .js('resources/js/comment.js', 'public/js')
    .js('resources/js/live_list.js', 'public/js')
    .js('resources/js/channel_schedule.js', 'public/js')
    .js('resources/js/stream-client/modules/mediasoupclient.min.js', 'public/js')
    .js('resources/js/stream-client/RoomClient.js', 'public/js')
    .js('resources/js/stream.js', 'public/js')
    .js('resources/js/watch_stream.js', 'public/js')
    .js('resources/js/StudentRoomClient.js', 'public/js')
    .js('resources/js/notifications.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/gallery.scss', 'public/css')
    .sass('resources/sass/datepicker.scss', 'public/css')
    .sass('resources/sass/plyr.scss', 'public/css')
    .sass('resources/sass/sweetalert2.scss', 'public/css');
