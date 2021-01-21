<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

// Posts Controller
Route::get('/blog', 'PostsController@index');
Route::get('/blog/create', 'PostsController@create');
Route::get('/blog/{id}', 'PostsController@show')->name('blog');
Route::get('/blog/{id}/edit', 'PostsController@edit');

Route::delete('/blog/{id}/delete', 'PostsController@destroy');
Route::post('/blog/store', 'PostsController@store')->name('store');
Route::put('/blog/{id}/update', 'PostsController@update')->name('update');

// Posts Comments Controller
Route::post('/blog/{id}/comment/create', 'PostCommentController@store');
Route::delete('/blog/{postId}/comment/{commentId}/delete', 'PostCommentController@destroy');
// AJAX for comment edit & update
Route::get('/comment/{id}/edit', 'PostCommentController@edit');
Route::put('/comment/update', 'PostCommentController@update');

// User Profile Controller
Route::get('/users/profile', 'UserProfileController@index'); //show little form to type id or name and get redirected to specific user profile
Route::get('/users/profile/{id}', 'UserProfileController@show');
Route::get('/users/profile/{id}/edit', 'UserProfileController@edit');
Route::post('/users/profile/{id}/update', 'UserProfileController@createOrUpdate');
Route::delete('/users/profile/{id}/delete', 'UserProfileController@destroy');

// Friend Requests Controller
//  AJAX for create and delete
Route::get('/friend-request/{id}/create', 'FriendRequestsController@store');
Route::get('/friend-request/{id}/delete', 'FriendRequestsController@destroy');


// Notifications Controller
Route::get('/users/{id}/notifications', 'NotificationsController@index');
// AJAX for Clear button and "single delete" button
Route::get('/users/{id}/notifications/clear', 'NotificationsController@deleteAllNotifications');
Route::get('/users/{id}/notifications/{notificationId}/delete/{hardOrSoft}', 'NotificationsController@deleteNotificationSoftOrHard');


// Friend List Controller
// AJAX for Unfriend button in profile view
Route::get('/users/delete-friendship/{userId}/delete', 'FriendListController@deleteFriendshipAndNotifications');
// AJAX for Accept and Decline buttons in Notification view
Route::get('/users/accept-friend-request/{requestedUserId}/{senderUserId}', 'FriendListController@store');
Route::get('/users/decline-friend-request/{requestedUserId}/{senderUserId}', 'FriendListController@deleteFriendRequestAndNotification');