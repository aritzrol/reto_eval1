<?php

    require_once __DIR__ . '/../model/MLogin.php';

    class CLogin{

        private MLogin $model;

        public function __construct()
        {
            $this->model = new MLogin();
        }

        public function index(){

            //ventana
            require_once __DIR__ . '/../view/VLogin.php';

        }

        //LOGIN
        public function login($data){

            //se comprueba que los datos existan para evitar errores si llegan vacios
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            var_dump($email, $password);
            exit();

            //modelo
            $usuarioEncontrado = $this->model->getLogin($email, $password);

            if($usuarioEncontrado){
                //si el login es OK, se incia la sesion
                if(session_status() === PHP_SESSION_NONE){
                    session_start();
                }

                //se guardan los datos del login en la sesion
                $_SESSION['logged_in_user'] = $usuarioEncontrado['email'];
                $_SESSION['user_id'] = $usuarioEncontrado['id_usuario'];
                $_SESSION['user_rol'] = $usuarioEncontrado['rol'];

                //se va a series
                header("Location: index.php?entity=serie&action=index");
                exit();
            }

            //login incorrecto: se vuelve al formulario
            header("Location: index.php?entity=login&action=index");
            exit();

        }
    

        //LOGOUT
    public function logout(){

            // Iniciamos la sesión si no lo está para poder destruirla
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Vaciamos las variables de sesión
            session_unset();
            // Destruimos la sesión por completo
            session_destroy();

            // Redirigimos de vuelta al login
            header("Location: index.php?entity=login&action=index");
            exit();

        }

    }

?>