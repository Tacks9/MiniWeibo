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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'StaticPagesController@home')->name('home');
// name指定前端对应链接
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');


// 注册页面
Route::get('/signup', 'UsersController@create')->name('signup');

// ****************************登录登出*****************************************
// 显示登录页面
Route::get('login', 'SessionsController@create')->name('login');
// 创建新会话（登录）
Route::post('login', 'SessionsController@store')->name('login');
// 销毁会话（退出登录）
Route::delete('logout', 'SessionsController@destroy')->name('logout');


// 用户的激活功能
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');


// 显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// 密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

/************** 用户资源页面 *********************/
Route::resource('users', 'UsersController');
// 等同下面的
//---------------------------------读取-----------------------------------
// 显示所有用户列表的页面
// Route::get('/users',       'UsersController@index')->name('users.index');
// // 显示某个用户
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');

// //--------------------------------新增-------------------------------------
// // 新增页面
// Route::get('/users/create', 'UsersController@create')->name('users.create');
// // 新增提交
// Route::post('/users',        'UsersController@store')->name('users.store');

// // ------------------------------更新--------------------------------------
// // 修改页面
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
// // 修改提交
// Route::patch('/users/{user}',  'UsersController@update')->name('users.update');

// // ------------------------------删除------------------------------------------------
// // 删除
// Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');


