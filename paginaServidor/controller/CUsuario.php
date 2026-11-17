<?php
require_once 'model/MUsuario.php';
require_once 'model/MPerfil.php';

class CUsuario
{
    private $model;
    private $perfilModel;

    public function __construct()
    {
        $this->model = new MUsuario();
        $this->perfilModel = new MPerfil();
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
        require __DIR__ . '/../view/VUsuarioCreate.php';
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

        $data = $this->model->getByIdUsuarioPerfil($id);
        
        require __DIR__ . '/../view/VUsuarioShow.php';
    }

    public function edit($id)
    {
        //Muestra la vista/formulario de editar
        $data = $this->model->getByIdUsuarioPerfil($id); 
        require __DIR__ . '/../view/VUsuarioUpdate.php';
    }

    public function update($data)
    {
        //parametros recuperados de data
        $id_usuario = $data['id_usuario'];
        $nombre = $data['nombre'];
        $email = $data['email'];
        $rol = $data['rol'];
        $apellidos = $data['apellidos'];
        $telefono = $data['telefono'];
        $direccion = $data['direccion'];
        
        //se actualiza usuario
        $this->model->edit($id_usuario, $nombre, $email, $rol);

        //se actualiza el perfil de ese usuario
        $this->perfilModel->edit($id_usuario, $apellidos, $telefono, $direccion);

        header('Location: index.php?entity=usuario&action=index');
    }

    public function destroy($id)
    {
        //Elimina la entidad

        $this->perfilModel->delete($id);
        $this->model->delete($id);

        header('Location: index.php?entity=usuario&action=index');
    }
}
