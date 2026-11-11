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


    public function getByIdUsuarioPerfil($id) {
        $resultado = [];

        $sql = "SELECT U.id_usuario, U.nombre, P.apellidos, U.email, P.telefono, P.direccion, U.rol
                FROM USUARIO AS U
                JOIN PERFIL AS P ON U.id_usuario = P.id_usuario 
                WHERE U.id_usuario = ?;";

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param("i", $id);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        $sentencia->close();
        return $resultado->fetch_assoc();

        // $sentencia = $this->conexion->query($sql);

        // while($fila = $sentencia->fetch_assoc()) {
        //     $resultado[] = $fila;
        // }

        // $sentencia->close();
        // return $resultado;
    }

    public function insert($data) {
        $sentencia = $this->conexion->prepare("INSERT INTO usuario VALUES(?, ?, ?, ?);");
        $sentencia->bind_param("ssss", $data["nombre"], $data["email"], $data["password"], $data["rol"]);

        $sentencia->execute();
        $sentencia->close();

        $id = getByEmail($data["email"]);
        return $id;
    }

    public function edit($id_usuario, $nombre, $email, $rol) {
        $sentencia = $this->conexion->prepare("UPDATE usuario SET nombre = ?, email = ?, rol = ? WHERE id_usuario = ?;");
        $sentencia->bind_param("sssi", $nombre, $email, $rol, $id_usuario);

        $sentencia->execute();
        $sentencia->close();
    }

    public function delete($id) {
        $sentencia = $this->conexion->prepare("DELETE FROM usuario WHERE id_usuario = ?;");
        $sentencia->bind_param("i", $id);

        $sentencia->execute();
        $sentencia->close();
    }
}
?>