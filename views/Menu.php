<?php
require_once "../config/db.php";
require_once "../controllers/MenuController.php";

$database = new Database();
$db = $database->getConnection();
$controller = new MenuController($db);
$menu = $controller->listarMenuCRUD();
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
          echo '<li><a href ="Menu.php" data-section="menu" id="idpagemenu" class="active">PLATOS</a></li>';
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
        <form id="formSMenu" >BUSQUEDA
                <input type="text" name="smenu" id="idsmenu" placeholder="buscar plato">
            </form>
        <div style="max-height: 450px; overflow-y: auto;">
        <table border="1" id="IdTableMenu" style="width: 100%;">
            <thead>
                <tr>
                    <th class="disabled">IDCATEGORIA</th>
                    <th class="disabled">IDMENU</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>PRECIO</th>
                    <th>CATEGORIA</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody >
                <?php foreach ($menu as $item): ?>
                    <tr>
                        <td class="disabled"><?php echo $item['idcategoria']; ?></td>
                        <td class="disabled"><?php echo $item['idmenu']; ?></td>
                        <td><?php echo $item['nombre']; ?></td>
                        <td><?php echo $item['descripcion']; ?></td>
                        <td><?php echo $item['precio']; ?></td>
                        <td><?php echo $item['categoria']; ?></td>
                        <td>
                            <button style="width: 100%; background-color: green; " onclick="showModal(<?php echo htmlspecialchars(json_encode($item)); ?>)">Editar</button>
                            <form action="../controllers/EmpleadoController.php" method="POST" style="display:inline; padding:0px;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="idempleado" value="<?php echo $item['idmenu']; ?>">
                                
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
            <h2 style="margin-left: 15%; margin-top:10%;">➕MENU</h2>
        <form style="margin-left: 15%;" action="../controllers/MenuController.php" method="POST">
        <input type="hidden" name="action" value="register">
            <label for="nombre">Nombre:</label>
            <input type="text" id="idnombre" name="nombre" style="margin-bottom: 15px;" placeholder="Nombre" required>
            <label for="descripción" >Descripción:</label>
            <input type="text" id="iddescripcion" name="descripcion" style="margin-bottom: 15px;" placeholder="Descripción" required>
            <label for="precioud" >Precio:</label>
            <input type="text" id="idprecio" name="precio" style="margin-bottom: 15px;" placeholder="$00.00" oninput="VlidarNumerodecimales(this)" required>
            <label for="categoria">Categoria</label>
            <select name="categoria" id="idcategoria">
                <option value="1">bebida</option>
                <option value="2">plato</option>
                <option value="3">entrada</option>
            </select>
            <button type="submit">Guardar cambios</button>
        </form>
        </div>
        <div id="editarModal" class="modal-overlay">
                <div class="modal-content">
                    <button class="close-btn" onclick="hideModal()">Cerrar</button>
                    <form id="formEditarMenu" action="../controllers/MenuController.php" method="POST">
                        <h3>EDITANDO PRODUCTO</h3>
                        <input type="hidden" name="action" value="updatemenu">
                        <input type="hidden" id="idmenuu" name="idmenuu">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="idnombreu" name="nombreu" placeholder="Nombre" style="margin-bottom: 20px;" required>
                        <label for="descripción" >Descripción:</label>
                        <input type="text" id="iddescripcionu" name="descripcionu" style="margin-bottom: 20px;" placeholder="Descripción" required>
                        <label for="precioud" >Precio:</label>
                        <input type="text" id="idpreciou" name="preciou" style="margin-bottom: 20px;" placeholder="$00.00" oninput="VlidarNumerodecimales(this)" required>
                        <label for="categoria">Categoria</label>
                        <select name="categoriau" id="idcategoriau" style="margin-bottom: 20px;">
                        </select>
                        <button type="submit">Guardar cambios</button>
                    </form>
                </div>
            </div>
    </div>
    <script src="../assets/js/menu.js"></script>
</body>
</html>