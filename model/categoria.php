<?php   
declare(strict_types=1);

require_once __DIR__. '/../config/conexion.php';

class categoria{

    private PDO $db;

    public function __construct()
    {
        $this->db = conexion::getInstance()->getConexion();
    }

    public function obtenerTodas(): array
    {
        $stmt = $this->db->query("SELECT * FROM categorias");
        return $stmt->fetchAll();
    }

    public function insertar(string $nombre): bool
    {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
        return $stmt->execute([
            ':nombre' => htmlspecialchars(trim($nombre))
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
        return  $stmt->execute(['id' => $id]);
    }
}

?>