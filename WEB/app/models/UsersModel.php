<?php

require_once './app/helpers/AuxHelper.php';

class UsersModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        } catch (\Throwable $th) {
            AuxHelper::deployDB();
            $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        }
    }

    public function getUser()
    {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE usuario = ?');
        $query->execute([$_POST['usuario']]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
