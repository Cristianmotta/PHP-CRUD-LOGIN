<?php
declare(strict_types=1);

class conexion
{
    private static ?conexion $instancia = null;
    private PDO $pdo;

    private function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=crud;charset=utf8mb4";

        $this->pdo =  new PDO($dsn, 'root', '',[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance(): self
    {
        if (self::$instancia === null){
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function getConexion(): PDO
    {
        return $this->pdo;
    }
}

?>