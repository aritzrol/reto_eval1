<?php
require_once __DIR__ . '/../db/Db.php';

class MLogin {
    private $con;

    public function __construct() {
        $this->con = DB::getConexion();
    }

    // Busca el correo y comprueba la contraseña. Devuelve el usuario o null.
    public function getLogin($email, $password) {

        $sql = "select * FROM usuario WHERE email = ?;";

        $consulta = $this->con->prepare($sql);

        $consulta->bind_param("s", $email);
        $consulta->execute();
        $resultado = $consulta->get_result();

        $usuario = $resultado->fetch_assoc();
        $consulta->close();

        if($resultado->num_rows > 0){

            if(password_verify($password, $usuario['password'])){
                return $usuario;
            }
        }

        return false;
    }
}
?>