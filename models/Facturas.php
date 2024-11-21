<?php

include_once '../models/DetalleFactura.php';
class Facturas{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerFacturas() {
        try {
            $sql = "SELECT f.idfactura, f.idcliente, f.idmesa, f.idempleado,m.numero, 
                        CONCAT(c.nombres, ' ', c.apellidos) AS cliente,
                        e.nombre,
                        f.estadofactura, f.fecha, f.total 
                    FROM factura f 
                    LEFT JOIN cliente c ON f.idcliente = c.idcliente
                    JOIN mesa m ON f.idmesa = m.idmesa
                    join empleado e on f.idempleado = e.idempleado
                    WHERE f.estadofactura != 'finalizada';";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Error al obtener las facturas: " . $e->getMessage();
            return false;
        }
    }
    public function agregarFacturaPendiente($idmesa,$estadofactura) {
        try {
            $sql = "INSERT INTO factura (idmesa, idempleado, fecha,estadofactura) 
                        VALUES (:idmesa,:idempleado,:fecha,:estadofactura)";
            $stmt = $this->conn->prepare($sql);
            $idempleado = 1;
            $fecha= date('Y-m-d');
            $estadofactura = 'pendiente';
            $stmt->bindParam(":idmesa", $idmesa);
            $stmt->bindParam(":idempleado", $idempleado);
            $stmt->bindParam(":fecha", $fecha);
            $stmt->bindParam(":estadofactura", $estadofactura);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al registrar el factura: " . $e->getMessage();
            return false;
        }
    }
    public function finalzarFacturaLocal($idfactura,$idcliente,$idmesa,$idempleado,$fecha,$total,$estadofactura) {
        try {
            $query = "UPDATE factura SET idcliente = :idcliente, idmesa = :idmesa, idempleado = :idempleado,
                                     fecha =:fecha, total = :total ,estadofactura = :estadofactura
                        WHERE idfactura = :idfactura;";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':idcliente',$idcliente,PDO::PARAM_INT);
            $stmt->bindParam(':idmesa',$idmesa,PDO::PARAM_INT);
            $stmt->bindParam(':idempleado',$idempleado,PDO::PARAM_INT);
            $stmt->bindParam(':fecha',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':total',$total,PDO::PARAM_STR);
            $stmt->bindParam(':estadofactura', $estadofactura, PDO::PARAM_STR);
            $stmt->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);
            
            if ($stmt->execute()){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al editar factura: " . $e->getMessage();
            return false;
        }
    }    
    public function actualizarEstadoFactura($estadofactura,$idfactura) {
        try {
            $query = "UPDATE factura SET estadofactura = :estadofactura
                        WHERE idfactura = :idfactura;";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':estadofactura', $estadofactura, PDO::PARAM_STR);
            $stmt->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);
            
            if ($stmt->execute()){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al editar factura: " . $e->getMessage();
            return false;
        }
    }
    public function actualizarFactura(){
        
    }
    public function actualizarClienteFactura($idcliente,$idfactura){
        try {
            $query = "UPDATE factura SET idcliente = :idcliente
                        WHERE idfactura = :idfactura;";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
            $stmt->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);
            
            if ($stmt->execute()){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al editar CLIENTE factura: " . $e->getMessage();
            return false;
        } 
    }
    public function obtenerUltimaFactura(){
        try {
            $sql = "SELECT * FROM factura
                        WHERE idfactura = LAST_INSERT_ID();";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la ultima factura: " . $e->getMessage());
        }
    }
    public function finalizarFactura($idfactura,$estadofactura,$total){
        try {
            $query = "UPDATE factura SET estadofactura = :estadofactura,total = :total
                        WHERE idfactura = :idfactura;";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':estadofactura', $estadofactura, PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->bindParam(':idfactura', $idfactura, PDO::PARAM_INT);
            
            if ($stmt->execute()){

                return true;
            } else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al editar CLIENTE factura: " . $e->getMessage();
            return false;
        } 
    }

    }

?>