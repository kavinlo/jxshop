<?php 
    namespace controllers;
    class AdminController {

        //显示表单列表页
        public function index()
        {
            $obj = new \models\Admin;
            $data = $obj -> findAll();
            view("admin/index",$data['data']);
        }

        //显示表单添加页
        public function create()
        {
            view("admin/created");
        }

        // 处理添加表单
        public function insert()
        {
            $obj = new \models\Admin;
            $obj -> fill($_POST);
            $obj -> insert();
        }

        //处理删除表单
        public function delete()
        {
            $id = $_GET['id'];
            $obj = new \models\Admin;
            $obj -> delete($id);
            header('Location:http://localhost:9999/admin/index');
        }

        //跳转更新页面
        public function edit()
        {
            $obj = new \models\Admin;
            $data = $obj -> findOne($_GET['id']);
            view('Admin/edit',$data);
        }

        //处理更新表单
        public function update()
        {
            $obj = new \models\Admin;
            $obj -> fill($_POST);
            $obj -> update($_GET['id']);
        }

    }