<?php

    require_once __DIR__ . '/../model/MProducto.php';
    require_once __DIR__ . '/../model/MSerie.php';

    class CProducto{

        private Mproducto $model;

        public function __construct()
        {
            $this->model = new MProducto();
        }

        public function index(){
            //modelo
            $data = $this->model->getAll();
            //ventana
            require_once __DIR__ . '/../view/vista_producto.php';
        }

    }

?>