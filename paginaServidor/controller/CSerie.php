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
            "sinopsis" => $_POST["sinopsis"],
            "genero" => $_POST["genero"],
            "autor" => $_POST["autor"],
            "editorial" => $_POST["editorial"]
        ];

        $this->model->insert($data);

        header('Location: index.php?entity=Serie&action=index');
    }

    public function show($id)
    {
        $data = [$this->model->getById($id)];

        require __DIR__ . '/../view/VSerieShow.php';
    }

    public function edit($id)
    {
        //Muestra la vista/formulario de editar
        $data = $this->model->getById($id); 
        require __DIR__ . '/../view/VSerieUpdate.php';
    }

    public function update($data)
    {
        //Edita la entidad y la guarda
        $id_serie = $data['id_serie'];
        $nombre = $data['nombre'];
        $sinopsis = $data['sinopsis'];
        $genero = $data['genero'];
        $autor = $data['autor'];
        $editorial = $data['editorial'];
        
        $this->model->edit($id_serie, $nombre, $sinopsis, $genero, $autor, $editorial);

        header('Location: index.php?entity=serie&action=index');
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
