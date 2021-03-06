<?php
    namespace models;
    use PDO;
    class Model{

        public $table = null;
        public $data = null;
        public $_db;

        //钩子函数
        public function _before_insert(){}
        public function _late_insert(){}
        public function _before_update(){}
        public function _late_update(){}
        public function _before_delete(){}


        public function __construct(){
            $this->_db = \libs\Db::getInstance();
        }
        public function insert(){

            $this->_before_insert();
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
            $stmt -> execute($values);
            $this->data['id'] = $this->_db->lastInsertId();
            $this->_late_insert();
        }

        public function fill($data){
            foreach ($data as $k=>$v){
                if(!in_array($k,$this->filltable)){
                    unset($data[$k]);
                }
            }
            $this->data = $data;
        }

        public function findOne($id){
            $sql = "SELECT * FROM $this->table WHERE id = $id";
            $stmt = $this->_db->prepare($sql);
            $stmt -> execute();
            return $stmt ->fetch(\PDO::FETCH_ASSOC);
        } 

        public function findAll($options = []){
            
            $_option = [
                'fields' => '*',
                'where' => 1,
                'order_by' => 'id',
                'order_way' => 'asc',
                'per_page'=>20,
                'join'=>'',
                'groupby'=>'',
            ];
            // 合并用户的配置
            if($options)
            {
                $_option = array_merge($_option, $options);
            }
            /**
             * 翻页
             */
            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            $offset = ($page-1)*$_option['per_page'];
            
            $sql = "SELECT {$_option['fields']}
                     FROM {$this->table}
                     {$_option['join']}
                     WHERE {$_option['where']} 
                     {$_option['groupby']}
                     ORDER BY {$_option['order_by']} {$_option['order_way']} 
                     LIMIT $offset,{$_option['per_page']}";
                    //  echo $sql;
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll( PDO::FETCH_ASSOC );
            /**
             * 获取总的记录数
             */
            $stmt = $this->_db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$_option['where']}");
            $stmt->execute();
            $count = $stmt->fetch( PDO::FETCH_COLUMN );
            $pageCount = ceil($count/$_option['per_page']);
            $page_str = '';
            if($pageCount>1)
            {
                for($i=1;$i<=$pageCount;$i++)
                {
                    $page_str .= '<a href="?page='.$i.'">'.$i.'</a> ';
                }
            }
            
            return [
                'data' => $data,
                'page' => $page_str,
            ];
        }
        public function update($id){
            $this->_before_update();
            $values = [];
            $keys = [];
            foreach($this->data as $k=>$v){
                $keys[] = $k."=?";
                $values[] = $v;
            }
            $keys = implode(',',$keys);

            $sql = "UPDATE $this->table SET $keys WHERE id = ?";
            $stmt = $this->_db -> prepare($sql);
            $values[] = $id;
            $stmt -> execute($values);
            $this->_late_update();

            header("Location: http://localhost:9999/$this->table/index");
        }

        public function delete($id)
        {
            $this->_before_delete();
            $sql = "DELETE FROM $this->table WHERE id = $id";
            $this->_db->exec($sql);
        }

        public function del_img()
        {
             // 如果是修改就删除原图片
             if(isset($_GET['id']))
             {
                 // 先从数据库中取出原LOGO
                 $ol = $this->findOne($_GET['id']);
                 // 删除
                 @unlink(ROOT . 'public'. $ol['logo']);
             }
        }

        //递归树形结构顺序
        public function tree()
        {
            //取出所有的权限数据
            $data = $this->findAll();
            $ret = $this->_tree($data['data']);
            return $ret;
        }

        public function _tree($data,$pri_id=0,$level=0)
        {
            static $ret = [];
            foreach($data as $v){
                if($v['parent_id']==$pri_id){
                    $v['level'] = $level;
                    $ret[] = $v;
                    $this->_tree($data,$v['id'],$level+1);
                }
            }
            return $ret;
        }

    }