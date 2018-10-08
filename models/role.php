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

        public function _before_delete()
        {
            $sql = "delete from role_privlege where role_id=?";
            $stmt = $this->_db->prepare($sql);
            $stmt -> execute([
                $_GET['id']
            ]);
        }

    }