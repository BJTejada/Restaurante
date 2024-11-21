<?php 
require_once "../config/db.php";
require_once "../controllers/MesaController.php";
require_once "../controllers/FacturaController.php";
$database = new Database();
$db = $database->getConnection();
    $mesaController = new MesaController($db);
    $mesas = $mesaController->listarMesas();
    $facturaController = new FacturasController($db);
    $facturas = $facturaController->listarFacturas();

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
              echo '<li><a href ="Mesas.php" data-section="mesas" id="idpagelientes" class="active">MESAS</a></li>';
              echo '<li><a href ="RegistroCliente.php" data-section="clientes" id="idpageclientes">CLIENTES</a></li>';
              echo '<li><a href ="RegistroEmpleado.php">USUARIOS</a></li>';
              echo '<li><a href ="Reportes.php" data-section="reportes" id="idpagereportes">REPORTES</a></li>';
              echo '<li><a href ="Menu.php" data-section="menu" id="idpagemenu">PLATOS</a></li>';  
              echo '<li><a href ="RegistroMesas.php" data-section="mesas" id="idpagemesas">CRUD MESAS</a></li>';
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background-color: #c0b9db">
    <?php $_SESSION['usuario'];?>
    <?php mostrarNav($rol);?>

<div class="cards-container">
<?php foreach ($mesas as $mesa): ?>
    <div class="card">
        <div class="card-header">
            <div class="<?php echo ($mesa['estadoMesa'] == 'disponible') ? 'disponible' : 'no-disponible'; ?>">
                <span class="card-title"># MESA <?php echo $mesa['numero']; ?></span>
            </div>
        </div>
        <div class="card-body">
            <div class="card-row">
                <strong>ZONA: </strong><?php echo $mesa['zona']; ?>
            </div>
            <div class="card-row">
                <strong>CAPACIDAD: </strong><?php echo $mesa['capacidad']; ?>
            </div>
            <div class="card-row">
                <strong>MESA: </strong><?php echo $mesa['estadoMesa']; ?>
            </div>
            <div class="card-row">
                <?php if ($mesa['estadoMesa'] == 'disponible'): ?>
                    <form action="../controllers/MesaController.php" method="POST">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="empleado" value="<?php echo $_SESSION['usuario'];?>">
                        <input type="hidden" name="idempleado" value="<?php echo $_SESSION['idempleado'];?>">
                        <input type="hidden" name="idmesa" value="<?php echo $mesa['idmesa'] ?>">
                        <input type="hidden" name="estadomesa" value="ocupado">
                        <button class="btnSelected" style="font-size:16px;">
                            ASIGNAR MESA
                        </button>
                    </form>
                <?php else: ?>
                    <?php foreach ($facturas as $factura): ?>
                        <?php if($mesa['idmesa'] == $factura['idmesa']): ?>
                            <div class="card-row">
                            <strong style="
                                background-color: <?php echo ($factura['estadofactura'] === 'pendiente') ? 'orange' : 'blue'; ?>;
                                color: <?php echo ($factura['estadofactura'] === 'pendiente') ? 'black' : 'white'; ?>;">
                                ORDEN: <?php echo $factura['estadofactura']; ?>
                            </strong>
                            </div>
                            <button class="btnSelected" onclick = "editFactura(<?php echo htmlspecialchars(json_encode($factura)); ?>)">
                                EDITAR
                            </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

</div>


            <script src="../assets/js/script.js"></script>
    
</body>
</html>