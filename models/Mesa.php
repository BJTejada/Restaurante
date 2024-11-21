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
            echo "Error al editar mesa: " . $e->getMessage();
            return false;
        }
    }
    public function modificarMesa($idmesa,$numero,$zona,$capacidad){
        try {
            $query = "UPDATE mesa SET 
                            numero = :numero,
                            zona = :zona,
                            capacidad = :capacidad
                        WHERE idmesa = :idmesa;";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
            $stmt->bindParam(':zona', $zona, PDO::PARAM_STR);
            $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
            $stmt->bindParam(':idmesa', $idmesa, PDO::PARAM_INT);
            
            if ($stmt->execute()){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            // Si ocurre un error al ejecutar la consulta
            echo "Error al editar mesa: " . $e->getMessage();
            return false;
        }
    } 
    public function crearMesa($numero,$zona,$capacidad){
        try {
            $estadoMesa = 'disponible';
            $query = "INSERT INTO MESA(numero,zona,capacidad,estadoMesa)
                        values(:numero,:zona,:capacidad,:estadoMesa)";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':numero', $numero, PDO::PARAM_STR);
            $stmt->bindParam(':zona', $zona, PDO::PARAM_STR);
            $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_STR);
            $stmt->bindParam(':estadoMesa', $estadoMesa, PDO::PARAM_STR);
            if ($stmt->execute()){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            // Si ocurre un error al ejecutar la consulta
            echo "Error al crear mesa: " . $e->getMessage();
            return false;
        }
    } 
}
?>