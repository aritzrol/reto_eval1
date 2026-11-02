<?php
    require_once("db/Db.php");
    require_once("controller/CUsuario.php");

    $action = isset($_GET['action']) ? $_GET['action'] : 'index';
    $entity = isset($_GET['entity']) ? $_GET['entity'] : 'usuario';

    switch($entity){
        case 'usuario':
            switch($action) {
                case 'index':
                    $controller = new CUsuario();
                    $controller->index();
                    break;
                default:
                    header("Location: index.php?entity=usuario&action=index");
                    break;
            }
            break;
        default:
            header("Location: index.php?entity=usuario&action=index");
            break;
    }
?>