<?php 
    namespace controllers;
    class BaseController {

        public function __construct()
        {

            if(!isset($_SESSION['id'])){
                view('login/login');
            }

            if(isset($_SESSION['root'])){
                return ;
            }

            $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "index/index";
            $whiteList = ['index/index','index/menu','index/top','index/main'];
            if(!in_array(trim($path,"/"),array_merge($_SESSION['path_url'],$whiteList))){
                die('无权操作');
            }

        }

    }