<?php 
namespace app\admin\model;
use think\Model;
/**
 * 用户表
 */
class User extends Model
{
	/**
	 * 检测用户名和密码是否匹配的方法
	 * @param  [type] $username 用户名
	 * @param  [type] $password 密码(明文)
	 * @return [type] 成功 返回true 失败返回false
	 */
	public function checkUser($username,$password)
	{
		$where = [
			'username' => $username,
			'password' => md5($password.config('password_salt')),
		];
		$userInfo = $this->where($where)->find();//检查数据库中是否匹配账号密码
		if ($userInfo) {
			//用户信息储存到session中去
			session('user_id', $userInfo['user_id']);
			session('username', $userInfo['username']);
			return true;
		}else {
			return false;
		}
	}
}
