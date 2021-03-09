<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

\Illuminate\Support\Facades\URL::forceScheme('https');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'manager'], function () {
    Voyager::routes();
});

Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', '\App\Actions\Web\Pages\Home')->name('home');
Route::get('/about', '\App\Actions\Web\Pages\About')->name('about');
Route::get('/privacy-policy', '\App\Actions\Web\Pages\PrivacyPolicy')->name('privacy.policy');
Route::get('/terms-of-service', '\App\Actions\Web\Pages\TermsOfService')->name('terms.of.service');
Route::get('/contact', '\App\Actions\Web\Pages\Contact')->name('contact');

// Stripe webhook
Route::post('/webhook/QuPil0UJxgoN4uUVesaP', '\App\Actions\Webhook\Stripe')->name('stripe.webhook');

// Guest
//Channel
Route::get('/channels', '\App\Actions\Web\Guest\Channel\Listing')->name('channel.list');
Route::get('/channel/{channel}/courses', '\App\Actions\Web\Guest\Channel\About\Courses')->name('channel.course');
Route::get('/channel/{channel}/videos', '\App\Actions\Web\Guest\Channel\About\Videos')->name('channel.videos');
Route::get('/channel/{channel}/about', '\App\Actions\Web\Guest\Channel\About\About')->name('channel.about');
Route::get('/channel/{channel}/schedule', '\App\Actions\Web\Guest\Channel\About\Schedule')->name('channel.schedule');
Route::get('/channel/{channel}/gallery', '\App\Actions\Web\Guest\Channel\About\Gallery')->name('channel.gallery');
Route::get('/video/{video_slug}', '\App\Actions\Web\Member\Channel\Video\Watch')->name('video.watch');
Route::get('/course/{course_slug}/{video_slug?}', '\App\Actions\Web\Member\Channel\Course\Watch')->name('course.watch');
//Live
Route::group(['prefix' => 'live'], function () {
    Route::get('/{live_slug}', '\App\Actions\Web\Guest\Live\Details')->name('live.details');
    Route::post('/{live_slug}/chat', '\App\Actions\Web\Guest\Live\Chat\Create')->name('live.chat');
    Route::get('/{live_slug}/chat/{message_id}/', '\App\Actions\Web\Guest\Live\Chat\Details')->name('chat.details');
});

//Search
Route::get('/search/{keyword}', '\App\Actions\Web\Guest\Search\Index')->name('search');
Route::get('/search/video/{keyword}', '\App\Actions\Web\Guest\Search\VideoSearch')->name('search.video');
Route::get('/search/course/{keyword}', '\App\Actions\Web\Guest\Search\CourseSearch')->name('search.course');

//Courses
Route::get('/courses', '\App\Actions\Web\Guest\Course\Index')->name('courses');
Route::get('/courses/popular', '\App\Actions\Web\Pages\PopularCourses')->name('popular.courses');
Route::get('/courses/newest', '\App\Actions\Web\Pages\NewestCourses')->name('newest.courses');
Route::get('/video', '\App\Actions\Web\Guest\Video\Index')->name('guest.video.list');
Route::get('/courses/watch/{course_slug}', '\App\Actions\Web\Guest\Course\View')->name('course.view');

//gallery
Route::get('/profile/gallery/show', '\App\Actions\Web\Member\Channel\Gallery\Show')->name('gallery.show');

//Notification
Route::post('/notification/{notification_id}/viewed', '\App\Actions\Web\Guest\Notification\Viewed');
Route::get('/notification/{notification_id}', '\App\Actions\Web\Guest\Notification\Details');
Route::post('/member/notification', '\App\Actions\Web\Member\Notification\Submit');

//Topic
Route::get('/videos/topic/{path}', '\App\Actions\Web\Guest\Topic\View')->where('path', '.*')->name('topic.view');
Route::get('/courses/topic/{path}', '\App\Actions\Web\Guest\Topic\Courses')->where('path', '.*')->name('courses.topic');

Route::group(['prefix' => 'member', 'middleware' => ['auth']], function () {

    // Comment
    Route::post('/comment/{video_slug}', '\App\Actions\Web\Member\Comment\Submit')->name('comment.submit');

    // Stripe
    Route::post('/create-checkout-session', '\App\Actions\Web\Member\Stripe\CreateChekoutSession')->name('checkout_session.create');

    Route::group(['prefix' => 'channel'], function () {

        //User channel 
        Route::get('/', '\App\Actions\Web\Member\Channel\Course\Index')->name('channel');
        Route::get('/edit', '\App\Actions\Web\Member\Channel\Edit')->name('channel.edit');
        Route::post('/create', '\App\Actions\Web\Member\Channel\Create')->name('channel.create');
        Route::post('/update', '\App\Actions\Web\Member\Channel\Update')->name('channel.update');
        Route::get('/delete', '\App\Actions\Web\Member\Channel\Delete')->name('channel.delete');
        Route::get('/disabled', '\App\Actions\Web\Member\Channel\Desabled')->name('channel.desabled');
        Route::get('/enabled', '\App\Actions\Web\Member\Channel\Enabled')->name('channel.enabled');

        // User section
        Route::group(['prefix' => 'section'], function () {
            Route::get('/{section_id}/edit', '\App\Actions\Web\Member\Channel\Course\Section\Edit')->name('section.edit');
            Route::get('/{section_id}/remove', '\App\Actions\Web\Member\Channel\Course\Section\Remove')->name('section.remove');
            Route::post('/{section_id}/update', '\App\Actions\Web\Member\Channel\Course\Section\Update')->name('section.update');
        });


        //Channel active 
        Route::get('/active/1', function () {
            return view('member.channel.activate_1');
        })->name('channel.active1');

        Route::get('/active/2', function () {
            return view('member.channel.activate_2');
        })->name('channel.active2');

        Route::get('/active/3', function () {
            return view('member.channel.activate_3');
        })->name('channel.active3');

        Route::get('/active/4', function () {
            return view('member.channel.activate_4');
        })->name('channel.active4');


        // Subscription
        Route::post('/channel/subscribe/{channel_id}', '\App\Actions\Web\Member\Channel\Subscribe')->name('channel.subscribe');
        Route::get('/subscription/{channel}', '\App\Actions\Web\Guest\Subscription\Subscription')->name('subscribe');
        Route::get('/reactivate/{channel}', '\App\Actions\Web\Member\Profile\Subscriptions\Reactivate')->name('subscription.reactivate');

        //User Courses
        Route::get('/courses/create', '\App\Actions\Web\Member\Channel\Course\Create')->name('course.create');
        Route::get('/courses/{course_slug}', '\App\Actions\Web\Member\Channel\Course\Manage@handle')->name('course.manage');
        Route::get('/courses/{course_slug}/edit', '\App\Actions\Web\Member\Channel\Course\Edit@handle')->name('course.edit');
        Route::post('/courses/submit', '\App\Actions\Web\Member\Channel\Course\Submit')->name('course.submit');
        Route::post('/courses/{course_slug}/update', '\App\Actions\Web\Member\Channel\Course\Update@handle')->name('course.update');
        Route::get('/courses/{course_slug}/remove', '\App\Actions\Web\Member\Channel\Course\Remove@handle')->name('course.remove');
        // Route::post('/courses/search', '\App\Actions\Web\Member\Channel\Course\Search@handle')->name('course.search');

        //User Section
        Route::post('/courses/{course_slug}/section/submit', '\App\Actions\Web\Member\Channel\Course\Section\Submit@handle')->name('section.submit');

        Route::group(['prefix' => 'videos'], function () {
            //User Videos
            Route::get('/', '\App\Actions\Web\Member\Channel\Video\Listing')->name('video.list');
            // Route::get('/create/{course_slug?}/{section_id?}', '\App\Actions\Web\Member\Channel\Video\Create')->name('video.create');
            Route::post('/submit/{course_slug?}/{section_id?}', '\App\Actions\Web\Member\Channel\Video\Submit')->name('video.submit');
            Route::get('/{video_slug}/edit/{course_slug?}/{section_id?}', '\App\Actions\Web\Member\Channel\Video\Edit')->name('video.edit');
            Route::post('/{video_slug}/update/{course_slug?}/{section_id?}', '\App\Actions\Web\Member\Channel\Video\Update')->name('video.update');
            Route::get('/{video_slug}/remove/{course_slug?}/{section_id?}', '\App\Actions\Web\Member\Channel\Video\Remove@handle')->name('video.remove');
            Route::post('/upload/{course_slug?}/{section_id?}', '\App\Actions\Web\Member\Channel\Video\Upload')->name('video.upload');
        });
        //User Lives
        Route::get('/live', '\App\Actions\Web\Member\Channel\Live\Listing')->name('live');
        Route::get('/live/create', '\App\Actions\Web\Member\Channel\Live\Create')->name('live.create');
        Route::post('/live/submit', '\App\Actions\Web\Member\Channel\Live\Submit')->name('live.submit');
        Route::get('/live/{live_id}', '\App\Actions\Web\Member\Channel\Live\Stream')->name('live.stream');
        Route::get('/live/{live_id}/edit', '\App\Actions\Web\Member\Channel\Live\Edit@handle')->name('live.edit');
        Route::get('/live/{live_id}/remove', '\App\Actions\Web\Member\Channel\Live\Remove@handle')->name('live.delete');
        Route::post('/live/{live_id}/update', '\App\Actions\Web\Member\Channel\Live\Update@handle')->name('live.update');
        Route::get('/share_viewer_cam', '\App\Actions\Web\Member\Channel\Live\ShareViewerCam')->name('live.share_viewer_cam');
        Route::get('/stop_shared_cam', '\App\Actions\Web\Member\Channel\Live\StopSharedCam')->name('live.stop_shared_cam');
        Route::get('/end_stream', '\App\Actions\Web\Member\Channel\Live\EndStream')->name('live.end_stream');

        // User Sections Reodrder
        Route::post('/course/sections/reorder', '\App\Actions\Web\Member\Channel\Course\Section\Order')->name('section.order');

        // User Videos Reorder
        Route::post('/course/video/reorder', '\App\Actions\Web\Member\Channel\Course\Video\Order')->name('video.order');
    });



    Route::group(['prefix' => 'profile'], function () {

        // Usert Profile
        Route::get('/', '\App\Actions\Web\Member\Profile\Details')->name('profile');
        Route::get('/edit', '\App\Actions\Web\Member\Profile\Edit')->name('profile.edit');
        Route::post('/update', '\App\Actions\Web\Member\Profile\Update')->name('profile.update');
        Route::get('/delete', '\App\Actions\Web\Member\Profile\Delete')->name('profile.delete');
        Route::get('/subscriptions', '\App\Actions\Web\Member\Profile\Subscriptions\Index')->name('profile.subscriptions');
        Route::get('/subscriptions/create', '\App\Actions\Web\Member\Profile\Subscriptions\Create')->name('subscription.create');
        Route::get('/subscriptions/unsubscribe/{channel_id}', '\App\Actions\Web\Member\Profile\Subscriptions\Unsubscribe')->name('subscription.unsubscribe');


        // User Gallery
        Route::post('/gallery', '\App\Actions\Web\User\Gallery\Submit')->name('submit.gallery');
        Route::get('/gallery/remove/{gallery_id}', '\App\Actions\Web\User\Gallery\Delete')->name('delete.gallery');
        Route::get('/gallery/index', '\App\Actions\Web\Member\Channel\Gallery\Index')->name('gallery.index');
    });
});


Route::get('/live', function () {
    return view('live');
})->middleware('auth');




/**********************************************************
 * User
 *********************************************************/
Route::group(['prefix' => 'user'], function () {

    // Verefiy email
    Route::get('/email/confirm/{email}/{token}', '\App\Actions\Web\User\ConfirmEmail')->name('user_confirm_email');

    // Live
    Route::get('lives', function () {
        return view('user/lives');
    });
});

// Video
Route::group(['prefix' => 'video'], function () {
    Route::post('/', '\App\Actions\Web\Video\Upload')->name('video_upload');
});
