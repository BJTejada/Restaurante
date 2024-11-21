<?php
require_once "../config/db.php";
require_once "../controllers/EmpleadoController.php";

$database = new Database();
$db = $database->getConnection();
$empleadoController = new EmpleadoController($db);
$empleados = $empleadoController->listarEmpleados();
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
          echo '<li><a href ="RegistroEmpleado.php" class="active">USUARIOS</a></li>';
          echo '<li><a href ="Reportes.php" data-section="reportes" id="idpagereportes">REPORTES</a></li>';  
          echo '<li><a href ="Menu.php" data-section="menu" id="idpagemenu">PLATOS</a></li>';
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
<html lang="es">

<head>
    <title>Registro de Empleado</title>
    <link rel="stylesheet" href="../assets/css/crud.css">
</head>

<body style="background-color: #c0b9db;">
    <div class="parentc">
        <div class="divc1" >
        <?php $_SESSION['usuario'];?>
        <?php mostrarNav($rol);?>
        </div>
        <div class="divc2">
            <form id="formSEmpleado" >BUSCAR UN EMPLEADO
                <input type="text" name="sempleado" id="idsempleado" placeholder="buscar empelado">
            </form>
        <div style="max-height: 450px; overflow-y: auto;">
        <table border="1" id="IdTableEmp">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DUI</th>
                    <th>Salario</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody >
                <?php foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?php echo $empleado['idempleado']; ?></td>
                        <td><?php echo $empleado['nombre']; ?></td>
                        <td><?php echo $empleado['apellido']; ?></td>
                        <td><?php echo $empleado['dui']; ?></td>
                        <td><?php echo $empleado['salario']; ?></td>
                        <td><?php echo $empleado['usuario']; ?></td>
                        <td>
                            <button style="width: 100%; background-color: green; " onclick="showModal(<?php echo htmlspecialchars(json_encode($empleado)); ?>)">Editar</button>
                            <form action="../controllers/EmpleadoController.php" method="POST" style="display:inline; padding:0px;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="idempleado" value="<?php echo $empleado['idempleado']; ?>">
                                
                                <button class="disabled" style="width: auto; background-color: red;" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
        </div>
        <div class="divc3" style="padding-left: 20%;">
            <form action="../controllers/EmpleadoController.php" method="POST">➕EMPLEADO
                <input type="hidden" name="action" value="register">
                <label for="nombre" style="padding-top: 5px;">Nombres</label>
                <input type="text" name="nombre" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                <label for="apellido">Apellidos</label>
                <input type="text" name="apellido" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                <label for="dui">DUI</label>
                <input type="text" name="dui" oninput="ValidarDui(this)" required>
                <label for="salario">Salario</label>
                <input type="text" name="salario" oninput="VlidarNumerodecimales(this)" required>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario"  required>
                <label for="psw">Contraseña</label>
                <input type="text" name="psw"  required>
                <label for="rol">Rol</label>
                <select name="rol" id="rol">
                    <option value="1">administrador</option>
                    <option value="2">empleado</option>
                </select>
                <button type="submit">Registrar</button>
            </form>

            <div id="editarModal" class="modal-overlay">
                <div class="modal-content">
                    <button class="close-btn" onclick="hideModal()">Cerrar</button>
                    <form id="formEditarEmpleado" action="../controllers/EmpleadoController.php" method="POST">
                        <input type="hidden" name="action" value="updateempleado">
                        <input type="hidden" id="idempleadou" name="idempleadou">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombreu" name="nombreu" placeholder="Nombre" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                        <label for="apellido" >Apellido:</label>
                        <input type="text" id="apellidou" name="apellidou" placeholder="Apellido" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                        <label for="dui" >DUI:</label>
                        <input type="text" id="duiu" name="duiu" placeholder="DUI" oninput="ValidarDui(this)" required>
                        <label for="salario" >Salario:</label>
                        <input type="text" id="salariou" name="salariou" placeholder="Salario" oninput="VlidarNumerodecimales(this)" required>
                        <label for="usuario" >Usuario:</label>
                        <input type="text" id="usuariou" name="usuariou" placeholder="Usuario" required>
                        <label for="psw" >Contraseña</label>
                        <input type="password" id="pswu" name="pswu" placeholder="Contraseña" required>
                        <label for="rolu">Rol</label>
                        <select name="rolu" id="rolu">
                        </select>
                        <button type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/emp.js"></script>
</body>

</html>