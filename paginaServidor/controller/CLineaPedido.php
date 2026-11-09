<?php

    require_once __DIR__ . '/../model/MLineaLineaPedido.php';

    class CLineaPedido{

        private MLineaPedido $model;

        public function __construct()
        {
            $this->model = new MLineaPedido();
        }

        public function index(){
            $data = $this->model->getAll();
            //ventana
            require_once __DIR__ . '/../view/VLineaPedidoIndex.php';
        }

        public function show($id){
            $data = $this->model->getById($id);
            //ventana
            require_once __DIR__ . '/../view/VLineaPedidoShow.php';
        }

        public function create(){
            //ventana
            require_once __DIR__ . '/../view/VLineaPedidoCreateForm.php';
        }

        public function store(){
            $this->model->insert($_POST);

            header('Location: index.php?entity=lineaPedido&action=index');
        }

        public function edit(){
            //ventana
            require_once __DIR__ . '/../view/VLineaPedidoEditForm.php';
        }

        public function edit($id){
            $this->model->edit($id);
            //ventana
            header('Location: index.php?entity=lineaPedido&action=index');
        }

        public function destroy($id){
        //Elimina la entidad
        $this->model->delete($id);

        header('Location: index.php?entity=lineaPedido&action=index');
    }

    }

?>