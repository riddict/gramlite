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
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/liked', 'HomeController@liked');
Route::get('/{user}/feed/{maxid}', 'HomeController@userfeed');
Route::get('/{user}/feed', 'HomeController@userfeed');
Route::get('/follow', 'HomeController@follow');
Route::get('/viewcomment/{mediaid}', 'HomeController@viewComment');
Route::get('/commenting', 'HomeController@postComment');
Route::get('/{mediaid}/liked', 'HomeController@likemedia');
Route::any('/setting', 'HomeController@setting');
Route::get('/search', 'HomeController@search');
Route::get('/search/tags', function() {
	$account = App\instagramAccount::where('user_id', '=', Auth::user()->id)->first();
	$username = $account->username;
	$password = $account->password;
	$debug = false;
	$i = new \InstagramAPI\Instagram($debug);
	$i->setUser($username, $password);
	$profil = $i->getProfileData();
	$usernameinfo = $i->getSelfUsernameInfo();
    return view(Auth::user()->themes.'.searchtags', ['profil' => $profil, 'usernameinfo'=>$usernameinfo]);
    // return what you want
});
Route::get('/searchht', 'HomeController@searchTags');
Route::post('/add', 'HomeController@add');
Route::post('/likemedia', 'HomeController@likemedia');
Route::post('/bookmark', 'HomeController@addBookmark');
Route::post('/savesetting', 'HomeController@settingSaved');
Route::get('/delakun', 'HomeController@delAccount');
Route::get('/inbox', 'HomeController@inbox');
Route::get('/pending', 'HomeController@pendingInbox');
Route::get('/threadaction/{threadAction}/id/{threadId}', 'HomeController@threadAction');
Route::get('/thread/{threadId}', 'HomeController@thread');
Route::post('/sendmsg', 'HomeController@directMessage');
Route::get('/noti', 'HomeController@noti');
Route::get('/relogin', 'HomeController@relogin');
Route::get('/backup', 'HomeController@backup');