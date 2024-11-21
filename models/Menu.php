<?php 
class Menu{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerMenu(){
        try {
            $sql = "select m.idmenu,m.nombre,m.descripcion,m.precio,c.categoria 
		            from menu m 
			            join categoria c 	
				        on m.idcategoria=c.idcategoria;";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Error al obtener el menu: " . $e->getMessage();
            return false;
        }
    }
    public function obtenerMenuCRUD(){
        try {
            $sql = "SELECT c.idcategoria,m.idmenu,m.nombre,m.descripcion,m.precio,c.categoria
	                    FROM menu m JOIN categoria c ON m.idcategoria = c.idcategoria;";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Error al obtener el menu: " . $e->getMessage();
            return false;
        }
    }
    public function agregarItemMenu($nombre,$descripcion,$precio,$idcategoria){
        try {
            $sql = "INSERT INTO menu (nombre, descripcion, precio, idcategoria) 
                        VALUES (:nombre, :descripcion,:precio,:idcategoria)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":precio", $precio);
            $stmt->bindParam(":idcategoria", $idcategoria);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al agregar emenu: " . $e->getMessage();
            return false;
        }        
    }
    public function actualizarItemMenu($idmenu,$nombre,$descripcion,$precio,$idcategoria){
        try {
            $sql = "UPDATE menu SET 
                        nombre=:nombre, 
                        descripcion = :descripcion, 
                        precio = :precio,
                        idcategoria = :idcategoria
                        WHERE idmenu=:idmenu";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":precio", $precio);
            $stmt->bindParam(":idcategoria", $idcategoria);
            $stmt->bindParam(":idmenu", $idmenu);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al agregar empleado: " . $e->getMessage();
            return false;
        }        
    }
    
}
?>