<?php
require_once 'model/MUsuario.php';
require_once 'model/MPerfil.php';

class CUsuario
{
    private $model;
    private $perfil;

    public function __construct()
    {
        $this->model = new MUsuario();
    }

    public function index()
    {
        //Muestra todos
        $this->perfil = new MPerfil();

        $data = $this->model->getAll();
        array_merge($data, $this->perfil->getAll());

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
        $data = [
            "nombre" => $_POST["nombre"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
            "rol" => $_POST["rol"]
        ];

        $id_usuario = $this->model->insert($data);

        $this->perfil = new MPerfil();

        $data = [
            "id_usuario" => $id_usuario,
            "apellidos" => $_POST["apellidos"],
            "telefono" => $_POST["telefono"],
            "direccion" => $_POST["direccion"]
        ];

        $this->perfil->insert($data);

        header('Location: index.php?entity=usuario&action=index');
    }

    public function show($id)
    {
        //Muestra uno
        $this->perfil = new MPerfil();

        $data = $this->model->getById($id);
        array_merge($data, $this->perfil->getById($id));
        
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
        $data = [
            "nombre" => $_POST["nombre"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
            "rol" => $_POST["rol"]
        ];

        $this->model->edit($id, $data);

        $data = [
            "id_usuario" => "id_usuario",
            "apellidos" => $_POST["apellidos"],
            "telefono"  => $_POST["telefono"],
            "direccion" => $_POST["direccion"]
        ];

        $this->perfil = new MPerfil();
        $this->model->edit($id, $data);

        header('Location: index.php?entity=usuario&action=index');
    }

    public function destroy($id)
    {
        //Elimina la entidad
        $this->perfil = new MPerfil();

        $this->perfil->delete($id);
        $this->model->delete($id);

        header('Location: index.php?entity=usuario&action=index');
    }
}
