<?php
require_once("db/Db.php");
require_once("controller/CUsuario.php");
require_once ("controller/CProducto.php");
require_once ("controller/CSerie.php");
require_once __DIR__ . '/CLogin.php';
require_once __DIR__ . '/CPedido.php';
require_once __DIR__ . '/CLineaPedido.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$entity = isset($_GET['entity']) ? $_GET['entity'] : 'usuario';

switch ($entity) {
    case 'usuario':
        switch ($action) {
            case 'index':
                $controller = new CUsuario();
                $controller->index();
                break;
            default:
                header("Location: index.php?entity=usuario&action=index");
                break;
        }
        break;
    case 'producto':
        switch ($action) {
            case 'index':
                $controller = new CProducto();
                $controller->index();
                break;
            case 'show':
                $controller = new CProducto();
                $controller->show($id);
                break;
            case 'create':
                $controller = new CProducto();
                $controller->create();
                break;
            case 'store':
                $controller = new CProducto();
                $controller->store();
                break;
            case 'edit':
                $controller = new CProducto();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CProducto();
                $controller->update();
                break;
            case 'destroy':
                $controller = new CProducto();
                $controller->destroy($id);
                break;
            default:
                header("Location: index.php?entity=usuario&action=index");
                break;
        }
        break;
    case 'serie':
        switch ($action) {

            case 'index':
                $controller = new CSerie();
                $controller->index();
                break;
            case 'show':
                $controller = new CSerie();
                $controller->show($id);
                break;
            case 'create':
                $controller = new CSerie();
                $controller->create();
                break;
            case 'store':
                $controller = new CSerie();
                $controller->store();
                break;
            case 'edit':
                $controller = new CSerie();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CSerie();
                $controller->update();
                break;
            case 'destroy':
                $controller = new CSerie();
                $controller->destroy($id);
                break;
            default:
                header("Location: index.php?entity=usuario&action=index");
                break;
        }
        break;
    // case 'perfil':
    //     switch ($action) {

    //         case 'index':
    //             $controller = new CPerfil();
    //             $controller->index();
    //             break;
    //         case 'show':
    //             $controller = new CPerfil();
    //             $controller->show($id);
    //             break;
    //         case 'create':
    //             $controller = new CPerfil();
    //             $controller->create();
    //             break;
    //         case 'store':
    //             $controller = new CPerfil();
    //             $controller->store();
    //             break;
    //         case 'edit':
    //             $controller = new CPerfil();
    //             $controller->edit($id);
    //             break;
    //         case 'update':
    //             $controller = new CPerfil();
    //             $controller->update();
    //             break;
    //         case 'destroy':
    //             $controller = new CPerfil();
    //             $controller->destroy($id);
    //             break;
    //         default:
    //             header("Location: index.php?entity=usuario&action=index");
    //             break;
    //     }
    //     break;
    case 'pedido':
        switch ($action) {

            case 'index':
                $controller = new CProducto();
                $controller->index();
                break;
            case 'show':
                $controller = new CProducto();
                $controller->show($id);
                break;
            case 'create':
                $controller = new CProducto();
                $controller->create();
                break;
            case 'store':
                $controller = new CProducto();
                $controller->store();
                break;
            case 'edit':
                $controller = new CProducto();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CProducto();
                $controller->update();
                break;
            case 'destroy':
                $controller = new CProducto();
                $controller->destroy($id);
                break;
            default:
                header("Location: index.php?entity=usuario&action=index");
                break;
        }
        break;
    case 'lineaPedido':
        switch ($action) {

            case 'index':
                $controller = new CLineaPedido();
                $controller->index();
                break;
            case 'show':
                $controller = new CLineaPedido();
                $controller->show($id);
                break;
            case 'create':
                $controller = new CLineaPedido();
                $controller->create();
                break;
            case 'store':
                $controller = new CLineaPedido();
                $controller->store();
                break;
            case 'edit':
                $controller = new CLineaPedido();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CLineaPedido();
                $controller->update();
                break;
            case 'destroy':
                $controller = new CLineaPedido();
                $controller->destroy($id);
                break;
            default:
                header("Location: index.php?entity=usuario&action=index");
                break;
        }
        break;

    case 'login':
        
        switch($action){

            case 'index':

                $controller = new CLogin();
                $controller->index();

            break;

            case 'login':

                $controller = new CLogin();
                $controller->logIn($_POST);

            break;    

            case 'logOut':

                $controller = new CLogin();
                $controller->logOut();
            
            break;

            default:
                header('Location: index.php?entity=login&action=index');
            break;
        }

    break;
    
    default:
        header("Location: index.php?entity=usuario&action=index");
        break;
}