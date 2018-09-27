<?php
    namespace models;

    class Model{

        public $table = null;
        public $data = null;
        public $_db;

        public function __construct(){
            $this->_db = \libs\Db::getInstance();
        }
        public function insert(){
            $keys = [];
            $values = [];
            $toke = [];
            foreach($this->data as $k=>$v){
                $values[] = $v;
                $keys[] = $k;
                $toke[] = '?';
            }
            $keys = implode(',',$keys);
            $toke = implode(',',$toke);
            $sql = "INSERT INTO  {$this->table}({$keys}) VALUES({$toke})";

            $stmt = $this->_db->prepare($sql);
            return $stmt -> execute($values);
        }

        public function fill(){
            foreach ($_POST as $k=>$v){
                if(!in_array($k,$this->filltable)){
                    unset($_POST[$k]);
                }
            }
            $this->data = $_POST;
        }

        public function fetch(){


        }

//        public function fetchAll($sql,$data=[]){
//
//            $stmt = $this->_db->prepare($sql);
//            $stmt -> execute($data);
//            return $stmt -> fetchAll(\PDO::FETCH_ASSOC);
//        }
        public function update(){

//            $keys = [];
//            $values = [];
//            foreach ($this->data as $k=> $v){
//                $keys[] = $k;
//                $values[] = $v;
//            };
//            $str = '';
//            for ($i=0;$i<$this->data.length;$i++){
//                $str .= $keys[$i]."=".$values[$i];
//            }
//            $sql = "UPDATE $this->table SET $str "
        }


    }