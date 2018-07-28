<?php 
namespace app\admin\validate;
use think\Validate;

/**
 * 分类验证
 */
class Category extends Validate
{
   //定义验证规则(必须为$rule)
	protected $rule = [
        //表单name名称 => 验证规则（多个用属性隔开）
        'cat_name' => "require|unique:category",
        'pid' => "require",
    ];
    //定义验证规则不通过的提示信息
    protected $message = [
        //表单name名称.规则名 => '相应提示错误信息'
        'cat_name.require' => '分类名称必填',
        'cat_name.unique' => '分类名称重复',
        'pid.require' => '必须选择一个分类',
    ];
    //定义验证的场景
    protected $scene = [
    	'add' => ['cat_name','pid'],
    	'upd' => ['cat_name' => 'unique:category','pid'],
    ];
}
