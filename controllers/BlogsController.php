<?php 
    namespace controllers;
    class BlogsController extends BaseController {

        //显示表单列表页
        public function index()
        {
            $obj = new \models\Blogs;
            $data = $obj -> findAll();
            view("Blogs/index",$data['data']);
        }

        //显示表单添加页
        public function create()
        {
            view("Blogs/created");
        }

        // 处理添加表单
        public function insert()
        {
            $obj = new \models\Blogs;
            $obj -> fill($_POST);
            $obj -> insert();
        }

        //处理删除表单
        public function delete()
        {
            $id = $_GET['id'];
            $obj = new \models\Blogs;
            $obj -> delete($id);
            header('Location:http://localhost:9999/Blogs/index');
        }

        //跳转更新页面
        public function edit()
        {
            $obj = new \models\Blogs;
            $data = $obj -> findOne($_GET['id']);
            view('Blogs/edit',$data);
        }

        //处理更新表单
        public function update()
        {
            $obj = new \models\Blogs;
            $obj -> fill($_POST);
            $obj -> update($_GET['id']);
        }

    }