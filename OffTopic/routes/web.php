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

Route::get('/', 'HomeController@index');

Auth::routes();

// Posts Controller
Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'PostsController@index');
    Route::get('/create', 'PostsController@create');
    Route::get('/{id}', 'PostsController@show')->name('blog');
    Route::get('/{id}/edit', 'PostsController@edit');

    Route::delete('/{id}/delete', 'PostsController@destroy');
    Route::post('/store', 'PostsController@store')->name('store');
    Route::put('/{id}/update', 'PostsController@update')->name('update');
});


// Posts Comments Controller
Route::post('/blog/{id}/comment/create', 'PostCommentController@store');
Route::delete('/blog/{postId}/comment/{commentId}/delete', 'PostCommentController@destroy');
// AJAX for comment edit & update
Route::get('/comment/{id}/edit', 'PostCommentController@edit');
Route::put('/comment/update', 'PostCommentController@update');


// User Profile Controller
Route::group(['prefix' => 'users/profile'], function() {
    Route::get('/', 'UserProfileController@index'); //show little form to type id or name and get redirected to specific user profile
    Route::get('/{id}', 'UserProfileController@show');
    Route::get('/{id}/edit', 'UserProfileController@edit');
    Route::post('/{id}/update', 'UserProfileController@createOrUpdate');
    Route::delete('/{id}/delete', 'UserProfileController@destroy');
});


// Friend Requests Controller
//  AJAX for create and delete
Route::get('/friend-request/{id}/create', 'FriendRequestsController@store');
Route::get('/friend-request/{id}/delete', 'FriendRequestsController@destroy');


// Notifications & Friend List Controllers
Route::group(['prefix' => '/users'], function() {

    // Notifications Controller
    Route::get('/{id}/notifications', 'NotificationsController@index');
    // AJAX for Clear button and "single delete" button
    Route::get('/{id}/notifications/clear', 'NotificationsController@deleteAllNotifications');
    Route::get('/{id}/notifications/{notificationId}/delete/{hardOrSoft}', 'NotificationsController@deleteNotificationSoftOrHard');


    // Friend List Controller
    // AJAX for Unfriend button in profile view
    Route::get('/delete-friendship/{userId}/delete', 'FriendListController@deleteFriendshipAndNotifications');
    // AJAX for Accept and Decline buttons in Notification view
    Route::get('/accept-friend-request/{requestedUserId}/{senderUserId}', 'FriendListController@store');
    Route::get('/decline-friend-request/{requestedUserId}/{senderUserId}', 'FriendListController@deleteFriendRequestAndNotification');
});


// About Me Controller
Route::get('/about-me', 'AboutMeController@index');