<?php

    require_once __DIR__ . '/../model/MLineaPedido.php';
    require_once __DIR__ . '/../model/MProducto.php';
    require_once __DIR__ . '/../model/MPedido.php';

    class CLineaPedido{

        private MLineaPedido $model;
        private MProducto $productoModel;
        private MPedido $pedidoModel;

        public function __construct()
        {
            $this->model = new MLineaPedido();
            $this->productoModel = new MProducto();
            $this->pedidoModel = new MPedido();
        }

        public function index(){
            $id_usuario = $_SESSION['id_usuario'];

            $data = $this->model->getAll($id_usuario);
            //ventana
            require_once __DIR__ . '/../view/VLineaPedidoIndex.php';
        }

        public function show($id){
            $data = $this->model->getById($id);
            //ventana
            require_once __DIR__ . '/../view/VLineaPedidoShow.php';
        }

        public function create(){

            //se recupera el id_usuario de la sesion
            $id_usuario = $_SESSION['id_usuario'];

            //se recoge la suma total del carrito
            $sumaTotal = $this->model->getTotalSum($id_usuario);

            //se crea un pedido nuevo
            $precio_total = $sumaTotal;
            $estado_pedido = 'pagado';

            $this->pedidoModel->insert($id_usuario, $precio_total, $estado_pedido);

            //se recupera el id_pedido que se acaba de crear
            $id_pedido = $this->pedidoModel->getUltimoPedido($id_usuario);

            //se actualiza el estado del carrito a 'pagado' y se inserta el id_pedido al que pertenecen
            $this->model->updateCarritoAPagado($id_pedido, $id_usuario);


            //ventana
            header('Location: index.php?entity=serie&action=index');
        }

        public function store($id_producto){

            //se recupera la info del producto
            $data = $this->productoModel->getById($id_producto);

            $id_usuario = $_SESSION['id_usuario'];
            $id_producto = $data['id_producto'];
            $cantidad = 1;
            $precio_unitario = $data['precio'];
            $estado_pedido = 'carrito';

            $this->model->insert($id_usuario, $id_producto, $cantidad, $precio_unitario, $estado_pedido);

            header('Location: index.php?entity=serie&action=index');
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