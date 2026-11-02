<?php
class MPerfil {
    private $conexion;

    public function __construct()
    {
        $this->conexion = Db::conexion();
    }

    public function getById($id) {
        $resultado = null;

        $sentencia = $this->conexion->prepare("SELECT * FROM perfil WHERE id_usuario = ?;");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $sentencia->close();
        return $resultado->fetch_assoc();
    }

    public function getAll() {
        $resultado = [];

        $sentencia = $this->conexion->query("SELECT * FROM perfil;");

        while($fila = $sentencia->fetch_assoc()) {
            $resultado[] = $fila;
        }

        $sentencia->close();
        return $resultado;
    }

    public function insert($data) {
        $sentencia = $this->conexion->prepare("INSERT INTO perfil VALUES(?, ?, ?, ?);");
        $sentencia->bind_param("isss", $data["id_usuario"], $data["apellidos"], $data["telefono"], $data["direccion"]);

        $sentencia->execute();
        $sentencia->close();
    }

    public function edit($id, $data) {
        $sentencia = $this->conexion->prepare("UPDATE perfil SET, apellidos = ?, telefono = ?, direccion = ? WHERE id_usuario = ?;");
        $sentencia->bind_param("sssi", $data["apellidos"], $data["telefono"], $data["direccion"], $id);

        $sentencia->execute();
        $sentencia->close();
    }

    public function delete($id) {
        $sentencia = $this->conexion->prepare("DELETE FROM arma WHERE id_usuario = ?;");
        $sentencia->bind_param("i", $id);

        $sentencia->execute();
        $sentencia->close();
    }
}
?>