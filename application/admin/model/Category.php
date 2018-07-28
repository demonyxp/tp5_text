<?php
namespace app\admin\model;
use think\Model;
/**
 * 分类模型
 */
class Category extends Model
{
    //指定当前模型表的主键字段
    protected $pk = "cat_id";
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    public function getSonsCat($data,$pid=0,$level=1)
    {
    	static $result = [];//静态数组,后面递归的时候只会初始化一次
    	foreach ($data as $v) {
    		if ($v['pid'] == $pid) {
    			$v['level'] = $level;// 加一个层级
    			$result[] = $v;//存放到$result中
    			//递归调用找子孙分类
    			$this->getSonsCat($data,$v['cat_id'],$level+1);
    		}
    	}
    	return $result;
    }

}
