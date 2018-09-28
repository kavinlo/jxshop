<?php
    namespace libs;
    class Upload {

        private static $_obj = null;
        private function __construct(){}
        private function __clone(){}
        public static function getInstance()
        {
            if(self::$_obj === null){
                self::$_obj = new self;
            }
            return self::$_obj;
        }

        /* 定义私有属性 */
        private $_subdir;
        private $_file;
        private $_ext = ['image/png','image/jpg','image/jpeg','image/gif'];
        private $_size = 1024*1024*1.8;
        private $_root = ROOT.'Public/upload/';
        
        /*
         *定义公开方法
         */    
        // 上传图片
        // 参数一、表单中文件名
        // 参数二、保存到的二级目录
        public function upload($name,$subdir)
        {
            $this->_file = $_FILES[$name];
            $this->_subdir = $subdir;
            $dir = self::_makeDir();
            $name = self::_makeName();
            if(!$this->_checkType()){
                die('图片不合法');
            }
            if(!$this->_checkSize()){
                die('大小不合法');
            }

            move_uploaded_file($this->_file['tmp_name'],$this->_root.$dir.$name);
            return $dir.$name;
        }

        /*
         *定义私有方法
         */
        private function _makeDir()   //路径
        {

            if(!is_dir($this->_root.$this->_subdir.'/'.date('Ymd'))){
                mkdir($this->_root.$this->_subdir.'/'.date('Ymd'),0777,true);    //创建文件

            }
            $dir = $this->_subdir.'/'.date('Ymd').'/';
            return $dir;
        }

        private function _makeName()    //文件名
        {
            $ext = strchr($this->_file['name'],'.');
            $name = md5(microtime().rand(1,99999));
            return $name.$ext;
        }

        private function  _checkType()
        {
          return in_array($this->_file['type'],$this->_ext);
        }

        private function _checkSize()
        {

            return $this->_file['size'] < $this->_size;
        }



    }