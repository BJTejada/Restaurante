<?php
include_once '../config/db.php';
include_once '../models/Mesa.php';
include_once '../controllers/FacturaController.php';
include_once '../controllers/DetalleFacturaController.php';
class MesaController{
    private $mesa;

    public function __construct($db) {
        $this->mesa = new Mesa($db);
    }

    // Listar mesas
    public function listarMesas() {
        $mesas = $this->mesa->obtenerMesas();
        return $mesas;
    }
    
    public function editarMesa($idmesa,$estadoMesa){
        return $this->mesa->actualizarMesa($idmesa,$estadoMesa);
    }
    public function modificarMesa($idmesa,$numero,$zona,$capacidad){
        return $this->mesa->modificarMesa($idmesa,$numero,$zona,$capacidad);
    }
    public function agregarMesa($numero,$zona,$capacidad){
        return $this->mesa->crearMesa($numero,$zona,$capacidad);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $idmesa = $_POST['idmesa'];
        $estadoMesa = $_POST['estadomesa'];

        $database = new Database();
        $db = $database->getConnection();

        $mesaController = new MesaController($db);

        if ($mesaController->editarMesa($idmesa, $estadoMesa)) {
            $facturaController = new FacturasController($db);
            $estadoFactura = 'pendiente';

            if ($facturaController->registrarFacturaPendiente($idmesa, $estadoFactura)) {
                header('Location: /restaurante/views/Mesas.php');
                exit();
            } else {
                echo "Error al actualizar la mesa";
            }
        }
    } elseif(isset($_POST['action']) && $_POST['action'] === 'updatemesa'){
        $idmesa = $_POST['idmesau'];
        $numero = $_POST['numerou'];
        $zona = $_POST['zonau'];
        $capacidad = $_POST['capacidadu'];
        $database = new Database();
        $db = $database->getConnection();

        $mesaController = new MesaController($db);

        if ($mesaController->modificarMesa($idmesa,$numero,$zona,$capacidad)) {
            header('Location: /restaurante/views/RegistroMesas.php');
            exit();
        } else{
            echo json_encode('no modifico mesa');
        }
    }elseif(isset($_POST['action']) && $_POST['action'] === 'register'){
        $numero = $_POST['numero'];
        $zona = $_POST['zona'];
        $capacidad = $_POST['capacidad'];
        $database = new Database();
        $db = $database->getConnection();

        $mesaController = new MesaController($db);

        if ($mesaController->agregarMesa($numero,$zona,$capacidad)) {
            header('Location: /restaurante/views/RegistroMesas.php');
            exit();
        } else{
            echo json_encode('no modifico mesa');
        }
    }
}
else{
    
              
}
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $idmesa = $_POST['idmesa'];
    $estadoMesa = $_POST['estadomesa'];

    $database = new Database();
    $db = $database->getConnection();

    $mesaController = new MesaController($db);

    if ($mesaController->editarMesa($idmesa,$estadoMesa)) {

        $facturaController = new FacturasController($db);
        $estadoFactura = 'pendiente';

        if ($facturaController->registrarFacturaPendiente($idmesa, $estadoFactura)) {
            $ultimafactura = $facturaController->buscarUltimafactura();

            if ($ultimafactura) {
                $idfactura = $ultimafactura[0]['idfactura'];
                $detallefacturacontroller = new DetalleFacturaController($db);
                try{
                    $detallepedidos = $detallefacturacontroller->listarDetalleFacturaId($idfactura);
                    $facturaJson = json_encode($ultimafactura);
                    $detallefactura = json_encode($detallepedidos);
                    header('Location: /restaurante/views/ordenesXmesas.php?factura=' . urlencode($facturaJson) . '&detallefactura=' . urlencode($detallefacturaJson));
                    exit();  
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error al obtener lista de detalle de factura: ' . $e->getMessage()]);
                }
                
            } else {
                echo "Error al registrar la orden pendiente.";
            }
        } else {
            echo "Error al actualizar el mesa";
        }
    }
}*/

?>