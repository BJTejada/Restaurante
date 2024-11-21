<?php
include_once '../config/db.php';
include_once '../models/Cliente.php';

class ClienteController {
    private $cliente;

    // Constructor para inyectar la conexión a la base de datos
    public function __construct($db) {
        $this->cliente = new Cliente($db);
    }

    // Listar clientes
    public function listarClientes() {
        $clientes = $this->cliente->obtenerClientes();
        return $clientes;
    }

    // Registrar un cliente
    public function registrarCliente($nombres, $apellidos, $correo) {
        return $this->cliente->agregarCliente($nombres, $apellidos, $correo);
    }

    public function editarCliente($nombres,$apellidos,$correo,$id){
        return $this->cliente->actualizarCliente($nombres,$apellidos,$correo,$id);
    }
    public function eliminarCliente($id){
        return $this->cliente->removerCliente($id);
    }
}

// Verificamos si se envía una solicitud POST para registrar un cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    // Recogemos los datos del formulario
    $nombres = $_POST['nombre'];
    $apellidos = $_POST['apellido'];
    $dui = $_POST['correo'];

    // Creamos la instancia de la clase Database
    $database = new Database();  // Aquí se crea el objeto de la clase Database
    $db = $database->getConnection();  // Obtenemos la conexión

    // Creamos el controlador ClienteController con la conexión PDO
    $controller = new ClienteController($db);

    // Intentamos registrar el cliente
    if ($controller->registrarCliente($nombres, $apellidos, $dui)) {
        echo "Cliente registrado correctamente";
    } else {
        echo "Error al registrar el cliente";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $nombres = $_POST['nombreu'];
    $apellidos = $_POST['apellidou'];
    $correo = $_POST['correou'];
    $idcliente = $_POST['idclienteu']; // ID del cliente para actualizar

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear el controlador
    $clienteController = new ClienteController($db);

    // Intentar actualizar el cliente
    if ($clienteController->editarCliente($nombres, $apellidos, $correo,$id_cliente )) {
        echo "Cliente actualizado correctamente";
    } else {
        echo "Error al actualizar el cliente";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id_cliente = $_POST['id']; // ID del cliente para actualizar

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear el controlador
    $clienteController = new ClienteController($db);

    // Intentar actualizar el cliente
    if ($clienteController->eliminarCliente($id_cliente)) {
        header('Location: /restaurante/views/RegistroCliente.php');
        exit();
    } else {
        echo "Error al eliminar el cliente";
    }
}
?>


