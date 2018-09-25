<?php
    
    /*
     *加载视图
     * $class 加载视图文件名
     * $data  传的数据
     */
    function view($filename,$data=[]){
        extract($data);
        include(ROOT.'views/'.$filename.'.html');
    }