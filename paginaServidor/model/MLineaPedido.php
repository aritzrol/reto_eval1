<?php

class MLineaPedido
{

    //parametros
    private $db;
    private $lineaPedidos;

    //constructor
    public function __construct()
    {

        $this->db = Db::conexion();
        $this->lineaPedidos = array();
    }

    //Crear una linea de pedido
    public function insert($id_pedido, $id_producto, $cantidad, $precio_unitario){

        $consulta=$this->db->prepare("insert into linea_pedido (id_pedido, id_producto, cantidad, precio_unitario) values (?, ?, ?, ?)");
        $consulta->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio_unitario);
        $consulta->execute();
    }

    //ver todos los pedidos
    function getAll(){

        //se accede a la base de datos
        $consulta = $this->db->query("select * from linea_pedido");

        //se leen los datos
        while ($filas = $consulta->fetch_assoc()) {
            $this->lineaPedidos[] = $filas;
        }

        return $this->lineaPedidos;
    }

    //actualizar un pedido
    public function edit($id_linea_pedido, $id_pedido, $id_producto, $cantidad, $precio_unitario){

        $consulta=$this->db->prepare("update linea_pedido set id_pedido=?, id_producto=?, cantidad=?, precio_unitario=? where id_linea_pedido=?");
        $consulta->bind_param("iiidi", $id_pedido, $id_producto, $cantidad, $precio_unitario, $id_linea_pedido);
        $consulta->execute();
        
    }

    //borrar una linea_pedido
    public function delete($id_linea_pedido){

        $consulta=$this->db->prepare("delete from linea_pedido where id_linea_pedido=?");
        $consulta->bind_param("i", $id_linea_pedido);
        $consulta->execute();

    }

    //recupera una linea_pedido por su ID
    function getById($id_linea_pedido){

        //se accede a la base de datos
        $consulta = $this->db->prepare("select * from linea_pedido where id_linea_pedido = ?");
        $consulta->bind_param("i", $id_linea_pedido);
        $consulta->execute();
        $resultado = $consulta->get_result();

        return $resultado->fetch_assoc();
    }
}