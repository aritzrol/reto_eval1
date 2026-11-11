<?php

    require_once __DIR__ . '/../model/MProducto.php';
    require_once __DIR__ . '/../model/MSerie.php';

    class CProducto{

        private MProducto $model;
        private MSerie $modelSerie;

        public function __construct()
        {
            $this->model = new MProducto();
            $this->modelSerie = new MSerie();
        }

        public function index(){
            $data = $this->model->getAll();
            //ventana
            require_once __DIR__ . '/../view/VProductoIndex.php';
        }

        public function show($id){
            $data = $this->model->getById($id);
            //ventana
            require_once __DIR__ . '/../view/VProductoShow.php';
        }

        public function create($id){

            $series = $this->modelSerie->getAll();
            //ventana
            require_once __DIR__ . '/../view/VProductoCreate.php';
        }

        public function store($data){

            $id_serie = $data['id_serie'];
            $numero = $data['numero'];
            $precio = $data['precio'];
            $isbn = $data['isbn'];

            $this->model->insert($id_serie, $numero, $precio, $isbn);

            header('Location: index.php?entity=serie&action=index');
        }

        public function edit($id){

            $data = $this->model->getById($id);


            //ventana
            require_once __DIR__ . '/../view/VProductoUpdate.php';
        }

            public function update($data){
                //Edita la entidad y la guarda
                $id_producto = $data['id_producto'];
                $id_serie = $data['id_serie'];
                $numero = $data['numero'];
                $precio = $data['precio'];
                $isbn = $data['isbn'];
                
                $this->model->edit($id_producto, $id_serie, $numero, $precio, $isbn);

                header('Location: index.php?entity=serie&action=index');
            }

        public function destroy($id){
        //Elimina la entidad
        $this->model->delete($id);

        header('Location: index.php?entity=serie&action=index');
    }

    }

?>