<?php

class Conexion {

    private $host; //localhost o IP
    private $user; //Usuario de la bd 
    private $password; //contraseña
    private $database; //nombre de bd -> usuario 
    private $charset; //utf8
    private $port;

    public function __construct() {
        $this->host = '127.0.0.1';
        $this->user =  'root';
        $this->password = '';
        $this->database = 'blogbd'; 
        $this->charset = 'utf8';
        $this->port = '3306';
    }

    public function conectar() {
        $com = "mysql:host=".$this->host.";dbname=".$this->database.";charset=".$this->charset;
        $conexion = new PDO($com, $this->user, $this->password);

        return $conexion;
    }
}
?>