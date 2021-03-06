<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/{id}',['as'=>'post.detail','uses'=>'AdminPostsController@post']);

Route::resource('/admin/comments','PostCommentsController');

// Route::resource('/admin/comment/replies','CommentRepliesController');

Route::group(['middleware'=>['admin']],function(){
    
    Route::get('/admin','AdminDashboardController@index');

    Route::resource('/admin/users','AdminUsersController');

    Route::resource('/admin/posts','AdminPostsController');

    Route::resource('/admin/categories','AdminCategoriesController');

    Route::resource('/admin/medias','AdminMediasController');

    Route::post('/admin/medias/delete',['as'=>'medias.deletes','uses'=>'AdminMediasController@mediaDeletes']);

    

});

// Route::group(['middleware'=>['auth']],function(){

//     Route::post('/post/comment/{id}/reply',['as'=>'comment.reply','uses'=>'CommentRepliesController@replyComment']);
// });
Route::post('/post/comment/{id}/reply',['as'=>'comment.reply','uses'=>'CommentRepliesController@replyComment']);

// create by configure filemanager & intervention image upload
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

