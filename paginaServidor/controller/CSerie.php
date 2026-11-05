<?php

    require_once __DIR__ . '/../model/MSerie.php';

    class CSerie{

        private MSerie $model;

        public function __construct()
        {
            $this->model = new MSerie();
        }

        public function index(){
            $data = $this->model->getAll();
            require_once __DIR__ . '/../view/VSerieShow.php';
        }

    }

?>