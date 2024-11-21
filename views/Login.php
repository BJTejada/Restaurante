<?php


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once '../config/db.php';
    $database = new Database();
    $db = $database->getConnection();

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['psw'];

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM empleado WHERE usuario = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();

    if ($user && password_verify($contrasena, $user['psw'])) {
        // Si las credenciales son correctas, establecer la sesión
        $_SESSION['idempleado'] = $user['idempleado'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];

        header("Location: Mesas.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .hidden {
            display: none;
        }
        .warning {
            color: rgb(255, 255, 255);
            font-weight: bold;
        }
    </style>
</head>
<body style="background-color: #c0b9db">
    <div class="parentL">
        <div class="divL1" style="text-align: center;">
        <h1>RESTAURANTE</h1>
        </div>
        <div class="divL2">

        </div>
        <div class="divL3">
        <div class="login-container">
            
            <h1>Iniciar Sesión</h1>
            <form action="" method="POST" >
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" id="idpsw" name="psw" placeholder="Contraseña" required>
                <p id="caps-warning" class="hidden">⚠️ El bloqueo de mayúsculas está activado</p>
                <button type="submit">Ingresar</button>
            </form>
            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
                }
            ?>
            </div>
        </div>
        <div class="divL4">

        </div>
    </div>
    <script src="../assets/js/script.js"></script>
    <script>
        const passwordInput = document.getElementById("idpsw");
        const capsWarning = document.getElementById("caps-warning");

        passwordInput.addEventListener("keyup", function(event) {
            if (event.getModifierState("CapsLock")) {
                capsWarning.classList.remove("hidden");
                capsWarning.classList.add("warning");
            } else {
                capsWarning.classList.add("hidden");
                capsWarning.classList.remove("warning");
            }
        });
    </script>
</body>
</body>
</html>