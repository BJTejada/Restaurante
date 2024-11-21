<?php
require_once "../config/db.php";
require_once "../controllers/MesaController.php";

$database = new Database();
$db = $database->getConnection();
$controller = new MesaController($db);
$mesas = $controller->listarMesas();
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
          echo '<li><a href ="Reportes.php" data-section="reportes" id="idpagereportes">REPORTES</a></li>';  
          echo '<li><a href ="Menu.php" data-section="menu" id="idpagemenu">PLATOS</a></li>';
          echo '<li><a href ="RegistroMesas.php" data-section="mesas" id="idpagemesas" class="active">CRUD MESAS</a></li>';
        }elseif($rol == 2){
            echo '<li><a href ="Mesas.php" data-section="mesas" id="idpagelientes" >MESAS</a></li>';
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
    <div  class="parentc">
        <div class="divc1">
        <?php $_SESSION['usuario'];?>
        <?php mostrarNav($rol);?>
        </div>
        <div class="divc2">
        <form id="formSMesa" >BUSQUEDA
                <input type="text" name="smesa" id="idsmesa" placeholder="buscar mesa">
            </form>
        <div style="max-height: 450px; overflow-y: auto; min-height:450px; ">
        <table border="1" id="IdTableMesas" style="width: 100%; ">
            <thead>
                <tr>
                    <th class="disabled">IDMESA</th>
                    <th>NUMERO</th>
                    <th>ZONA</th>
                    <th>CAPACIDAD</th>
                    <th>ACCION</th>
                    <th class="disabled">ESTADO</th>
                </tr>
            </thead>
            <tbody >
                <?php foreach ($mesas as $item): ?>
                    <tr>
                        <td class="disabled"><?php echo $item['idmesa']; ?></td>
                        <td><?php echo $item['numero']; ?></td>
                        <td><?php echo $item['zona']; ?></td>
                        <td><?php echo $item['capacidad']; ?></td>
                        <td class="disabled"> <?php echo $item['estadoMesa']; ?></td>
                        <td>
                            <button style="width: 100%; background-color: green; " onclick="showModal(<?php echo htmlspecialchars(json_encode($item)); ?>)">Editar</button>
                            <form action="../controllers/MesaController.php" method="POST" style="display:inline; padding:0px;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="idmesa" value="<?php echo $item['idmesa']; ?>">
                                <button class="disabled" style="width: 100%; background-color: red;" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        </div>
        <div class="divc3">
            <h2 style="margin-left: 15%; margin-top:10%;">➕MESA</h2>
        <form style="margin-left: 15%;" action="../controllers/MesaController.php" method="POST">
        <input type="hidden" name="action" value="register">
            <label for="numero">Numero:</label>
            <input type="text" id="idnumero" name="numero" style="margin-bottom: 15px;" placeholder="Numero" oninput="VlidarNumero(this)" required>
            <label for="Zona" >Zona:</label>
            <input type="text" id="idzona" name="zona" style="margin-bottom: 15px;" placeholder="zona" required>
            <label for="capacidad" >Capacidad:</label>
            <input type="text" id="idcapacidad" name="capacidad" style="margin-bottom: 15px;" placeholder="capacidad" oninput="VlidarNumero(this)" required>
            <button type="submit">Guardar cambios</button>
        </form>
        </div>
        <div id="editarModal" class="modal-overlay">
                <div class="modal-content">
                    <button class="close-btn" onclick="hideModal()">Cerrar</button>
                    <form id="formEditarMenu" action="../controllers/MesaController.php" method="POST">
                    <input type="hidden" name="action" value="updatemesa">
                    <input type="hidden" id="idmesau" name="idmesau">
                        <h3>EDITANDO MESA</h3>
                        <label for="numerou">Numero:</label>
                        <input type="text" id="idnumerou" name="numerou" style="margin-bottom: 15px;" placeholder="Numero" oninput="VlidarNumero(this)" required>
                        <label for="zonau" >Zona:</label>
                        <input type="text" id="idzonau" name="zonau" style="margin-bottom: 15px;" placeholder="zona" required>
                        <label for="capacidadu" >Capacidad:</label>
                        <input type="text" id="idcapacidadu" name="capacidadu" style="margin-bottom: 15px;" placeholder="capacidad" oninput="VlidarNumero(this)" required>
                        <button type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>
    </div>
    <script src="../assets/js/rmesas.js"></script>
</body>
</html>