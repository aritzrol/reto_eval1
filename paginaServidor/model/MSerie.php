<?php
class MSerie {
    private $conexion;

    public function __construct()
    {
        $this->conexion = Db::getConexion();
    }

    public function getById($id) {
        $resultado = null;

        $sentencia = $this->conexion->prepare("SELECT * FROM serie WHERE id_serie = ?;");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $sentencia->close();
        return $resultado->fetch_assoc();
    }

    public function getAll() {
        $resultado = [];

        $sentencia = $this->conexion->query("SELECT * FROM serie;");

        while($fila = $sentencia->fetch_assoc()) {
            $resultado[] = $fila;
        }

        $sentencia->close();
        return $resultado;
    }

    public function insert($data) {
        $sentencia = $this->conexion->prepare("INSERT INTO serie VALUES(?, ?, ?, ?, ?);");
        $sentencia->bind_param("sssss", $data["nombre"], $data["sinopsis"], $data["genero"], $data["autor"], $data["editorial"]);

        $sentencia->execute();
        $sentencia->close();
    }

    public function edit($id, $data) {
        $sentencia = $this->conexion->prepare("UPDATE serie SET nombre = ?, sinopsis = ?, genero = ?, autor = ?, editorial = ? WHERE id_usuario = ?;");
        $sentencia->bind_param("sssssi", $data["nombre"], $data["sinopsis"], $data["genero"], $data["autor"], $data["editorial"], $id);

        $sentencia->execute();
        $sentencia->close();
    }

    public function delete($id) {
        $sentencia = $this->conexion->prepare("DELETE FROM serie WHERE id_usuario = ?;");
        $sentencia->bind_param("i", $id);

        $sentencia->execute();
        $sentencia->close();
    }
}
?>