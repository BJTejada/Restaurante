<?php 
require_once "../config/db.php";
require_once "../controllers/MenuController.php";
require_once "../controllers/ClienteController.php";
$database = new Database();
$db = $database->getConnection();
$menuController = new MenuController($db);
$menus = $menuController->listarMenu();
$clienteController = new ClienteController($db);
$clientes = $clienteController->listarClientes($db);
    $total = 0;
    session_start();

    if (!isset($_SESSION['idempleado'])) {
        header("Location: login.php");
        exit();
    }
    $rol = $_SESSION['rol'];
    function mostrarNav($rol){
        echo '<div class="navbar">';
          echo '<ul>';  
            if($rol == 1){
              echo '<li><a href ="Mesas.php" data-section="mesas" id="idpagelientes" >MESAS</a></li>';
              echo '<li><a href ="RegistroCliente.php" data-section="clientes" id="idpageclientes">CLIENTES</a></li>';
              echo '<li><a href ="RegistroEmpleado.php">USUARIOS</a></li>';
              echo '<li><a href ="Reportes.php" data-section="reportes" id="idpagereportes" class="active">REPORTES</a></li>';  
              echo '<li><a href ="Menu.php" data-section="menu" id="idpagemenu">PLATOS</a></li>';
            }elseif($rol == 2){
                echo '<li><a href ="Mesas.php" data-section="mesas" id="idpagelientes" class="active">MESAS</a></li>';
                echo '<li><a href ="RegistroCliente.php" data-section="clientes" id="idpageclientes">CLIENTES</a></li>';
            }

            echo ('<li style="float:right; align-text:center; padding-top:10px;">');
            echo ('<button class="buttonLO"> <a href="logout.php" style=padding:0px;>Cerrar Sesión</a></button>');
            echo('</li>');
            echo ('<li style="float:right; align-text:center;  padding-right: 10px; padding-top: 5px;">');
            echo('<p style="color:white;">'); echo $_SESSION['usuario']; echo('</p>');
            echo('</li>');
          echo '</ul>';  
        echo '</div>';
      
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/crud.css">
</head>
<body style="background-color: #c0b9db;">
<div class="parentR">
    <div class="div1R">
    <?php $_SESSION['usuario'];?>
    <?php mostrarNav($rol);?>
    </div>
    <div class="div2R" style="margin-left: 15px;">
    <h2>MODIFICACION DE FECHAS</h2>
        <form id="ReporteForm" style="display: flex; flex-direction: column; align-items: center;">
            <input type="hidden" name="action" value="Rconsult">
            <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px;">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <label for="fecha_inicio" style="color: white; font-size: 20px;">FECHA DE INICIO:</label>
                    <input type="date" id="idbegindate" name="begindate"  style="margin-top: 5px;">
                </div>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <label for="fecha_fin" style="color: white; font-size: 20px;">FECHA DE FIN:</label>
                    <input type="date" id="idenddate" name="enddate" style="margin-top: 5px;">
                </div>
            </div>
            <button type="button" id="BtnEnviarReporte" class="buttonbs" style="margin-top: 10px;">Generar Reporte</button>
            <P></P>
            <button type="button" id="BtnDescargar" onclick="GenerarReporte(this)" style="height: 40px; background-color: #0caa3b; color: rgb(255, 255, 255); border: none; cursor: pointer; padding: 0 20px;">
                DESCARAR REPORTE
            </button>
        </form>
    </div>
    <div class="div3R">
        <table class="mi-tabla" 
            style=" width: 90%; margin-top: 15px;  margin-left: 25px; border-collapse:0;" id="ReportTable" >
                <thead>
                    <tr>
                        <th style=" text-align: center;">
                            FACTURA
                        </th>
                        <th style=" text-align: center;">
                            FECHA
                        </th>
                        <th style=" text-align: center;">
                            TOTAL    
                        </th>
                        <th style=" text-align: center;">
                            CLIENTE    
                        </th>
                        <th style=" text-align: center;">
                            EMPLEADO    
                        </th>
                    </tr>
                </thead>
                <tbody id="ReportTBody">
                        <tr style="cursor: pointer;">
                            <td style="color:white;">
                            </td>
                        </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                        <td id="idTotalGeneral"></td>
                    </tr>
                </tfoot>
        </table>
    </div>
</div>
<script src="../assets/js/rep.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

</body>
</html>