<?php

class PrestadoresView
{
    public function showPrestadores($prestadores)
    {
        require './templates/prestadoresList.phtml';
    }

    public function showAddPrestador($message)
    {
        require './templates/addPrestador.phtml';
    }

    public function showPrestador($prestador, $opiniones)
    {
        require './templates/prestador.phtml';
    }

    public function showEditPrestador($prestador)
    {
        require './templates/editPrestador.phtml';
    }
}
