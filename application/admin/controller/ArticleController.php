<?php
namespace app\admin\controller;
use app\admin\model\Category;
use app\admin\model\Article;
/**
 * 文章相关
 */
class ArticleController extends CommonController
{
    /**
     * 文章添加
     */
    public function add()
    {
        $catModel = new Category();
        $artModel = new Article();

        $cats = $catModel->getSonsCat($catModel->select());
        return $this->fetch('',['cats'=>$cats]);
    }
}
