<?php
include_once '../config/db.php';
include_once '../models/DetalleFactura.php';
include_once '../assets/fpdf/fpdf.php';

class DetalleFacturaController {
    private $detallefactura;

    public function __construct($db) {
        $this->detallefactura = new DetalleFactura($db);
    }

    public function listarDetalleFacturaId($idfactura) {  
        return $this->detallefactura->obtenerDetalleFacturaId($idfactura);
    }

    public function registrarDetalleFactura($idfactura, $idmenu, $cantidad, $subtotal) {
        return $this->detallefactura->insertarDetalleFactura($idfactura, $idmenu, $cantidad, $subtotal);
    }
    public function eliminarDetalleFactura($iddetallefactura){
        return $this->detallefactura->removerDetalleFactura($iddetallefactura);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

    if (isset($input['action'])) {
        $action = $input['action'];

        if ($action === 'consult') {
            if (isset($input['idfactura'])) {
                $idfactura = $input['idfactura'];
                $database = new Database();
                $db = $database->getConnection();
                $controller = new DetalleFacturaController($db);
                try {
                    $detallepedidos = $controller->listarDetalleFacturaId($idfactura);
                    $clean = 1;
                    if ($detallepedidos) {
                        echo json_encode(['data' => $detallepedidos]);
                    } else {
                        echo json_encode(['data' => $clean]);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error al obtener lista de detalle de factura: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Falta el parámetro IdFactura para consultar']);
            }
        } elseif ($action === 'insertardetalleventa') {
            if (isset($input['idfactura'], $input['idmenu'], $input['cantidad'], $input['subtotal'])) {
                $idfactura = $input['idfactura'];
                $idmenu = $input['idmenu'];
                $cantidad = $input['cantidad'];
                $subtotal = $input['subtotal'];
                $database = new Database();
                $db = $database->getConnection();
                $controller = new DetalleFacturaController($db);
                try {
                    if ($controller->registrarDetalleFactura($idfactura, $idmenu, $cantidad, $subtotal)) {
                        echo json_encode(['data' => 1]);
                    } else {
                        echo json_encode(['data' => 0]);  
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error al insertar detalle de factura: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Faltan parámetros necesarios para insertar detalle de factura']);
            }
        } elseif ($action === 'deletedf') {
            if (isset($input['iddf'])) {
                $iddetallefactura = $input['iddf'];
                $database = new Database();
                $db = $database->getConnection();
                $controller = new DetalleFacturaController($db);
                try {
                    if ($controller->eliminarDetalleFactura($iddetallefactura)) {
                        $clean = 1;
                        echo json_encode(['data' => $clean]);
                    } else {
                        $clean = 0;
                        echo json_encode(['data' => $clean]);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => 'Error al eliminar un detalle de factura: ' . $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Falta el parámetro iddf para eliminar detalle de factura']);
            }
        } else {
            echo json_encode(['error' => 'Acción no válida']);
        }
    } else {
        echo json_encode(['error' => 'No se especificó una acción en la solicitud']);
    }
} else {
    
}

?>
