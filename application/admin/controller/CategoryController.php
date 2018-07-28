<?php
namespace app\admin\controller;
use app\admin\model\Category;
use think\Validate;
/**
 * 分类添加
 */
class CategoryController extends CommonController
{
    /**
     * 分类添加
     */
    public function add()
    {
        $catModel = new Category();
        if(request()->isPost()){
          //接收参数
            $postData = input('post.');
            //验证数据是否合法（验证器去验证）
            $result = $this->validate($postData,'Category.add',[],true);           
            if($result!==true){
                $this->error( implode(',',$result) );
            }
            if ($catModel->save($postData)) {
            	$this->success('新增成功', url('admin/category/index'));
            }else {
            	$this->error('新增失败');
            }
        }
        $data = $catModel->select()->toArray();//取出所有的分类
        //$data = $catModel->select();中$data默认为数组需要到database.php文件中修改配置文件 'resultset_type'  => 'think\Collection', 才会输出一个对象,才可以使用toArray输出数组
        $cats = $catModel->getSonsCat($data);
        return $this->fetch('',['cats' => $cats]);
    }

    #列表页
    public function index()
    {
        $catModel = new Category();
        $data = $catModel
                ->field('t1.*,t2.cat_name p_name')
                ->alias('t1')
                ->join('tp_category t2','t1.pid=t2.cat_id','left')
                ->select();
        $cats = $catModel->getSonsCat($data);//进行无极限分类处理
        //输出模板视图
        // dump($cats);die;
        return $this->fetch('',['cats'=>$cats]);

    }

    #更新
    public function upd()
    {
        $catModel = new Category();
        if(request()->isPost()){
          //接收参数
            $postData = input('post.');
            //验证数据是否合法（验证器去验证）
            $result = $this->validate($postData,'Category.upd',[],true);           
            if($result!==true){
                $this->error( implode(',',$result) );
            }
            if ($catModel->update($postData)) {
                $this->success('修改成功', url('admin/category/index'));
            }else {
                $this->error('修改失败');
            }
        }
        $cat_id = input('cat_id');
        $catData = $catModel->find($cat_id);
        $data = $catModel->select();
        $cats = $catModel->getSonsCat($data);
        return $this->fetch('',['cats' => $cats,'catData' => $catData]);
    }

    #ajax删除
    public function ajaxDel()
    {
        if (request()->isAjax()) {
            $cat_id = input('cat_id');
            //判断是否有子分类
            $where = [
                'pid' => $cat_id
            ];
            $result1 = Category::where($where)->find();
            if ($result1) {
                //如果为真,表示有子分类
                $response = ['code' => -1,'message' => '分类下有子分类,无法删除'];
                return json($response);die;
            }
            //判读分类下是否有文章
            // $result2 = Article::where(["cat_id" => $cat_id])->find();
            // if ($result2) {
            //     $response = ['code' => -2,'message'=>'分类下有文章,无法删除'];
            //     return json($response);die;
            // }
            //只有上面两个条件都满足之后才可以删除分类
            if (Category::destroy($cat_id)) {
                $response = ['code'=>200,'message'=>'删除成功'];
                return json($response);die;
            }else {
                $response = ['code'=>-3,'message'=>'删除失败'];
                return json($response);die;
            }
        }
    }
}
