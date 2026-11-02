<?php

class MPedido
{

    //parametros
    private $db;
    private $pedidos;

    //constructor
    public function __construct()
    {

        $this->db = Db::conexion();
        $this->pedidos = array();
    }

    //Crear un pedido
    public function create($id_usuario, $fecha, $precio_total, $estado_pedido){

        $consulta=$this->db->prepare("insert into pedido (id_usuario, fecha, precio_total, estado_pedido) values (?, ?, ?, ?)");
        $consulta->bind_param("isds", $id_usuario, $fecha, $precio_total, $estado_pedido);
        $consulta->execute();
    }

    //ver todos los pedidos
    function getAll(){

        //se accede a la base de datos
        $consulta = $this->db->query("select * from pedido");

        //se leen los datos
        while ($filas = $consulta->fetch_assoc()) {
            $this->pedidos[] = $filas;
        }

        return $this->pedidos;
    }

    //actualizar un pedido
        public function update($id_pedido, $id_usuario, $fecha, $precio_total, $estado_pedido){

        $consulta=$this->db->prepare("update pedido set id_usuario=?, fecha=?, precio_total=?, estado_pedido=? where id_pedido=?");
        $consulta->bind_param("isdsi", $id_usuario, $fecha, $precio_total, $estado_pedido, $id_pedido);
        $consulta->execute();
        
    }

    //borrar un pedido
    public function delete($id_pedido){

        $consulta=$this->db->prepare("delete from pedido where id_pedido=?");
        $consulta->bind_param("i", $id_pedido);
        $consulta->execute();

    }

    //recupera un pedido por su ID
    function getById($id_pedido){

        //se accede a la base de datos
        $consulta = $this->db->prepare("select * from pedido where id_pedido = ?");
        $consulta->bind_param("i", $id_pedido);
        $consulta->execute();
        $resultado = $consulta->get_result();

        return $resultado->fetch_assoc();
    }
}
