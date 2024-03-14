<?php
require_once "./app/models/SegurosModel.php";
require_once "./app/models/PrestadoresModel.php";
require_once "./app/views/SegurosView.php";
require_once "./app/views/ErrorView.php";
require_once "./app/helpers/AuxHelper.php";

class SegurosController
{
    private $segurosModel;
    private $prestadoresModel;
    private $view;

    public function __construct()
    {
        $this->segurosModel = new SegurosModel();
        $this->prestadoresModel = new PrestadoresModel();
        $this->view = new SegurosView();
    }

    public function showSeguros($prestadorId = -1)
    {
        if ($prestadorId == -1) {
            $seguros = $this->segurosModel->getSeguros();
        } else {
            $seguros = $this->segurosModel->getSegurosByPrestadorId($prestadorId);
        }
        $prestadores = $this->prestadoresModel->getPrestadores();
        foreach ($seguros as $seguro) {
            $seguro->fechaFinalizacion = AuxHelper::reformatDate($seguro->fechaLanzamiento);
        }
        $this->view->showSeguros($seguros, $prestadores);
    }

    public function showAddSeguro($message = null)
    {
        $prestadores = $this->prestadoresModel->getPrestadores();
        $this->view->showAddSeguro($prestadores, $message);
    }
    public function addNewSeguro()
    {
        if (empty($_POST['nombreSeguro']) || empty($_POST['fechaLanzamiento']) || empty($_POST['prestadorId']) || empty($_POST['coberturaMaxima']) || empty($_POST['descripcionSeguro']) || empty($_POST['imagen'])) {
            $this->showAddSeguro('Faltan completar campos');
        } elseif (AuthHelper::isLogged()) {
            $this->segurosModel->addSeguro();
            header('Location: ' . BASE_URL);
        } else {
            header('Location: ' . BASE_URL);
        }
    }


    public function showSeguroById($id)
    {
        $seguro = $this->segurosModel->getSeguroById($id);
        $seguro->fechaFinalizacion =
            AuxHelper::reformatDate($seguro->fechaLanzamiento);

        if ($seguro) {
            $this->view->showSeguro($seguro);
        } else {
            $ErrorView = new ErrorView();
            $ErrorView->showError('la cobertura seleccionado no existe.');
        }
    }

    public function deleteSeguro($id)
    {
        if (AuthHelper::isLogged()) {
            $this->segurosModel->deleteSeguro($id);
        }
        header('Location: ' . BASE_URL);
    }

    public function editSeguro($id)
    {
        $seguro = $this->segurosModel->getSeguroById($id);
        $prestadores = $this->prestadoresModel->getPrestadores();
        $this->view->showEditSeguro($seguro, $prestadores);
    }

    public function seguroEdited($id)
    {
        if (AuthHelper::isLogged()) {
            $this->segurosModel->editSeguro($id);
        }
        header('Location: ' . BASE_URL);
    }
}
