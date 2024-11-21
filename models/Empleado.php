<?php
class Empleado {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerEmpleados() {
        try {
            $sql = "SELECT * FROM empleado";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los empleados: " . $e->getMessage();
            return false;
        }
    }

    public function agregarEmpleado($nombre, $apellido, $dui, $salario, $usuario, $psw,$rol) {
        try {
            $sql = "INSERT INTO empleado (nombre, apellido, dui, salario, usuario, psw,rol) 
                        VALUES (:nombre, :apellido, :dui, :salario, :usuario, :psw,:rol)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":apellido", $apellido);
            $stmt->bindParam(":dui", $dui);
            $stmt->bindParam(":salario", $salario);
            $stmt->bindParam(":usuario", $usuario);
            $stmt->bindParam(":psw", $psw);
            $stmt->bindParam(":rol", $rol);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al agregar empleado: " . $e->getMessage();
            return false;
        }
    }

    public function actualizarEmpleado($idempleado, $nombre, $apellido, $dui, $salario, $usuario, $psw,$rol) {
        try {
            $sql = "UPDATE empleado SET 
                nombre = :nombre, 
                apellido = :apellido, 
                dui = :dui, 
                salario = :salario, 
                usuario = :usuario, 
                psw = :psw, 
                rol = :rol WHERE idempleado = :idempleado";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idempleado', $idempleado);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':dui', $dui);
            $stmt->bindParam(':salario', $salario);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':psw', $psw);
            $stmt->bindParam(':rol', $rol);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar empleado: " . $e->getMessage();
            return false;
        }
    }

    public function removerEmpleado($id) {
        try {
            $sql = "DELETE FROM empleado WHERE idempleado = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar empleado: " . $e->getMessage();
            return false;
        }
    }
}
?>
