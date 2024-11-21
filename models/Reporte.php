<?php
class Reporte{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function obtenerReporte($BeginDate,$EndDate){
        try{
            $sql = "SELECT f.idfactura,f.fecha,f.total,
                            concat(c.nombres,' ',c.apellidos) as cliente,
                            concat(e.nombre,' ',e.apellido) as empleado
                    FROM factura f 
                    join cliente c on f.idcliente=c.idcliente
                    join empleado e on f.idempleado=e.idempleado
                    WHERE fecha BETWEEN :BeginDate AND :EndDate";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":BeginDate", $BeginDate);
            $stmt->bindParam(":EndDate", $EndDate);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOException $e){
            throw new Exception("Error al obtener reporte: " . $e->getMessage());
        }
    }
}
?>