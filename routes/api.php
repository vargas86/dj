<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */


/**********************************************************
 * Not protected
 *********************************************************/
/**
 *  User
 */
Route::group(['prefix' => 'user', 'namespace' => 'api'], function () {

    // Rgister
    Route::post('register', 'MemberController@register')->name('user_register');

    // Login
    Route::post('login', 'MemberController@login')->name('user_login');

    // Send Reset Password Request
    Route::post('reset', 'MemberController@sendresetpassword')->name('user_sendresetpassword');

    // Reset Password
    Route::post('resetpassword', 'MemberController@resetpassword')->name('user_resetpassword');

    // Verify E-mail
    Route::post('verifyemail', 'MemberController@verifyemail')->name('user_verify_email');
});

/********************************************************
 * Protected Area
 ********************************************************/
Route::group(['middleware' => ['jwt']], function () {

    /**
     *  Member
     */
    Route::group(['prefix' => 'user', 'namespace' => 'api'], function () {

        // Logout
        Route::post('logout', 'MemberController@logout')->name('user_logout');

        // Refresh
        Route::post('refresh', 'MemberController@refresh')->name('user_refresh');

        // Profile
        Route::get('/', 'MemberController@profile')->name('user_profile');

        // Update
        Route::put('/', 'MemberController@update')->name('user_update')->middleware('verifiedapi');


        // Change E-mail
        Route::put('changeemail', 'MemberController@changeemail')->name('user_changeemail');

        // Change Language
        Route::put('language', 'MemberController@changelanguage')->name('user_changelanguage');

        // Change Avatar
        Route::post('avatar', 'MemberController@changeavatar')->name('user_changeavatar');
    });
});



// Guest videos
Route::group(['prefix' => 'video', 'middleware' => ['jwt']], function () {
    Route::get('/{video_slug}/{course_slug?}/{section_id?}', '\App\Actions\API\Guest\Video\Details');
});
Route::group(['prefix' => 'video'], function () {
    Route::get('/', '\App\Actions\API\Guest\Video\Index');
});


Route::group(['prefix' => 'member', 'middleware' => ['jwt']], function () {

    Route::group(['prefix' => 'user'], function () {
        // Usert Profile
        Route::put('/', '\App\Actions\API\Member\Profile\Update');
        Route::post('/avatar', '\App\Actions\API\Member\Profile\Avatar');
        Route::delete('/', '\App\Actions\API\Member\Profile\Delete');
        Route::get('/', '\App\Actions\API\Member\Profile\Details');
        // Change Password
        Route::put('password', '\App\Http\Controllers\api\MemberController@changepassword')->name('user_changepassword');

        Route::group(['prefix' => 'subscription'], function () {
            Route::get('/', '\App\Actions\API\Member\Profile\Subscription\Index');
        });
    });

    // User Gallery
    Route::group(['prefix' => 'gallery'], function () {
        Route::post('/', '\App\Actions\API\User\Gallery\Submit');
        Route::delete('/{gallery_id}', '\App\Actions\API\User\Gallery\Delete');
        Route::get('/', '\App\Actions\API\Member\Channel\Gallery\Index');
    });

    //User channel 
    Route::group(['prefix' => 'channel'], function () {
        Route::put('/', '\App\Actions\API\Member\Channel\Update');
        Route::delete('/', '\App\Actions\API\Member\Channel\Delete');
        Route::put('/disable', '\App\Actions\API\Member\Channel\Disable');
        Route::put('/enable', '\App\Actions\API\Member\Channel\Enable');
        Route::get('/', '\App\Actions\API\Member\Channel\Details');
        Route::post('/', '\App\Actions\API\Member\Channel\Create');
    });


    //User Courses
    Route::post(
        '/courses',
        '\App\Actions\API\Member\Channel\Course\Submit'
    );
    Route::get('/courses/{course}', '\App\Actions\API\Member\Channel\Course\Manage@handle');
    Route::put('/courses/{course}', '\App\Actions\API\Member\Channel\Course\Update@handle');
    Route::delete('/courses/{course}', '\App\Actions\API\Member\Channel\Course\Remove@handle');
    Route::get('/course/{slug}/details', '\App\Actions\API\Member\Channel\Course\Details');
    Route::get('/courses', '\App\Actions\Web\Member\Channel\Course\Index');

    //User Section
    Route::post('/courses/{course}/section/submit', '\App\Actions\API\Member\Channel\Course\Section\Submit@handle');


    //User Videos
    Route::group(['prefix' => 'video'], function () {
        Route::get('/', '\App\Actions\API\Member\Channel\Video\Listing');
        // Route::post('/{course_slug?}/{section_id?}', '\App\Actions\API\Member\Channel\Video\Submit');
        Route::put('/{video_slug}', '\App\Actions\API\Member\Channel\Video\Update');
        Route::post('/', '\App\Actions\API\Member\Channel\Video\Create');
        Route::post('/{video_slug}/preview', '\App\Actions\API\Member\Channel\Video\Thumbnail');
        Route::delete('/{video_slug}', '\App\Actions\API\Member\Channel\Video\Remove');
        Route::get('/{video_slug}', '\App\Actions\API\Member\Channel\Video\Details');
    });

    //User Lives
    Route::get('/live', '\App\Actions\API\Member\Channel\Live\Listing');
    Route::post('/live/submit', '\App\Actions\API\Member\Channel\Live\Submit');
    Route::get('/live/{stream}', '\App\Actions\API\Member\Channel\Live\Stream@handle');
    Route::post('/live/{stream}/update', '\App\Actions\API\Member\Channel\Live\Update@handle');
    Route::get('/share_viewer_cam', '\App\Actions\API\Member\Channel\Live\ShareViewerCam');
    Route::get('/stop_shared_cam', '\App\Actions\API\Member\Channel\Live\StopSharedCam');
    Route::get('/end_stream', '\App\Actions\API\Member\Channel\Live\EndStream');



    // User Sections Reodrder
    Route::post('/course/sections/reorder', '\App\Actions\API\Member\Channel\Course\Section\Order');

    // User Videos Reorder
    Route::post('/course/video/reorder', '\App\Actions\API\Member\Channel\Course\Video\Order');



    //subscribe
    Route::post('/channel/subscribe/{channel}', '\App\Actions\API\Member\Subscription\Submit');
});


// Guest API
//Channel
Route::group(['prefix' => 'channel'], function(){
    Route::get('/', '\App\Actions\API\Guest\Channel\Index');
});
Route::get('/{channel}/courses', '\App\Actions\API\Guest\Channel\Courses');
Route::get('/channel/{channel}/videos', '\App\Actions\API\Guest\Channel\Videos');
Route::get('/channel/{channel}/about', '\App\Actions\API\Guest\Channel\About');
Route::get('/channel/{channel}/schedule', '\App\Actions\API\Guest\Channel\Schedule');
Route::get('/channel/{channel}/gallery', '\App\Actions\API\Guest\Channel\Gallery');
Route::get('/channel/{channel_id}', '\App\Actions\API\Guest\Channel\Details');

// instructors
Route::get('/instructors', '\App\Actions\API\Guest\Instructors\Instructor');

// Subscription
Route::get('/channel/subscription/{channel}', '\App\Actions\API\Guest\Subscription\Subscription');

//Courses
Route::get('/courses', '\App\Actions\API\Guest\Course\Index');
Route::get('/courses/watch', '\App\Actions\API\Guest\Course\View');

//Topic
Route::get('/topic/{path}', '\App\Actions\API\Guest\Topic\View')->where('path', '.*');
