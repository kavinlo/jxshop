<?php 
    namespace models;

    class role extends Model {

        public $table = "role";
        protected $filltable = ["role_name"]; 

        public function  _late_insert()
        {
            $sql = "INSERT INTO role_privlege(pri_id,role_id) VALUES(?,?)";
            $stmt = $this->_db->prepare($sql);
            foreach($_POST['pri_id'] as $v){
                $stmt->execute([
                    $v,
                    $this->data['id']
                ]);

            }
        }

        public function _late_update()
        {
            $role_id = $this->data['id']===null ? $_GET['id']:$this->data['id']  ;

            $sql = "DELETE FROM role_privlege WHERE role_id = ?";
            $stmt = $this->_db->prepare($sql);
            $stmt -> execute([
                $role_id
            ]);
            
            $sql = "INSERT INTO role_privlege(pri_id,role_id) VALUES(?,?)";
            $stmt = $this->_db->prepare($sql);
            foreach($_POST['pri_id'] as $v){
                $stmt->execute([
                    $v,
                    $role_id
                ]);

            }
        }

        public function _before_delete()
        {
            $sql = "delete from role_privlege where role_id=?";
            $stmt = $this->_db->prepare($sql);
            $stmt -> execute([
                $_GET['id']
            ]);
        }

        public function getpriByid($role_id)
        {
            $sql = "SELECT pri_id FROM role_privlege a 
                        LEFT JOIN privilege b ON a.pri_id=b.id
                            WHERE a.role_id=?";
            $stmt = $this->_db->prepare($sql);
            $stmt -> execute([
                $role_id
            ]);
            $data = $stmt -> fetchAll(\PDO::FETCH_ASSOC);
            $_ret = [];
            foreach($data as $v){
                $_ret[] = $v['pri_id'];
            }
            return $_ret;

        }

    }