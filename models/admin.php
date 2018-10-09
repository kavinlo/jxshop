<?php 
    namespace models;

    class admin extends Model {

        public $table = "admin";
        protected $filltable = ["username","password"]; 

        public function  _late_insert()
        {
            $sql = "INSERT INTO admin_role(role_id,admin_id) VALUES(?,?)";
            $stmt = $this->_db->prepare($sql);
            foreach($_POST['role_id'] as $v){
                $stmt->execute([
                    $v,
                    $this->data['id']
                ]);

            }
        }

        public function _before_delete()
        {
            $sql = "delete from admin_role where admin_id=?";
            $stmt = $this->_db->prepare($sql);
            $stmt -> execute([
                $_GET['id']
            ]);
        }

        public function login($username,$password)
        {
            $stmt = $this->_db->prepare("SELECT * FROM admin WHERE username=? AND password=?");
            $stmt->execute([
                $username,
                md5($password),
            ]);
            $info = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($info){
                $_SESSION['id'] = $info['id'];
                $_SESSION['username'] = $info['username'];

                $sql = "SELECT COUNT(*) FROM admin_role WHERE role_id = 1 AND admin_id=?";
                $stmt = $this->_db->prepare($sql);
                $stmt -> execute([
                    $_SESSION['id']
                ]);
                $root = $stmt -> fetch(\PDO::FETCH_COLUMN);

                if($root>0){
                    $_SESSION['root'] = true;
                }else{
                    $obj = $obj = new \models\admin();
                    $data = $obj -> getUrlpath();
                    $_SESSION['path_url'] = $data;
                }


            }else{
                throw new \Exception("用户不存在");
            }

        }

        public function logout()
        {
            $_SESSION = []; 
            @session_destroy();
        }

        public function getUrlpath()
        {
        
            $sql = "SELECT c.url_path FROM admin_role a 
                        LEFT JOIN role_privlege b ON a.role_id=b.role_id
                        LEFT JOIN privilege c ON b.pri_id=c.id
                    WHERE admin_id = ? AND c.url_path!=''  ";

            $stmt = $this->_db->prepare($sql);
            $stmt->execute([$_SESSION['id']]);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $_ret = [];
            foreach($data as $v){
                if(strpos($v['url_path'],',')===false){
                    $_ret[] = $v['url_path'];
                }
                $_ret = array_merge($_ret,explode(',',$v['url_path']));
            }
            return $_ret;
        }

    }