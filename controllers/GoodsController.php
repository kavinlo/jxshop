<?php 
    namespace controllers;
    class GoodsController  extends BaseController{

        //显示表单列表页
        public function index()
        {
            $obj = new \models\Goods;
            $data = $obj -> findAll();
            view("goods/index",$data['data']);
        }

        //显示表单添加页
        public function create()
        {
            $obj = new \models\category;
            $getcat = $obj -> getcat();
            view("goods/created",[
                'getcat'=>$getcat['data']
            ]);
        }

        // 处理添加表单
        public function insert()
        {

            $obj = new \models\goods;
            $obj -> fill($_POST);
            $obj -> insert();
        }

        //处理删除表单
        public function delete()
        {
            $id = $_GET['id'];
            $obj = new \models\Goods;
            $obj -> delete($id);
            header('Location:http://localhost:9999/goods/index');
        }

        //跳转更新页面
        public function edit()
        {
            $obj = new \models\Goods;
            $data = $obj -> findOne($_GET['id']);
            view('Goods/edit',$data);
        }

        //处理更新表单
        public function update()
        {
            $obj = new \models\Goods;
            $obj -> fill($_POST);
            $obj -> update($_GET['id']);
        }

        public function ajax_get_cat()
        {
            $id = $_GET['id'];
            $obj = new \models\category;
            $data = $obj -> ajax_get_cat($id);
            echo json_encode($data['data']);
        }
        //

    }