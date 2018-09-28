<?php 
    namespace models;

    class goods extends Model {

        public $table = "goods";
        protected $filltable = ["goods_name","logo","is_on_sale","description","cat1_id","cat2_id","cat3_id","brand_id"]; 

        public function _before_insert(){
            $uploader = \libs\Upload::getInstance();
            $dir = '/upload/'.$uploader -> upload('logo','brand');
            $this->data['logo'] = $dir;
        }

        public function _late_insert()
        {   
            //处理属性
            $stmt = $this->_db -> prepare("INSERT INTO goods_attribute(attr_name,attr_value,goods_id) VALUES(?,?,?)");
            
            foreach($_POST['attr_name'] as $k=>$v){
                $stmt -> execute([
                    $v,
                    $_POST['attr_value'][$k],
                    $this->data['id']
                ]);

            }
            //处理sku
            $stmt = $this->_db -> prepare("INSERT INTO goods_sku(goods_id,sku_name,stock,price) VALUES(?,?,?,?)");
            foreach($_POST['sku_name'] as $k=>$v){
                $stmt -> execute([
                    $this->data['id'],
                    $v,
                    $_POST['stock'][$k],
                    $_POST['price'][$k],
                ]);
            }

            //处理图片
            $uploader = \libs\Upload::getInstance();
            $stmt = $this->_db -> prepare("INSERT INTO goods_image(goods_id,path) VALUES(?,?)");
            $arr = [];
            foreach($_FILES['goods_image']['name'] as $k=>$v){
                $arr['name'] = $v;
                $arr['type'] = $_FILES['goods_image']['type'][$k];
                $arr['tmp_name'] = $_FILES['goods_image']['tmp_name'][$k];
                $arr['error'] = $_FILES['goods_image']['error'][$k];
                $arr['size'] = $_FILES['goods_image']['size'][$k];
                $_FILES['tmp'] = $arr;
                $dir = '/upload/'.$uploader -> upload('tmp','goods');
                $stmt -> execute([
                    $this->data['id'],
                    $dir
                ]);
            }
            




        }



    }