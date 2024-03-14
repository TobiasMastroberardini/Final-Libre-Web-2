<?php
require_once './app/models/PrestadoresModel.php';
require_once "./app/models/SegurosModel.php";
require_once './app/views/PrestadoresView.php';
require_once "./app/helpers/AuthHelper.php";

class PrestadoresController
{
    private $model;
    private $segurosModel;
    private $view;

    public function __construct()
    {
        $this->model = new PrestadoresModel();
        $this->segurosModel = new SegurosModel();
        $this->view = new PrestadoresView();
    }

    public function showPrestadorById($prestadorId)
    {
        $prestador = $this->model->getPrestadorById($prestadorId);
        $opiniones = $this->model->getOpinionesByPrestadorId($prestadorId);

        if ($prestador) {
            $this->view->showPrestador($prestador, $opiniones);
        } else {
            $ErrorView = new ErrorView();
            $ErrorView->showError('El prestador no existe.');
        }
    }

    public function showPrestadores()
    {
        $prestadores = $this->model->getPrestadores();
        foreach ($prestadores as $prestador) {
            $prestador->fechaCreacion = AuxHelper::reformatDate($prestador->fechaCreacion);
        }
        $this->view->showPrestadores($prestadores);
    }

    public function showAddPrestador($message = null)
    {
        $this->view->showAddPrestador($message);
    }

    public function addNewPrestador()
    {
        // Verificar si los campos necesarios están presentes en el formulario
        if (empty($_POST['nombrePrestador']) || empty($_POST['fechaCreacion']) || empty($_POST['origen'])) {
            $this->showAddPrestador('Faltan completar campos');
            return; // Detener la ejecución si faltan campos
        }

        // Verificar si el usuario está autenticado
        if (!AuthHelper::isLogged()) {
            header('Location: ' . BASE_URL . '/prestadores');
            return; // Detener la ejecución si el usuario no está autenticado
        }

        // Obtener los datos del formulario
        $nombrePrestador = $_POST['nombrePrestador'];
        $fechaFundacion = $_POST['fechaCreacion'];
        $origen = $_POST['origen'];

        // Llamar a la función que agrega el prestador con la opinión asociada
        $lastPrestadorId = $this->model->addPrestador($nombrePrestador, $fechaFundacion, $origen);
        // Verificar si la inserción fue exitosa
        if (!$lastPrestadorId) {
            // Redirigir a la página de prestadores
            header('Location: ' . BASE_URL . '/prestadores');
        } else {
            // Manejar el error, podrías redirigir a una página de error
            echo "Error al agregar el prestador con la opinión.";
        }
    }


    public function editPrestador($id)
    {
        $prestador = $this->model->getPrestadorById($id);
        $this->view->showEditPrestador($prestador);
    }

    public function prestadorEdited($id)
    {
        if (AuthHelper::isLogged()) {
            $this->model->editPrestador($id);
        }
        header('Location: ' . BASE_URL . '/prestadores');
    }

    public function deletePrestador($id)
    {
        $seguros = $this->segurosModel->getSegurosByPrestadorId($id);
        if (count($seguros) == 0 && AuthHelper::isLogged()) {
            $this->model->deletePrestador($id);
        }else {
            $this->errorView->showError("El prestador aun tiene seguros");
        }
    }
}
