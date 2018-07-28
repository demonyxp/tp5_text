<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
use think\Route;

//定义路由规则
Route::get("/",'admin/index/index');
Route::get("left",'admin/index/left');
Route::get("top",'admin/index/top');
Route::get("main",'admin/index/main');
Route::any("login",'admin/public/login');
Route::any("logout",'admin/public/logout');

Route::any('test/index','admin/test/index');

Route::group('admin',function(){
	#分类相关
	Route::any("category/add",'admin/category/add');
	Route::get("category/index",'admin/category/index');
	Route::any("category/upd",'admin/category/upd');
	Route::get('category/ajaxDel', 'admin/category/ajaxDel');
	#文章相关
	Route::any('article/index', 'admin/article/index');
	Route::any('article/add', 'admin/article/add');
});
