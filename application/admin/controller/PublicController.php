<?php 
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use think\Validate;
class PublicController extends Controller{

    public function login(){
        //判断是否是post请求
        if(request()->isPost()){
            //接收参数
            $postData = input('post.');
            //验证数据是否合法（验证器去验证）
            //1.验证规则
            $rule = [
                //表单name名称 => 验证规则（多个用属性隔开）
                'username' => "require|length:3,8",
                'password' => "require",
                'captcha' => "require|captcha",
            ];
            //2.验证的错误信息
            $message = [
                //表单name名称.规则名 => '相应提示错误信息'
                'username.require' => '用户名必填',
                'username.length' => '用户名长度在3-8之前',
                'password.require' => '密码必填',
                'captcha.require' => '验证码必填',
                'captcha.captcha' => '验证码错误'
            ];
            //3.实例化验证器对象，开始验证
            $validate = new Validate($rule,$message);
            //4.判断是否验证成功
            $result = $validate->batch()->check($postData);
            //成功 $result true      失败 $result false  
            if(!$result){
                //提示错误的信息
                //halt($validate->getError());
                $this->error( implode(',',$validate->getError()) );
            }
            //调用模型的方法checkUser，检测用户名和密码是否匹配
            $userModel = new User();
            $flag = $userModel->checkUser($postData['username'],$postData['password']);
            if($flag){
                //直接重定向到后台首页
                $this->redirect('admin/index/index');
            }else{
                //提示用户用户名或密码错误
                $this->error('用户名或密码失败');
            }
        }
        return $this->fetch();
    }


    public function logout(){
        //清除session信息
        //session('user_id',null); //清除其中某个session信息
        session(null); //清除当前用户登录的所有的session信息
        $this->redirect('/login');
    }
}

