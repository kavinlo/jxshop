<?php 
    namespace controllers;
    use models\admin;

    class LoginController {

        public function login()
        {
            view('login/login');
        }    
        

        // 处理登录的表单
        public function dologin()
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
         
            $model = new admin;
            try{
                $model->login($username,$password);
                header("Location:http://localhost:9999");
            }catch(\Exception $e){
                view('login/login');
            }
            
        }

         // 退出
        public function logout()
        {
            $model = new admin;
            $model->logout();
            view('login/login');
        }





    }