<?php 
declare(strict_types=1);

require_once __DIR__. '/../config/conexion.php';

class producto{

    private PDO $db;

    public function __construct()
    {
        $this->db = conexion::getInstance()->getConexion();    
    }

    public function insertar(string $nombre,float $precio,int $idcategoria): bool
    {
        $sql = "INSERT INTO productos (nombre, precio, id_categoria)
                VALUES (:nombre, :precio, :id_categoria)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre' => htmlspecialchars(trim($nombre)),
            ':precio' => $precio,
            'id_categoria' => $idcategoria
        ]);
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT 
                    productos.id,
                    productos.nombre,
                    productos.precio,
                    categorias.nombre AS categorias
                FROM productos
                JOIN categorias
                    ON productos.id_categoria = categorias.id";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    
    public function buscar(string $busqueda = '', ?float $precio = null): array
    {
        $sql = "SELECT 
                    productos.id,
                    productos.nombre,
                    productos.precio,
                    categorias.nombre AS categorias
                FROM productos
                JOIN categorias
                    ON productos.id_categoria = categorias.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($busqueda)){
            $sql .= " AND productos.nombre LIKE :nombre";
            $params[':nombre'] = "%$busqueda%";
        }

        if ($precio !== null){
            $sql .= " AND productos.precio >= :precio";
            $params[':precio'] = $precio;
        }


        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }


    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT * FROM productos WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    public function actualizar(int $id, string $nombre, float $precio, int $idcategoria): bool
    {
        $sql = "UPDATE productos
                SET nombre = :nombre,
                    precio = :precio,
                    id_categoria = :id_categoria
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nombre' => htmlspecialchars(trim($nombre)),
            ':precio' => $precio,
            ':id_categoria' => $idcategoria
        ]);
    }
}




?>