<?php
//se inicia la session para acceder a los datos del usuario logeado
session_start();

require_once("db/Db.php");
require_once("controller/CUsuario.php");
require_once ("controller/CProducto.php");
require_once ("controller/CSerie.php");
require_once ("controller/CLogin.php");
require_once ("controller/CLineaPedido.php");
// require_once __DIR__ . '/CPerfil.php';
require_once __DIR__ . '/CPedido.php';


//define acciones por defecto
$entity = isset($_GET['entity']) ? $_GET['entity'] : 'login';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($entity) {
    case 'usuario':
        switch ($action) {
            case 'index':
                $controller = new CUsuario();
                $controller->index();
                break;
            case 'show':
                $controller = new CUsuario();
                $controller->show($id);
                break;
            case 'create':
                $controller = new CUsuario();
                $controller->create();
                break;
            case 'store':
                $controller = new CUsuario();
                $controller->store($_POST);
                break;
            case 'edit':
                $controller = new CUsuario();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CUsuario();
                $controller->update($_POST);
                break;
            case 'destroy':
                $controller = new CUsuario();
                $controller->destroy($id);
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
                $controller->create($id);
                break;
            case 'store':
                $controller = new CProducto();
                $controller->store($_POST);
                break;
            case 'edit':
                $controller = new CProducto();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CProducto();
                $controller->update($_POST);
                break;
            case 'destroy':
                $controller = new CProducto();
                $controller->destroy($id);
                break;
            default:
                header("Location: index.php?entity=serie&action=index");
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
                $controller->store($_POST);
                break;
            case 'edit':
                $controller = new CSerie();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CSerie();
                $controller->update($_POST);
                break;
            case 'destroy':
                $controller = new CSerie();
                $controller->destroy($id);
                break;
            default:
                header("Location: index.php?entity=serie&action=index");
                break;
         }
        break;
    case 'pedido':
        switch ($action) {

            case 'index':
                $controller = new CPedido();
                $controller->index();
                break;
            case 'indexById':
                $controller = new CPedido();
                $controller->indexById();
                break;
            case 'show':
                $controller = new CPedido();
                $controller->show($id);
                break;
            case 'create':
                $controller = new CPedido();
                $controller->create();
                break;
            case 'store':
                $controller = new CPedido();
                $controller->store($_POST);
                break;
            case 'edit':
                $controller = new CPedido();
                $controller->edit($id);
                break;
            case 'update':
                $controller = new CPedido();
                $controller->update($_POST);
                break;
            case 'destroy':
                $controller = new CPedido();
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
                $controller->store($id);
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
                header("Location: index.php?entity=serie&action=index");
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
                $controller->login($_POST);

            break;    

            case 'logout':

                $controller = new CLogin();
                $controller->logout();
            
            break;

            default:
                header('Location: index.php?entity=login&action=index');
            break;
        }

    break;
    
    default:
        header("Location: index.php?entity=serie&action=index");
        break;
}