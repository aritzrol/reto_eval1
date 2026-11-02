<?php
require_once __DIR__ . '/../db/db.php';

class Login {
    private $con;

    public function __construct($con = null) {
        $this->con = $con ?? DB::getConexion();
    }

    // Busca el correo y comprueba la contraseña. Devuelve el usuario o null.
    public function comparar($email, $password) {
        $sentencia = $this->con->prepare(
            "SELECT id_usuario, nombre, email, password, rol FROM usuario WHERE email = ?"
        );

        if (!$sentencia) {
            return null;
        }

        $sentencia->bind_param("s", $email);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $usuario = $resultado->fetch_assoc();
        $sentencia->close();

        if ($usuario && password_verify($password, $usuario["password"])) {
            unset($usuario["password"]);
            return $usuario;
        }

        return null;
    }
}
?>