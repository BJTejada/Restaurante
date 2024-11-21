<?php
include_once '../config/db.php';
include_once '../models/Reporte.php';

class ReporteController{
    private $reporte;
    public function __construct($db) {
        $this->reporte = new Reporte($db);
    }
    public function listarReporte($BeginDate,$EndDate){
        return $this->reporte->obtenerReporte($BeginDate,$EndDate);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Rconsult') {
    $BeginDate = $_POST['begindate'];
    $EndDate = $_POST['enddate'];

    $database = new Database();  
    $db = $database->getConnection();
    $controller = new ReporteController($db);
    try {
        $reporte = $controller->listarReporte($BeginDate,$EndDate);
        if ($reporte) {
            echo json_encode(['data' => $reporte]);
        } else {
            $clean =0;
            echo json_encode(['data' => $clean]);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error al obtenerreporte: ' . $e->getMessage()]);
    }
} else{
    echo json_encode(['status' => 'error', 'message' => 'Parámetros incompletos.']);
}
?>