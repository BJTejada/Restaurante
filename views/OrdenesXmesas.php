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
    $factura = json_decode($_GET['factura'], true);  
    $detalleFactura = json_decode($_GET['detallefactura'], true);  
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
              echo '<li><a href ="Reportes.php" data-section="reportes" id="idpagereportes">REPORTES</a></li>';
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background-color: #ddd5ff">
  <div class="parentom">
    <div class="div1om">
    <?php $_SESSION['usuario'];?>
    <?php mostrarNav($rol);?>
    </div>
    <input type="hidden" id="idfacturaglobal" value="<?php echo $factura['idfactura']?>">
    <input type="hidden" id="idmesaglobal" value="<?php echo $factura['idmesa']?>">
    <div class="div2om" >
    <form action="" class="detalle-orden-form" style="margin-left: 45px; background-color: #6b5abb; padding: 10px; border-radius: 8px;color:white;">
      ✏️ EDITANDO MESA # <?php echo $factura['numero']?>...
      <div class="form-grid" style="margin-top: ;">
        <div class="form-group">
            <label for="nMesa" style="color: white;"># Mesa</label>
            <input type="text" id="nMesa" name="nMesa" class="input-text" value="<?php echo $factura['numero']?>" readonly>
        </div>
        
        <div class="form-group">
        <label for="fecha" style="color: white;">Fecha</label>
        <input type="date" id="fecha" name="fecha" class="input-date" value="<?php echo $factura['fecha']?>">
        </div>
        
        <div class="form-group">
            <label for="empleado" style="color: white;">Atiende</label>
            <input type="text" id="empleado" name="empleado" class="input-text" value="<?php echo $factura['nombre']?>" readonly>
        </div>
        
        <div class="form-group">
        <label for="cliente" style="color: white;">Cliente</label>
        <input type="hidden" name="idcliente" id="idcliente">
        <input type="text" id="cliente" name="cliente" class="input-text" value="<?php echo $factura['cliente']?>" readonly>
        </div>
        
        <div class="form-group">
        <label for="total" style="color: white;">Total</label>
        <?php if (is_array($detalleFactura) &&!empty($detalleFactura)): ?>
              <?php foreach ($detalleFactura as $pedido): ?>
                  <?php $total += $pedido['subtotal']?>
              <?php endforeach; ?>
              <?php $total = number_format($total, 2);?>
        <?php else: ?>
        <?php endif; ?>
        <input type="text" id="total" name="total" class="input-text" value="<?php echo $total?>" readonly>
            
        </div>
        <div class="form-group">
        <button class="btn" id="AddCliente" style="margin-top: 15px; padding: 5px; width:80%;">
        <?php if (!empty($factura['cliente'])): ?>
          ✏️Cambiar Cliente
        <?php else: ?>
          ➕Seleccionar Cliente
        <?php endif; ?>  
        </button>
        </div>
    </div>
    
    <div class="button-group" style="display: flex; justify-content: space-between; margin-top: 10px;">
      <div class="form-group">
        <label for="estadofactura">Estado de la factura:</label>
        <select id="estadofactura" name="estadofactura" style="font-size: large;">
          <?php if($factura['estadofactura']=='pendiente'):?>
          <option value="pendiente">pendiente</option>
          <option value="procesando">procesando</option>
          <?php endif; ?>
          <?php if($factura['estadofactura']=='procesando'):?>
          <option value="procesando">procesando</option>
          <option value="pendiente">pendiente</option>
          <?php endif; ?>
        </select>
      </div>
        <button class="btn-important"  id="btnCompletarFactura" style=" color: white; width: 50%; padding: 10px;">
          💰 COMPLETAR VENTA
        </button>
    </div>
    </form>
  </div>
  <div class="div3om" style="background-color: #6b5abb;">
    <h2 style=" text-align:center; color:white; border-collapse: ;">PEDIDOS DE LA MESA # <?php echo $factura['numero']?></h2>
    <div style="max-height: 200px; overflow-y: auto;">
      <table border="1" class="table" style="font-size: large;width:80%; margin-left:10%;">
          <thead >
            <tr >
              <th style="display: none;">DETALLE FACTURA</th>
              <th >MENU</th>
              <th>PRECIO</th>
              <th >CANTIDAD</th>
              <th >SUBTOTAL</th>
              <th>⛔</th>
            </tr>
          </thead>
          <tbody id="DetalleFacturaTBody">
          <?php if (is_array($detalleFactura) &&!empty($detalleFactura)): ?>
                <?php foreach ($detalleFactura as $pedido): ?>
                    <tr>
                        <td style="display: none;"><?php echo $pedido['iddetallefactura']; ?></td>
                        <td><?php echo $pedido['nombre']; ?></td>
                        <td><?php echo $pedido['precio']; ?></td>
                        <td><?php echo $pedido['cantidad']; ?></td>
                        <td><?php echo $pedido['subtotal']; ?></td>
                        <td><button style="background-color: red; color:white;" type="button"
                        onclick="deletedetallefactura(<?php echo htmlspecialchars(json_encode($pedido)); ?>,<?php echo htmlspecialchars(json_encode($factura)); ?>)">&times;</button></td>
                    </tr>
                <?php endforeach; ?>
          <?php else: ?>
                <tr>
                    <td colspan="7">No se encontraron pedidos.</td>
                </tr>
          <?php endif; ?>
          </tbody>
      </table>
    </div>
    </div>
  <div class="div4om " style="padding-left: 20px;">
      <h1 >AGREGAR PEDIDOS A LA MESA</h1>
      <div id="SFormMenu">
        <label for="busquedaMenu">Buscar producto</label>
        <input type="text" name="busquedaMenu" id="busquedaMenu" style="margin-bottom: 10px;">
      </div>
      <table id="idTableMenu" border="1" style="font-size:larger; ">
              <thead>
                <tr> 
                  <th style="display: none;">idmenu</th>
                  <th>NOMBRE</th>
                  <th>PRECIO</th>
                  <th>CATEGORIA</th>
                  <th>CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($menus as $menu): ?>
                    <tr>
                        <td style="display: none;"><?php echo $menu['idmenu']; ?></td>
                        <td><?php echo $menu['nombre']; ?></td>
                        <td><?php echo $menu['precio']; ?></td>
                        <td><?php echo $menu['categoria']; ?></td>
                        <td >
                          <form class="formNDF">
                              <input type="text" style="width: 80px;" name="cantidadNPedido">
                              <input type="hidden" style="width: 80px;" name="Menu" value="<?php echo htmlspecialchars(json_encode($menu)); ?>">
                              <input type="hidden" style="width: 80px;" name="Factura" value="<?php echo htmlspecialchars(json_encode($factura)); ?>">
                              <button style="font-size:16px;" type="submit">
                                  Agregar
                              </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>        
              </tbody>
        </table>
    </div>
    </div>
    <!-- Tabla dentro del modal para pedidos-->
    <div class="modal" id="myModalCliente" style="display:none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div style="text-align: right;">
                <button type="button" class="close" id="closeModalBtnCliente">&times;</button>
              </div>
              <div style="text-align: center; margin-bottom:0px">
                <h3 class="modal-title">CLIENTES</h3>
              </div>
            </div>
          <div class="modal-content" >
          <div id="SFormCliente">
            <label for="busquedaCliente">Buscar cliente</label>
            <input type="text" name="busquedaCliente" id="busquedaCliente" style="margin-bottom: 10px;">
          </div>
          <div style="max-height: 300px; overflow-y: auto;">
            <table border="1" id="idTableCliente" style="font-size:larger;">
              <thead>
                <tr> 
            <?php
              if (!empty($clientes)) {
                foreach (array_keys($clientes[0]) as $columna) {
                    echo "<th>" . htmlspecialchars($columna) . "</th>";
                }
              }
            ?> 
                </tr>
              </thead>
              <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td style="display: none;"><?php echo $cliente['idcliente']; ?></td>
                        <td><?php echo $cliente['nombres']; ?></td>
                        <td><?php echo $cliente['apellidos']; ?></td>
                        <td><?php echo $cliente['correo']; ?></td>
                        <td style="text-align: center;">
                          <button style="font-size:16px;" onclick="asignarCliente(<?php echo htmlspecialchars(json_encode($cliente));?>,<?php echo htmlspecialchars(json_encode($factura));?>)">
                              Seleccionar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>        
              </tbody>
            </table>
            </div>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <button type="button" class="btn btn-secondary" id="closeModalCliente">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/om.js"></script>
</body>
</html>