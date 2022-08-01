<?php

use Illuminate\Http\Request;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//login and register
Route::post('/login', 'api\LoginController@login');
Route::post('/signup', 'api\RegisterController@register');
Route::post('/signup/payment', 'api\RegisterController@inititatePayment');
Route::get('/signup/payment/successful/{ref}', 'api\RegisterController@paymentSuccessful')->name('api.register.payment.successful');

//course to content
Route::get('/users/courses', 'api\UserController@courses')->middleware('auth:api');
Route::resource('/courses', 'api\CourseController')->only('index', 'show');
Route::resource('/topics', 'api\TopicController')->only('show')->middleware('auth:api');
Route::resource('/contents', 'api\ContentController')->only('show')->middleware('auth:api');

//assignments
Route::resource('/subjects.assignments', 'api\AssignmentController')->only('index')->middleware('auth:api');
Route::get('/assignments/{id}/download', 'api\AssignmentController@download')->middleware('auth:api');
Route::post('/assignments/{id}/answer/upload', 'api\AssignmentController@storeAnswer')->middleware('auth:api');
Route::resource('/assignments', 'api\AssignmentController')->only('show')->middleware('auth:api');

//discussions
Route::resource('/subjects.discussions', 'api\DiscussionController')->only('index', 'store')->middleware('auth:api');
Route::post('/discussions/{id}/comment', 'api\DiscussionController@comment')->middleware('auth:api');
Route::resource('/discussions', 'api\DiscussionController')->only('show')->middleware('auth:api');

//notifications
Route::resource('/notifications', 'api\NotificationController')->only('index')->middleware('auth:api');

//chatroom
Route::get('/chat_room/create/{id}', 'api\ChatRoomController@create')->name('chat_room.create')->middleware('auth:api');
Route::resource('/chat_room', 'api\ChatRoomController')->except('create')->middleware('auth:api');

//teachers
Route::resource('teachers', 'api\UserTeacherController')->only('index')->middleware('auth:api');

Route::resource('ratings', 'api\TeacherRatingController')->only('store')->middleware('auth:api');

Route::resource('courses.results', 'api\CourseResultController')->only('index')->middleware('auth:api');

Route::resource('feedbacks', 'api\FeedbackController')->only('store')->middleware('auth:api');

Route::resource('chapters.answers', 'api\ChapterAnswerController')->only('create', 'store')->middleware('auth:api');