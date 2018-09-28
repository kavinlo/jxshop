<?php 
    namespace models;

    class brand extends Model {

        public $table = "brand";
        protected $filltable = ["brand_name","logo"]; 

        public function _before_update()
        {
            
            $uploader = \libs\Upload::getInstance();
            $dir = '/upload/'.$uploader -> upload('logo','goods');
            $this->data['logo'] = $dir;
        }
    }   