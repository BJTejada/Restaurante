<?php
class Mesa{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerMesas(){
        try {
            $sql = "SELECT * FROM mesa order by mesa.estadoMesa asc";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve los resultados como un array asociativo
        } catch (PDOException $e) {
            // Manejo de errores en caso de fallo de la consulta
            echo "Error al obtener las mesas: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarMesa($idmesa,$estadoMesa) {
        try {
            $query = "UPDATE mesa SET estadoMesa = :estadoMesa WHERE idmesa = :idmesa;";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':estadoMesa', $estadoMesa, PDO::PARAM_STR);
            $stmt->bindParam(':idmesa', $idmesa, PDO::PARAM_INT);
            
            if ($stmt->execute()){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            // Si ocurre un error al ejecutar la consulta
            echo "Error al editar cliente: " . $e->getMessage();
            return false;
        }
    }  
}
?>