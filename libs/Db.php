<?php
    namespace libs;

    class Db {

        private $_obj = null;
        private $_pdo = null;
        private function __construct(){
            if($this->_pdo === null){
                $this->_pdo = new \PDO("mysql:host=127.0.0.1;dbname=jxshop","root","123");
                $this->_pdo -> exec("SET NAMES utf8");
            }
        }
        private function __clone(){}

        public function getInstance(){
            if($this->_obj===null){
                $this->_obj = new self;
            }
            return $this->_obj;
        }

    }