<?php
require_once 'model/MUsuario.php';

class CUsuario
{
    private $model;

    public function __construct()
    {
        $this->model = new MUsuario();
    }

    public function index()
    {
        //Muestra todos
        $data = $this->model->getAll();
        require __DIR__ . '/../view/VUsuarioIndex.php';
    }

    public function create()
    {
        //Muestra la vista/formulario de crear
        require __DIR__ . '/../view/VUsuarioCreateForm.php';
    }

    public function store()
    {
        //Crea la entidad y la guarda
        $this->model->insert($_POST);
        header('Location: index.php?entity=usuario&action=index');
    }

    public function show($id)
    {
        //Muestra uno
        $data = $this->model->getById($id);
        require __DIR__ . '/../view/VUsuarioShow.php';
    }

    public function edit($id)
    {
        //Muestra la vista/formulario de editar
        $data = $this->model->getById($id); 
        require __DIR__ . '/../view/VUsuarioEditForm.php';
    }

    public function update($id)
    {
        //Edita la entidad y la guarda
        $this->model->edit($id, $_POST);
        header('Location: index.php?entity=usuario&action=index');
    }

    public function destroy($id)
    {
        //Elimina la entidad
        $this->model->delete($id);
        header('Location: index.php?entity=usuario&action=index');
    }
}
