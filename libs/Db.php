<?php
    namespace libs;

    class Db {

        private static $_obj = null;
        private static $_pdo = null;
        private function __construct(){
            if(self::$_pdo === null){
                self::$_pdo = new \PDO("mysql:host=127.0.0.1;dbname=jxshop","root","123");
                self::$_pdo -> exec("SET NAMES utf8");
            }
        }
        private function __clone(){}

        public static function getInstance(){
            if(self::$_obj===null){
                self::$_obj = new self;
            }
            return self::$_obj;
        }

        public function prepare ($sql){
            return self::$_pdo -> prepare($sql);
        }

        public function exec($sql){
            return self::$_pdo->exec($sql);
        }

    }