<?php 
    namespace controllers;
    class PrivilegeController extends BaseController {

        //显示表单列表页
        public function index()
        {
            $obj = new \models\Privilege;
            $data = $obj -> findAll();
            
            view("privilege/index",$data['data']);
        }

        //显示表单添加页
        public function create()
        {
            view("privilege/created");
        }

        // 处理添加表单
        public function insert()
        {
            $obj = new \models\Privilege;
            $obj -> fill($_POST);
            $obj -> insert();
        }

        //处理删除表单
        public function delete()
        {
            $id = $_GET['id'];
            $obj = new \models\Privilege;
            $obj -> delete($id);
            header('Location:http://localhost:9999/privilege/index');
        }

        //跳转更新页面
        public function edit()
        {
            $obj = new \models\Privilege;
            $data = $obj -> findOne($_GET['id']);
            view('Privilege/edit',$data);
        }

        //处理更新表单
        public function update()
        {
            $obj = new \models\Privilege;
            $obj -> fill($_POST);
            $obj -> update($_GET['id']);
        }

    }