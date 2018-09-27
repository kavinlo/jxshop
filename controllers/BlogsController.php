<?php 
    namespace controllers;
    class BlogsController {

        //显示表单列表页
        public function index()
        {
            view("Blogs/index");
        }

        //显示表单添加页
        public function create()
        {
            view("Blogs/created");
        }

        // 处理添加表单
        public function insert()
        {
            $blog = new \models\Blogs();
            $blog ->fill();
            $blog ->insert();
        }

        //处理删除表单
        public function delete()
        {

        }

        //跳转更新页面
        public function edit()
        {

        }

        //处理更新表单
        public function update()
        {

        }

    }