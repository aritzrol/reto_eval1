<?php

require_once __DIR__ . '/../model/MPedido.php';

class CPedido
{

    private MPedido $model;

    public function __construct()
    {
        $this->model = new MPedido();
    }

    public function index()
    {
        $data = $this->model->getAll();
        //ventana
        require_once __DIR__ . '/../view/VPedidoIndex.php';
    }

    public function show($id)
    {
        $data = $this->model->getById($id);
        //ventana
        require_once __DIR__ . '/../view/VPedidoShow.php';
    }

    public function create()
    {
        //ventana
        require_once __DIR__ . '/../view/VPedidoCreateForm.php';
    }

    public function store($data)
    {
        $id_usuario = $data['id_usuario'];
        $fecha = $data['fecha'];
        $precio_total = $data['precio_total'];
        $estado_pedido = $data['estado_pedido'];

        $this->model->insert($id_usuario, $fecha, $precio_total, $estado_pedido);

        header('Location: index.php?entity=serie&action=index');
    }

    public function edit($id)
    {
        $data = $this->model->getById($id);
        
        //ventana
        require_once __DIR__ . '/../view/VPedidoUpdate.php';
    }

    public function update($data)
    {
        $id_pedido = $data['id_pedido'];
        $id_usuario = $data['id_usuario'];
        $fecha = $data['fecha'];
        $precio_total = $data['precio_total'];
        $estado_pedido = $data['estado_pedido'];

        $data = $this->model->edit($id_pedido, $id_usuario, $fecha, $precio_total, $estado_pedido);
        
        //ventana
        header('Location: index.php?entity=pedido&action=index');
    }

    public function destroy($id)
    {
        //Elimina la entidad
        $this->model->delete($id);

        header('Location: index.php?entity=pedido&action=index');
    }

}
?>
