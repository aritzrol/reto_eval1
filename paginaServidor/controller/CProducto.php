<?php

    require_once __DIR__ . '/../model/MProducto.php';
    require_once __DIR__ . '/../model/MSerie.php';

    class CProducto{

        private MProducto $model;

        public function __construct()
        {
            $this->model = new MProducto();
        }

        public function index(){
            $data = $this->model->getAll();
            //ventana
            require_once __DIR__ . '/../view/VProductoShow.php';
        }

        public function show($id){
            $data = $this->model->getById($id);
            //ventana
            require_once __DIR__ . '/../view/VProductoShow.php';
        }

        public function create(){
            //ventana
            require_once __DIR__ . '/../view/VProductoCreate.php';
        }

        public function store(){
            $this->model->insert($_POST);

            header('Location: index.php?entity=producto&action=index');
        }

        public function edit($id){
            $this->model->edit($id);
            //ventana
            header('Location: index.php?entity=producto&action=index');
        }

        public function destroy($id){
        //Elimina la entidad
        $this->model->delete($id);

        header('Location: index.php?entity=producto&action=index');
    }

    }

?>