<?php 
    namespace models;

    class category extends Model {

        public $table = "category";
        protected $filltable = [""]; 

        public function getcat()
        {
            return $this -> findAll([
                'where' => 'parent_id=0'
            ]);
        }

        public function ajax_get_cat($id)
        {
            return $this -> findAll([
                'where' => 'parent_id='.$id
            ]);
        }
    }