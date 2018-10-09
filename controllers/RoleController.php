<?php 
    namespace controllers;
    class RoleController  extends BaseController{

        //显示表单列表页
        public function index()
        {

            $obj = new \models\Role;
      
            $data = $obj->findAll([
                'fields'=>'a.*,GROUP_CONCAT(c.pri_name) pri_list',
                'join'=>' a LEFT JOIN role_privlege b ON a.id=b.role_id LEFT JOIN privilege c ON b.pri_id=c.id ',
                'groupby'=>' GROUP BY a.id ',
            ]);
            view("role/index",$data['data']);
        }

        //显示表单添加页
        public function create()
        {
            $obj = new \models\Privilege;
            $data = $obj -> tree();
            view("role/created",$data);
        }


        // 处理添加表单
        public function insert()
        {
            $obj = new \models\Role;
            $obj -> fill($_POST);
            $obj -> insert();
            header('Location:http://localhost:9999/role/index');
        }

        //处理删除表单
        public function delete()
        {
            $id = $_GET['id'];
            $obj = new \models\Role;
            $obj -> delete($id);
            header('Location:http://localhost:9999/role/index');
        }

        //跳转更新页面
        public function edit()
        {
            $obj = new \models\Role;
            $data = $obj -> findOne($_GET['id']);
            $priData = $obj -> getpriByid($_GET['id']);
            $obj = new \models\privilege;
            $pris = $obj->tree($_GET['id']);
            view('Role/edit',[
                'data'=>$data,
                'pris'=>$pris,
                'priData'=>$priData
            ]);
        }

        //处理更新表单
        public function update()
        {
            $obj = new \models\Role;
            $obj -> fill($_POST);
            $obj -> update($_GET['id']);
        }

    }