<?php
// Hacemos un require_once de los controllers que usamos
require_once 'config.php';
require_once './app/controllers/SegurosController.php';
require_once './app/controllers/PrestadoresController.php';
require_once './app/controllers/ErrorController.php';
require_once './app/controllers/AuthController.php';

// Definimos la constante "BASE_URL"
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$action = 'seguros'; // Accion por defecto
// Verificamos que la acción exista
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}


// parseamos la accion para separar accion real de parametros
$params = explode('/', $action);

switch ($params[0]) {
    case 'seguros':
        $controller = new SegurosController();
        if (isset($params[1]) && $params[1] == 'prestador') {
            $controller->showSeguros($params[2]);
        } else {
            $controller->showSeguros();
        }
        break;
    case 'seguro':
        $controller = new SegurosController();
        $controller->showSeguroById($params[1]);
        break;
    case 'add-seguro':
        $controller = new SegurosController();
        $controller->showAddSeguro();
        break;
    case 'add-new-seguro':
        $controller = new SegurosController();
        $controller->addNewSeguro();
        break;
    case 'delete-seguro':
        $controller = new SegurosController();
        $controller->deleteSeguro($params[1]);
        break;
    case 'edit-seguro':
        $controller = new SegurosController();
        $controller->editSeguro($params[1]);
        break;
    case 'seguro-edited':
        $controller = new SegurosController();
        $controller->seguroEdited($params[1]);
        break;
    case 'prestadores':
        $controller = new PrestadoresController();
        $controller->showPrestadores();
        break;
    case 'add-prestador':
        $controller = new PrestadoresController();
        $controller->showAddPrestador();
        break;
    case 'add-new-prestador':
        $controller = new PrestadoresController();
        $controller->addNewPrestador();
        break;
    case 'delete-prestador':
        $controller = new PrestadoresController();
        $controller->deletePrestador($params[1]);
        break;
    case 'edit-prestador':
        $controller = new PrestadoresController();
        $controller->editPrestador($params[1]);
        break;
    case 'prestador-edited':
        $controller = new PrestadoresController();
        $controller->prestadorEdited($params[1]);
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'auth':
        $controller = new AuthController();
        $controller->auth();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'hash':
        echo password_hash('admin', PASSWORD_DEFAULT);
        break;
    default:
        $controller = new ErrorController();
        $controller->notFound();
        break;
}
