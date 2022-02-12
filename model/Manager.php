<?php
abstract class Manager {
    protected static $dbConnect;
    protected $db;

    function __construct() {
        $this->db = $this->dbConnect();
    }


    protected function dbConnect() {
        if (self::$dbConnect){
            return self::$dbConnect;
        }

        try
        {
            self::$dbConnect = new PDO('mysql:host=localhost;dbname=blog_ocr;charset=utf8', 'sergio', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return self::$dbConnect;
        }
        catch (Exception $e)
        {
            throw new Exception("Erreur de connexion à la base de données");
        }
    }
}