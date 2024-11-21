<?php
include_once '../config/db.php';
include_once '../models/DetalleFactura.php';
include_once '../models/Facturas.php';
include_once '../assets/fpdf/fpdf.php';


if (isset($_GET['idfactura'])) {
    $idfactura = $_GET['idfactura'];
    $database = new Database();
    $conn = $database->getConnection();

    $sql_factura = "SELECT f.idfactura,CONCAT(c.nombres, ' ',c.apellidos) as cliente,m.numero,f.fecha,f.total 
	                    from factura f join cliente c on f.idcliente = c.idcliente
                            join mesa m on f.idmesa = m.idmesa where f.idfactura = :idfactura";
    $stmt = $conn->prepare($sql_factura);
    $stmt->bindParam(':idfactura', $idfactura);
    $stmt->execute();
    $factura = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$factura) {
        die('Factura no encontrada.');
    }

    // Obtener detalles de la factura
    /*select m.nombre,df.cantidad,m.precio,df.subtotal 
	from detallefactura df 
	join menu m on df.idmenu=m.idmenu where idfactura =18;
    SELECT * FROM detallefactura WHERE idfactura = :idfactura*/
    $sql_detalle = "SELECT m.nombre,df.cantidad,m.precio,df.subtotal
                    FROM detallefactura df JOIN menu m on df.idmenu=m.idmenu
                    WHERE idfactura = :idfactura";
    $stmt_detalle = $conn->prepare($sql_detalle);
    $stmt_detalle->bindParam(':idfactura', $idfactura);
    $stmt_detalle->execute();
    $detalles = $stmt_detalle->fetchAll(PDO::FETCH_ASSOC);

    // Clase PDF personalizada
    class PDF extends FPDF {
        function Header() {
            // Cabecera del documento
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(190, 10, 'RESTAURANTE', 0, 1, 'C');
            $this->Ln(10);
        }

        function Footer() {
            // Pie de página
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    // Crear el PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // Información de la factura
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Cliente: ' . $factura['cliente'], 0, 1);
    $pdf->Cell(0, 10, 'Fecha: ' . $factura['fecha'], 0, 1);
    $pdf->Ln(10);

    // Detalles de la factura
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio Unitario', 1);
    $pdf->Cell(40, 10, 'Total', 1);
    $pdf->Ln();

    // Iterar sobre los detalles de la factura
    $pdf->SetFont('Arial', '', 12);
    foreach ($detalles as $detalle) {
        $pdf->Cell(80, 10, $detalle['nombre'], 1);
        $pdf->Cell(30, 10, $detalle['cantidad'], 1);
        $pdf->Cell(40, 10, '$' . number_format($detalle['precio'], 2), 1);
        $pdf->Cell(40, 10, '$' . number_format($detalle['subtotal'], 2), 1);
        $pdf->Ln();
    }

    // Total de la factura
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total General', 1);
    $pdf->Cell(40, 10, '$' . number_format($factura['total'], 2), 1);

    // Salida del PDF
    $pdf->Output('factura.pdf', 'D');
}
?>



