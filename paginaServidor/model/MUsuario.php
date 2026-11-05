<?php
class MUsuario {
    private $conexion;

    public function __construct()
    {
        $this->conexion = Db::getConexion();
    }

    public function getByEmail($email) {
        $resultado = null;

        $sentencia = $this->conexion->prepare("SELECT id_usuario FROM usuario WHERE email = ?;");
        $sentencia->bind_param("s", $email);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $sentencia->close();
        return $resultado->fetch_assoc();
    }

    public function getById($id) {
        $resultado = null;

        $sentencia = $this->conexion->prepare("SELECT * FROM usuario WHERE id_usuario = ?;");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $sentencia->close();
        return $resultado->fetch_assoc();
    }

    public function getAll() {
        $resultado = [];

        $sentencia = $this->conexion->query("SELECT * FROM usuario;");

        while($fila = $sentencia->fetch_assoc()) {
            $resultado[] = $fila;
        }

        $sentencia->close();
        return $resultado;
    }

    public function insert($data) {
        $sentencia = $this->conexion->prepare("INSERT INTO usuario VALUES(?, ?, ?, ?);");
        $sentencia->bind_param("ssss", $data["nombre"], $data["email"], $data["password"], $data["rol"]);

        $sentencia->execute();
        $sentencia->close();

        $id = getByEmail($data["email"]);
        return $id;
    }

    public function edit($id, $data) {
        $sentencia = $this->conexion->prepare("UPDATE usuario SET nombre = ?, email = ?, password = ?, rol = ? WHERE id_usuario = ?;");
        $sentencia->bind_param("ssssi", $data["nombre"], $data["email"], $data["password"], $id);

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