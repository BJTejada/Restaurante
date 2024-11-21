<?php
include_once '../config/db.php';
include_once '../models/Facturas.php';
include_once '../controllers/MesaController.php';

class FacturasController{
    private $factura;

    public function __construct($db) {
        $this->factura = new Facturas($db);
    }

    public function listarFacturas(){
        $facturas = $this->factura->obtenerFacturas();
        return $facturas;
    }
    public function registrarFacturaPendiente($idmesa,$estadoFactura){
        return $this->factura->agregarFacturaPendiente($idmesa,$estadoFactura);
    }
    public function editarFactura($idcliente,$idmesa,$idempleado,$fecha,$total,$estadoFactura){
        return $this->factura->actualizarFactura($idcliente,$idmesa,$idempleado,$fecha,$total,$estadoFactura);
    }
    public function editarClienteFactura($idcliente,$idfactura){
        return $this->factura->actualizarClienteFactura($idcliente,$idfactura);
    }
    public function editarEstadoFactura($estadofactura,$idfactura){
        return $this->factura->actualizarEstadoFactura($estadofactura,$idfactura);
    }
    public function buscarUltimafactura(){
        return $this->factura->obtenerUltimaFactura();
    }
    public function completarFactura($idfactura,$estadofactura,$total){
        return $this->factura->finalizarFactura($idfactura,$estadofactura,$total);
    }
}
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lee el cuerpo de la solicitud JSON
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Verifica que la acción esté definida
    if (isset($inputData['action'])) {
        $action = $inputData['action'];

        if ($action === 'register') {
            $idmesa = $inputData['idmesa'];
            $estadoOrden = $inputData['estadofactura'];
            $database = new Database();
            $db = $database->getConnection();

            $controller = new FacturasController($db);
            try {
                if ($controller->registrarFacturaPendiente($idmesa, $estadoOrden)) {
                    echo json_encode(['data' => 1]);
                } else {
                    echo json_encode(['data' => 0]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al registrar factura pendiente: ' . $e->getMessage()]);
            }
        } elseif ($action === 'updateclientefactura') {
            $idcliente = $inputData['idcliente']; 
            $idfactura = $inputData['idfactura']; 
            $database = new Database();
            $db = $database->getConnection();
            $controller = new FacturasController($db);
            try {
                if ($controller->editarClienteFactura($idcliente, $idfactura)) {
                    echo json_encode(['data' => 1]);
                } else {
                    echo json_encode(['data' => 0]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al cambiar cliente a factura: ' . $e->getMessage()]);
            }
        } elseif ($action === 'updateestadofactura') {
            $estadofactura = $inputData['estadofactura'];
            $idfactura = $inputData['idfactura'];
            $database = new Database();
            $db = $database->getConnection();
            $controller = new FacturasController($db);
            try {
                if ($controller->editarEstadoFactura($estadofactura, $idfactura)) {
                    $clean =1;
                    echo json_encode(['data' => $clean]);
                } else {
                    $clean =0;
                    echo json_encode(['data' => $clean]);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => 'Error al cambiar estado de factura: ' . $e->getMessage()]);
            }
            } elseif ($action === 'completeventa') {
                $estadofactura = 'finalizada';
                $idfactura = $inputData['idfactura'];
                $total = $inputData['total'];
                $idmesa = $inputData['idmesa'];
                $estadomesa = 'disponible';

                $database = new Database();
                $db = $database->getConnection();
                $controller = new FacturasController($db);
                try {
                    if ($controller->completarFactura($idfactura, $estadofactura, $total)) {
                        $mesaController = new MesaController($db);
                        header("Location: factura.php?idfactura=" . $idfactura);
                        if ($mesaController->editarMesa($idmesa, $estadomesa)) {
                            echo json_encode(['data' => 1, 'message' => 'Factura completada y mesa actualizada.']);
                        } else {
                            echo json_encode(['data' => 0, 'error' => 'No se pudo actualizar la mesa.']);
                        }
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error al completar la venta: ' . $e->getMessage()]);
                }
        } else {
            echo json_encode(['error' => 'Acción no válida']);
        }
    } else {
        echo json_encode(['error' => 'No se especificó una acción en la solicitud POST']);
    }
} else {
    
}

?>