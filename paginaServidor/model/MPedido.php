<?php

class MPedido
{

    //parametros
    private $conexion;
    private $pedidos;

    //constructor
    public function __construct()
    {

        $this->conexion = Db::getConexion();
        $this->pedidos = array();
    }

    //Crear un pedido
    public function insert($id_usuario, $precio_total, $estado_pedido){

        $consulta=$this->conexion->prepare("insert into pedido (id_usuario, precio_total, estado_pedido) values (?, ?, ?)");
        $consulta->bind_param("ids", $id_usuario, $precio_total, $estado_pedido);
        $consulta->execute();
    }

    //ver todos los pedidos
    function getAll(){

        $sql = "SELECT P.id_pedido, P.id_usuario, U.nombre, P.fecha, P.precio_total, P.estado_pedido
                FROM pedido AS P
                JOIN usuario AS U ON P.id_usuario = U.id_usuario;";

        //se accede a la base de datos
        $consulta = $this->conexion->query($sql);

        //se leen los datos
        while ($filas = $consulta->fetch_assoc()) {
            $this->pedidos[] = $filas;
        }

        return $this->pedidos;
    }

    function getAllById($id_usuario){

        $sql = "SELECT P.id_pedido, P.id_usuario, U.nombre, P.fecha, P.precio_total, P.estado_pedido
                FROM pedido AS P
                JOIN usuario AS U ON P.id_usuario = U.id_usuario
                WHERE U.id_usuario = ?;";

        //se prepara la consulta
        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("i", $id_usuario);
        $consulta->execute();

        //se obtiene el resultado
        $consulta = $consulta->get_result();

        //se leen los datos
        $this->pedidos = [];
        while ($filas = $consulta->fetch_assoc()) {
            $this->pedidos[] = $filas;
        }

        return $this->pedidos;
    }

    //actualizar un pedido
    public function edit($id_pedido, $id_usuario, $fecha, $precio_total, $estado_pedido){

        $consulta=$this->conexion->prepare("update pedido set id_usuario=?, fecha=?, precio_total=?, estado_pedido=? where id_pedido=?");
        $consulta->bind_param("isdsi", $id_usuario, $fecha, $precio_total, $estado_pedido, $id_pedido);
        $consulta->execute();
        
    }

    //borrar un pedido
    public function delete($id_pedido){

        $consulta=$this->conexion->prepare("delete from pedido where id_pedido=?");
        $consulta->bind_param("i", $id_pedido);
        $consulta->execute();

    }

    //recupera un pedido por su ID
    function getById($id_pedido){

        $sql = "SELECT P.id_pedido, P.id_usuario, U.nombre, P.fecha, P.precio_total, P.estado_pedido
                FROM pedido AS P
                JOIN usuario AS U ON P.id_usuario = U.id_usuario
                WHERE P.id_pedido = ?;";

        //se accede a la base de datos
        $consulta = $this->conexion->prepare($sql);
        $consulta->bind_param("i", $id_pedido);
        $consulta->execute();
        $resultado = $consulta->get_result();

        return $resultado->fetch_assoc();
    }

    //recupera el ultimo pedido realizado
    function getUltimoPedido($id_usuario){

        $sql = "SELECT id_pedido
                FROM pedido
                WHERE id_usuario = ?
                ORDER BY id_pedido DESC
                LIMIT 1;";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $consulta = $stmt->get_result();

        $fila = $consulta->fetch_assoc();

        return $fila ? (int) $fila['id_pedido'] : null;
    }
   
}
