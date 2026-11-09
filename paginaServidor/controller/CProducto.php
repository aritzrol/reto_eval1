<?php

    require_once __DIR__ . '/../model/MProducto.php';
    require_once __DIR__ . '/../model/MSerie.php';

    class CProducto{

        private MProducto $model;
        private MSerie $serieModel;

        public function __construct()
        {
            $this->model = new MProducto();
            $this->serieModel = new MSerie();
        }

        public function index(){
            $data = $this->model->getAll();
            $error = isset($_GET['error']) ? $_GET['error'] : null;
            require_once __DIR__ . '/../view/VProductoIndex.php';
        }

        public function show($id){
            $data = $this->model->getById((int) $id);
            require_once __DIR__ . '/../view/VProductoShow.php';
        }

        public function create(){
            $series = $this->serieModel->getAll();
            require_once __DIR__ . '/../view/VProductoCreate.php';
        }

        public function store(){
            $isbn = (isset($_POST['isbn']) && trim($_POST['isbn']) !== '') ? trim($_POST['isbn']) : null;

            try {
                $this->model->insert(
                    (int) $_POST['id_serie'],
                    (int) $_POST['numero'],
                    (float) $_POST['precio'],
                    $isbn
                );
            } catch (mysqli_sql_exception $e) {
                $this->redirect('index.php?entity=producto&action=index&error=store');
            }

            $this->redirect('index.php?entity=producto&action=index');
        }

        public function edit($id){
            $data = $this->model->getById((int) $id);
            $series = $this->serieModel->getAll();
            require_once __DIR__ . '/../view/VProductoUpdate.php';
        }

        public function update(){
            $id_producto = (int) $_POST['id_producto'];
            $id_serie = (int) $_POST['id_serie'];
            $numero = (int) $_POST['numero'];
            $precio = (float) $_POST['precio'];
            $isbn = (isset($_POST['isbn']) && trim($_POST['isbn']) !== '') ? trim($_POST['isbn']) : null;

            try {
                $this->model->edit($id_producto, $id_serie, $numero, $precio, $isbn);
            } catch (mysqli_sql_exception $e) {
                $this->redirect('index.php?entity=producto&action=index&error=update');
            }

            $this->redirect('index.php?entity=producto&action=index');
        }

        //Elimina el producto
        public function destroy($id){
            try {
                $this->model->delete((int) $id);
            } catch (mysqli_sql_exception $e) {
                // Por ejemplo, si el producto esta en alguna linea de pedido
                $this->redirect('index.php?entity=producto&action=index&error=destroy');
            }

            $this->redirect('index.php?entity=producto&action=index');
        }

        private function redirect($url){
            header('Location: ' . $url);
            exit();
        }

    }

?>
