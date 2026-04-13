<?php
declare(strict_types=1);

require_once __DIR__. '/../config/conexion.php';

class usuario
{
    private PDO $db;

    public function __construct()
    {
        $this->db = conexion::getInstance()->getConexion();
    }

    public function insertar(string $nombre, string $correo, string $password, string $fechNac): bool
    {
        $sql = "INSERT INTO usuario (nombre, correo, password, fech_nac)
                VALUES (:nombre, :correo, :password, :fech_nac)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre' => htmlspecialchars(trim($nombre)),
            ':correo' => filter_var($correo, FILTER_SANITIZE_EMAIL),
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':fech_nac' => $fechNac
        ]);
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT id, nombre, correo, fech_nac FROM usuario ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): array|null
    {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function actualizar(int $id, string $nombre, string $correo, string $fechNac): bool
    {
        $sql = "UPDATE usuario
                SET nombre = :nombre, correo = :correo, fech_nac = :fech_nac
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre' => htmlspecialchars(trim($nombre)),
            ':correo' => filter_var($correo, FILTER_SANITIZE_EMAIL),
            ':fech_nac' => $fechNac,
            ':id' => $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM usuario WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerPorCorreo(string $correo): array|null
    {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE correo = :correo");
        $stmt->execute([':correo' => $correo]);

        return $stmt->fetch() ?: null;
    }

}


?>