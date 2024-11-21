<?php
class DetalleFactura{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function obtenerDetalleFacturaId($idFactura) {
        try {
            $sql = "SELECT df.iddetallefactura, df.idmenu, m.nombre, m.precio, df.cantidad, df.subtotal
                    FROM detallefactura df
                    JOIN factura f ON df.idfactura = f.idfactura 
                    JOIN menu m ON df.idmenu = m.idmenu
                    WHERE df.idfactura = :idfactura";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":idfactura", $idFactura);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Error al obtener los detalles de factura: " . $e->getMessage());
        }
    }
    /* camino equivocado pero dejo la funcion por si acaso*/
    public function obtenerDetalleFactura(){

    }

    public function insertarDetalleFactura($idfactura,$idmenu,$cantidad,$subtotal){
        try {
            $sql = "INSERT INTO detallefactura (idfactura, idmenu, cantidad,subtotal) VALUES (:idfactura,:idmenu,:cantidad,:subtotal)";
            $stmt = $this->conn->prepare($sql);

            // Vincula los parámetros
            $stmt->bindParam(":idfactura", $idfactura);
            $stmt->bindParam(":idmenu", $idmenu);
            $stmt->bindParam(":cantidad", $cantidad);
            $stmt->bindParam(":subtotal", $subtotal);
            // Ejecuta la consulta
            if ($stmt->execute()) {
                return true;  // Si la inserción es exitosa
            } else {
                return false; // Si algo falló
            }
        } catch (PDOException $e) {
            // Si ocurre un error al ejecutar la consulta
            echo "Error al registrar detalle factura: " . $e->getMessage();
            return false;
        }
    }

    public function removerDetalleFactura($iddetallefactura){
        try {
            $sql = "DELETE FROM detallefactura WHERE iddetallefactura = :iddetallefactura;";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":iddetallefactura", $iddetallefactura);
            
            if ($stmt->execute()) {
                return true;  
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Error al registrar detalle factura: " . $e->getMessage();
            return false;
        } 
    }
}
?>