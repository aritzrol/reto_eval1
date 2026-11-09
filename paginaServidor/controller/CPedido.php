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

    public function store()
    {
        $this->model->insert($_POST);

        header('Location: index.php?entity=pedido&action=index');
    }

    public function edit($id)
    {
        $data = $this->model->getById($id);
        //ventana
        require_once __DIR__ . '/../view/VPedidoEditForm.php';
    }

    public function update($id)
    {
        $this->model->update($id, $_POST);

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