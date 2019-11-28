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


