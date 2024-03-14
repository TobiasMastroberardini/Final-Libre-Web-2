<?php

class SegurosView
{
    public function showSeguros($seguros, $prestadores)
    {
        require './templates/segurosList.phtml';
    }

    public function showSeguro($seguro)
    {
        require './templates/seguro.phtml';
    }

    public function showAddSeguro($prestadores, $message)
    {
        require './templates/addSeguro.phtml';
    }

    public function showEditSeguro($seguro, $prestadores)
    {
        require './templates/editSeguro.phtml';
    }
}
