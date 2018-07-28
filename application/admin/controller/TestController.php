<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class TestController extends Controller
{
	public function index()
	{
		echo md5("123456".config('password_salt'));die;
		dump( Db::table("tp_category")->select());
	}
}