<?php

class MLineaPedido{

    //parametros
    private $conexion;
    private $lineaPedidos;

    public function __construct()
    {
        $this->conexion = Db::getConexion();
        $this->lineaPedidos = array();
    }

    //Crear una linea de pedido
    public function insert($id_usuario, $id_producto, $cantidad, $precio_unitario, $estado_pedido){

        $consulta=$this->conexion->prepare("insert into linea_pedido (id_usuario, id_producto, cantidad, precio_unitario, estado_pedido) values (?, ?, ?, ?, ?)");
        $consulta->bind_param("iiids", $id_usuario, $id_producto, $cantidad, $precio_unitario, $estado_pedido);
        $consulta->execute();
    }

    //ver todos los pedidos
    function getAll($id_usuario){

        // $sql = "SELECT * FROM linea_pedido WHERE id_usuario = ?";
        $sql = "SELECT L.id_linea_pedido, L.id_usuario, L.id_producto, L.cantidad, L.precio_unitario,
                    S.nombre, P.numero
                FROM linea_pedido L
                JOIN producto P ON P.id_producto = L.id_producto
                JOIN serie S ON S.id_serie = P.id_serie
                WHERE L.id_usuario = ? AND L.estado_pedido = 'carrito';";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $consulta = $stmt->get_result();

        $lineaPedidos = [];
        while ($filas = $consulta->fetch_assoc()) {
            $lineaPedidos[] = $filas;
        }

        return $lineaPedidos;
    }

    //actualizar un pedido
    public function edit($id_linea_pedido, $id_pedido, $id_producto, $cantidad, $precio_unitario){

        $consulta=$this->conexion->prepare("update linea_pedido set id_pedido=?, id_producto=?, cantidad=?, precio_unitario=? where id_linea_pedido=?");
        $consulta->bind_param("iiidi", $id_pedido, $id_producto, $cantidad, $precio_unitario, $id_linea_pedido);
        $consulta->execute();
        
    }

    //borrar una linea_pedido
    public function delete($id_linea_pedido){

        $consulta=$this->conexion->prepare("delete from linea_pedido where id_linea_pedido=?");
        $consulta->bind_param("i", $id_linea_pedido);
        $consulta->execute();

    }

    //recupera una linea_pedido por su ID
    function getById($id_linea_pedido){

        //se accede a la base de datos
        $consulta = $this->conexion->prepare("select * from linea_pedido where id_linea_pedido = ?");
        $consulta->bind_param("i", $id_linea_pedido);
        $consulta->execute();
        $resultado = $consulta->get_result();

        return $resultado->fetch_assoc();
    }

    //obtiene la suma del carrito antes de crear un pedido
    function getTotalSum($id_usuario){

        $sql = "SELECT COALESCE(SUM(cantidad * precio_unitario), 0) AS total
                FROM linea_pedido
                WHERE id_usuario = ? AND estado_pedido = 'carrito';";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $consulta = $stmt->get_result();

        $fila = $consulta->fetch_assoc();

        return (float) $fila['total'];
    }

    //actualiza el carrito
    function updateCarritoAPagado($id_pedido, $id_usuario){

        $sql = "UPDATE linea_pedido
                SET id_pedido = ?, estado_pedido = 'pagado'
                WHERE id_usuario = ? AND estado_pedido = 'carrito';";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $id_pedido, $id_usuario);
        $stmt->execute();

        return $stmt->affected_rows;
    }
}