<?php
    namespace controllers;
    
    class CodeController {

        public function make()
        {
            // 1.接收参数
            $tableName = $_GET['name'];

            // 2.生成控制器
            $cname = ucfirst($tableName) . 'Controller';
            ob_start();
            include(ROOT.'template/controller.php');
            $str = ob_get_clean();
            file_put_contents(ROOT.'controllers/'.$cname.".php","<?php \r\n".$str);

            // 3.生成模板
            ob_start();
            include(ROOT.'template/model.php');
            $str = ob_get_clean();
            file_put_contents(ROOT.'models/'.$tableName.".php","<?php \r\n".$str);

            // 4.生成视图
            if(!is_dir(ROOT.'views/'.$tableName)){
                mkdir(ROOT.'views/'.$tableName);
            }

            ob_start();
            include(ROOT.'template/created.html');
            $str = ob_get_clean();
            file_put_contents(ROOT.'views/'.$tableName."/created.html",$str);

            ob_start();
            include(ROOT.'template/edit.html');
            $str = ob_get_clean();
            file_put_contents(ROOT.'views/'.$tableName."/edit.html",$str);

            ob_start();
            include(ROOT.'template/index.html');
            $str = ob_get_clean();
            file_put_contents(ROOT.'views/'.$tableName."/index.html",$str);

        }

    }