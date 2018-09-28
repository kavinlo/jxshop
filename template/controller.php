    namespace controllers;
    class <?=$cname?> {

        //显示表单列表页
        public function index()
        {
            $obj = new \models\<?=ucfirst($tableName)?>;
            $data = $obj -> findAll();
            view("<?=$tableName?>/index",$data['data']);
        }

        //显示表单添加页
        public function create()
        {
            view("<?=$tableName?>/created");
        }

        // 处理添加表单
        public function insert()
        {
            $obj = new \models\<?=ucfirst($tableName)?>;
            $obj -> fill($_POST);
            $obj -> insert();
        }

        //处理删除表单
        public function delete()
        {
            $id = $_GET['id'];
            $obj = new \models\<?=ucfirst($tableName)?>;
            $obj -> delete($id);
            header('Location:http://localhost:9999/<?=$tableName?>/index');
        }

        //跳转更新页面
        public function edit()
        {
            $obj = new \models\<?=ucfirst($tableName)?>;
            $data = $obj -> findOne($_GET['id']);
            view('<?=ucfirst($tableName)?>/edit',$data);
        }

        //处理更新表单
        public function update()
        {
            $obj = new \models\<?=ucfirst($tableName)?>;
            $obj -> fill($_POST);
            $obj -> update($_GET['id']);
        }

    }