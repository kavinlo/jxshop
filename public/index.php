<?php
    session_start();
    define('ROOT',__DIR__.'/../');

    /*
     *引入libs/下的函数
     */
    require(ROOT.'libs/functions.php');

    /*
     *自动加载类
     */
    function load($class){
        $path  =str_replace('\\','/',$class);
        require(ROOT.$path.'.php');
    }
    spl_autoload_register('load');

    if(isset($_SERVER['PATH_INFO'])){
        $arr = explode('/',$_SERVER['PATH_INFO']);
        $controller = '\controllers\\'.$arr[1].'Controller';
        $action = $arr[2];
    }else{
        $controller = '\controllers\IndexController';
        $action = 'index';
    }  

    echo 'helloword';

    $_c = new $controller;
    $_c -> $action();