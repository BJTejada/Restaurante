<?php
include_once '../config/db.php';
include_once '../models/Empleado.php';

class EmpleadoController{
    private $empleado;
    public function __construct($db) {
        $this->empleado = new Empleado($db);
    }
    public function listarEmpleados(){
        $empleados = $this->empleado->obtenerEmpleados();
        return $empleados;
    }
    public function registrarEmpleado($nombre,$apellido,$dui,$salario,$usuario,$psw,$rol){
        return $this->empleado->agregarEmpleado($nombre,$apellido,$dui,$salario,$usuario,$psw,$rol);
    }
    public function editarEmpleado($idempleado,$nombre,$apellido,$dui,$salario,$usuario,$psw,$rol){
        return $this->empleado->actualizarEmpleado($idempleado,$nombre,$apellido,$dui,$salario,$usuario,$psw,$rol);
    }
    public function eliminarEmpleado($idempleado){
        return $this->empleado->removerEmpleado($idempleado);
    }    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se recibió la acción
    if (isset($_POST['action']) && $_POST['action'] === 'updateempleado') {
        // Accede a los valores del formulario
        $idempleado = $_POST['idempleadou'];
        $nombre = $_POST['nombreu'];
        $apellido = $_POST['apellidou'];
        $dui = $_POST['duiu'];
        $salario = $_POST['salariou'];
        $usuario = $_POST['usuariou'];
        $psw = $_POST['pswu'];
        $rol = $_POST['rolu']; 

        $database = new Database();  // Crea la instancia de la clase Database
        $db = $database->getConnection();
        $controller = new EmpleadoController($db);

        // Llamada al método para actualizar el empleado
        if ($controller->editarEmpleado($idempleado, $nombre, $apellido, $dui, $salario, $usuario, $psw, $rol)) {
            // Redirigir a la página de registro de empleados si se actualizó correctamente
            header('Location: /restaurante/views/RegistroEmpleado.php');
            exit();
        } else {
            // En caso de error, mostrar mensaje
            echo json_encode(['error' => 'No se pudo actualizar el empleado']);
        }
    } elseif(isset($_POST['action']) && $_POST['action'] === 'register'){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dui = $_POST['dui'];
        $salario = $_POST['salario'];
        $usuario = $_POST['usuario'];
        $psw = $_POST['psw'];
        $rol = $_POST['rol']; 
        $HPsw = password_hash($psw, PASSWORD_DEFAULT);
        $database = new Database();  // Crea la instancia de la clase Database
        $db = $database->getConnection();
        $controller = new EmpleadoController($db);

        // Llamada al método para actualizar el empleado
        if ($controller->registrarEmpleado( $nombre, $apellido, $dui, $salario, $usuario, $HPsw, $rol)) {
            // Redirigir a la página de registro de empleados si se actualizó correctamente
            header('Location: /restaurante/views/RegistroEmpleado.php');
            exit();
        } else {
            // En caso de error, mostrar mensaje
            echo json_encode(['error' => 'No se pudo actualizar el empleado']);
        }
    }
}
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    header('Content-Type: application/json');
    
    if(isset($input['action'])){
        $action = $input['action'];
        if($action ==='updateempleado'){
            $idempleado = $input['idempleadou'];
            $nombre = $input['nombreu'];
            $apellido = $input['apellidou'];
            $dui = $input['duiu'];
            $salario = $input['salariou'];
            $usuario = $input['usuariou'];
            $psw = $input['pswu'];
            $r = $input['rolu'];
            if($r==='admnistrador'){
                $rol = 1;
            }elseif($r ==='empleado'){
                $rol = 2;
            }
            $database = new Database();  // Aquí se crea el objeto de la clase Database
            $db = $database->getConnection();
            $controller = new EmpleadoController($db);
            if($controller->editarEmpleado($idempleado,$nombre,$apellido,$dui,$salario,$usuario,$psw,$rol)){
                header('Location: /restaurante/views/RegistroEmpleado.php');
                exit(); 
            }else{
                echo json_encode('no se pudo acutlizar empelado');
            }
        }
    }  else{
        echo json_encode($input);
    } 
}*/

?>