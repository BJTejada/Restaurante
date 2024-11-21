<?php 
require_once "../config/db.php";
require_once "../controllers/ClienteController.php";
$database = new Database();
$db = $database->getConnection();
    $clienteController = new ClienteController($db);
    $clientes = $clienteController->listarClientes();
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
              echo '<li><a href ="RegistroCliente.php" data-section="clientes" id="idpageclientes" class="active">CLIENTES</a></li>';
              echo '<li><a href ="RegistroEmpleado.php">USUARIOS</a></li>';
              echo '<li><a href ="Reportes.php" data-section="reportes" id="idpagereportes">REPORTES</a></li>';  
              echo '<li><a href ="Menu.php" data-section="menu" id="idpagemenu">PLATOS</a></li>';
              echo '<li><a href ="RegistroMesas.php" data-section="mesas" id="idpagemesas">CRUD MESAS</a></li>';
            }elseif($rol == 2){
                echo '<li><a href ="Mesas.php" data-section="mesas" id="idpagelientes">MESAS</a></li>';
                echo '<li><a href ="RegistroCliente.php" data-section="clientes" id="idpageclientes" class="active">CLIENTES</a></li>';
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
    <div class="parentc">
        <div class="divc1">
        <?php $_SESSION['usuario'];?>
        <?php mostrarNav($rol);?>
        </div>
        <div class="divc2" >
            <form id="formSCliente" >BUSCAR UN CLIENTE
                <input type="text" name="scliente" id="idscliente" placeholder="buscar cliente">
            </form>
            <div style="min-height:450px; max-height: 450px; overflow-y: auto;">
                <table border="1" id="IdTableClient" style="width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>DUI</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['idcliente']; ?></td>
                            <td><?php echo $cliente['nombres']; ?></td>
                            <td><?php echo $cliente['apellidos']; ?></td>
                            <td><?php echo $cliente['correo']; ?></td>
                            <td>
                                <button style="width: 100%; background-color: green;" onclick="editarCliente(<?php echo htmlspecialchars(json_encode($cliente)); ?>)">Editar</button>
                                <form id="formEliminarCliente" action="../controllers/ClienteController.php" method="POST" style="margin: 0; padding: 0;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $cliente['idcliente']; ?>">
                                <button class="disabled" type="submit" style="width: auto; background-color: red;">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>
        </div>
        <div class="divc3" style="padding-left: 20%; padding-top:10%;">
        <form action="../controllers/ClienteController.php" method="POST" >➕ CLIENTE
                <input type="hidden" name="action" value="register">
                <label for="nombre" style="padding-top: 5px;">Nombres</label>
                <input type="text" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                <label for="apellido">Apellidos</label>
                <input type="text" name="apellido" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                <label for="correo">Correo</label>
                <input type="text" name="correo" onblur="ValidarCorreo(this)"  required>
                <button type="submit">Registrar</button>
            </form>
        </div>
        <div id="editarModal" class="modal-overlay">
                <div class="modal-content">
                    <button class="close-btn" onclick="hideModal()">Cerrar</button>
                    <form id="formEditarEmpleado" action="../controllers/EmpleadoController.php" method="POST">
                        <input type="hidden" name="action" value="updatecliente">
                        <input type="hidden" id="idclienteu" name="idclienteu">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombreu" name="nombreu" placeholder="Nombre" required>
                        <label for="apellido" >Apellido:</label>
                        <input type="text" id="apellidou" name="apellidou" placeholder="Apellido" required>
                        <label for="correo" >Correo:</label>
                        <input type="text" id="correou" placeholder="Correo">
                        <button type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>
    </div>
    <script src="../assets/js/cl.js"></script>
</body>
</html>