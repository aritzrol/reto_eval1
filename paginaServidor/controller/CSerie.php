<?php
require_once 'model/MSerie.php';
require_once 'model/MProducto.php';

class CSerie
{
    private $model;
    private $producto;

    public function __construct()
    {
        $this->model = new MSerie();
    }

    public function index()
    {
        //Muestra todos
        $this->producto = new MProducto();

        $data = $this->model->getAll();
        $productos = $this->producto->getAll();
        
        require __DIR__ . '/../view/VSerieIndex.php';
    }

    public function create()
    {
        //Muestra la vista/formulario de crear
        require __DIR__ . '/../view/VSerieCreate.php';
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

        $id_serie = $this->model->insert($data);

        $this->producto = new MProducto();

        $data = [
            "id_serie" => $id_serie,
            "apellidos" => $_POST["apellidos"],
            "telefono" => $_POST["telefono"],
            "direccion" => $_POST["direccion"]
        ];

        $this->producto->insert($data);

        header('Location: index.php?entity=Serie&action=index');
    }

    public function show($id)
    {
        //Muestra uno
        $this->producto = new MProducto();

        $data = $this->model->getById($id);
        array_merge($data, $this->producto->getById($id));
        
        require __DIR__ . '/../view/VSerieShow.php';
    }

    public function edit($id)
    {
        //Muestra la vista/formulario de editar
        $data = $this->model->getById($id); 
        require __DIR__ . '/../view/VSerieUpdate.php';
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
            "id_serie" => "id_serie",
            "apellidos" => $_POST["apellidos"],
            "telefono"  => $_POST["telefono"],
            "direccion" => $_POST["direccion"]
        ];

        $this->producto = new MProducto();
        $this->model->edit($id, $data);

        header('Location: index.php?entity=Serie&action=index');
    }

    public function destroy($id)
    {
        //Elimina la entidad
        $this->producto = new MProducto();

        $this->producto->delete($id);
        $this->model->delete($id);

        header('Location: index.php?entity=Serie&action=index');
    }
}
