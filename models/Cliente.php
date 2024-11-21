<?php
class Cliente {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para obtener todos los clientes
    public function obtenerClientes() {
        try {
            $sql = "SELECT * FROM cliente";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve los resultados como un array asociativo
        } catch (PDOException $e) {
            // Manejo de errores en caso de fallo de la consulta
            echo "Error al obtener los clientes: " . $e->getMessage();
            return false;
        }
    }

    // Método para agregar un cliente
    public function agregarCliente($nombres, $apellidos, $correo) {
        try {
            $sql = "INSERT INTO cliente (nombres, apellidos, correo) VALUES (:nombres, :apellidos, :correo)";
            $stmt = $this->conn->prepare($sql);

            // Vincula los parámetros
            $stmt->bindParam(":nombres", $nombres);
            $stmt->bindParam(":apellidos", $apellidos);
            $stmt->bindParam(":correo", $correo);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                return true;  // Si la inserción es exitosa
            } else {
                return false; // Si algo falló
            }
        } catch (PDOException $e) {
            // Si ocurre un error al ejecutar la consulta
            echo "Error al registrar el cliente: " . $e->getMessage();
            return false;
        }
    }
    public function actualizarCliente($nombres, $apellidos, $correo, $idcliente) {
        try {
            $query = "UPDATE cliente SET nombres = :nombres, apellidos = :apellidos, correo = :correo WHERE idcliente = :idcliente;";
            $stmt = $this->conn->prepare($query);
    
            // Bind de cada parámetro con el tipo de dato correspondiente
            $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
            
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
    public function removerCliente($id){
        try{
            $sql = "DELETE FROM cliente WHERE idcliente = :id;";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id',$id,PDO::PARAM_INT);

            if($stmt->execute()){
                return true;
            } else{
                return false;
            }

        } catch (PDOException $e) {
            // Si ocurre un error al ejecutar la consulta
            echo "Error al remover cliente: " . $e->getMessage();
            return false;
        }
    }
    
}
?>


