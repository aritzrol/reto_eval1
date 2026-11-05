<?php

class MProducto
{

    //parametros
    private $db;
    private $productos;

    //constructor
    public function __construct()
    {

        $this->db = Db::getConexion();
        $this->productos = array();
    }

    //Crear un producto
    public function create($id_serie, $numero, $precio, $isbn){

        $consulta=$this->db->prepare("insert into producto (id_serie, numero, precio, isbn) values (?, ?, ?, ?)");
        $consulta->bind_param("iids", $id_serie, $numero, $precio, $isbn);
        $consulta->execute();
    }

    //ver todos los productos
    function getAll(){

        //se accede a la base de datos
        $consulta = $this->db->query("SELECT producto.*, serie.nombre as nombre_serie FROM producto JOIN serie ON producto.id_serie = serie.id_serie");

        //se leen los datos
        while ($filas = $consulta->fetch_assoc()) {
            $this->productos[] = $filas;
        }

        return $this->productos;
    }

    //actualizar un producto
        public function update($id_producto, $id_serie, $numero, $precio, $isbn){

        $consulta=$this->db->prepare("update caballero set id_serie=?, numero=?, precio=?, isbn=? where id_producto=?");
        $consulta->bind_param("iidsi", $id_serie, $numero, $precio, $isbn, $id_producto);
        $consulta->execute();
        
    }

    //borrar un producto
    public function delete($id_producto){

        $consulta=$this->db->prepare("delete from caballero where id_producto=?");
        $consulta->bind_param("i", $id_producto);
        $consulta->execute();

    }

    //recupera un producto por su ID
    function getById($id_producto){

        //se accede a la base de datos
        $consulta = $this->db->prepare("select * from producto where id_producto = ?");
        $consulta->bind_param("i", $id_producto);
        $consulta->execute();
        $resultado = $consulta->get_result();

        return $resultado->fetch_assoc();
    }
}
