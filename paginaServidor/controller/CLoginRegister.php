<?php

    require_once __DIR__ . '/../model/MLogin.php';
    require_once __DIR__ . '/../model/MUsuario.php';

    class CLoginRegister{

        private MLogin $loginModel;
        private MUsuario $usuarioModel;

        public function __construct()
        {
            $this->loginModel = new MLogin();
            $this->usuarioModel = new MUsuario();
        }

        public function index(){

            //ventana
            require_once __DIR__ . '/../view/VLogin.php';

        }

        public function login($data){

            //se comprueba que los datos existan para evitar errores si llegan vacios
            $email = $data['login-email'] ?? '';
            $password = $data['login-password'] ?? '';

            //modelo
            $usuarioEncontrado = $this->loginModel->getLogin($email, $password);

            if($usuarioEncontrado){
                //si el login es OK, se incia la sesion
                if(session_status() === PHP_SESSION_NONE){
                    session_start();
                }

                //se guardar los datos del login en la sesion
                $_SESSION['logged_in_user'] = $usuarioEncontrado['email'];
                $_SESSION['user_id'] = $usuarioEncontrado['id_usuario'];
                // $_SESSION['user_rol'] = 

                // header("Location: index.php?entity=);
            }
        }

    }

?>