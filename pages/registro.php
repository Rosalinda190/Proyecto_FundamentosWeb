<?php
    session_start();
    require_once '../bd/CAD.php';
    $error_message = '';
    $success_message = '';

    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $cad = new CAD();
        $result = $cad->registerUser($nombre, $hashedPassword, $email);
        
        if ($result) {
            header('Location: login.php?registered=true');
            exit();
        } else {
            $error_message = "Hubo un error al registrar tu cuenta. El correo ya está en uso o hubo un problema inesperado.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/login.css" rel="stylesheet" type="text/css">
    <script src="../script.js"></script>
    <title>Registro - Pastry Delights</title>
</head>
<body>
    <div class="Contenedor">
        
        <div class="Encabezado">
            <div class="titulo">Pastry Delights</div>
            <div class="registro1">
                <a href="registro.php"><button class="registrarse">Sign Up</button></a>
                <a href="login.php"><button class="entrar">Log In</button></a>
            </div>            
        </div>
        
        <div class="menu-contenedor">
            <div class="menu">
                <a href="../index.php">Home</a>
                <a href="recetas.php">Recetas</a>
                <a href="blogs.php">Blog Post</a>
            </div>
        </div>

        <div class="Formulario">
            <h2>Crear Cuenta</h2>

            <?php

            if (isset($success_message)) {
                echo "<p class='success-message'>$success_message</p>";
            }
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
            <form action="registro.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            
                <button type="submit">Registrarse</button>
            </form>
            
        </div>

        <div class="Pie">
            <div class="SubP">Busca nuestras redes sociales para más ideas</div>
            <div class="logos">
                <a href="https://www.facebook.com" target="_blank"><img src="../img/f.jpg" alt="Facebook"></a>
                <a href="https://www.instagram.com" target="_blank"><img src="../img/i.jpg" alt="Instagram"></a>
                <a href="https://www.twitter.com" target="_blank"><img src="../img/t.jpg" alt="Twitter"></a>
            </div>
        </div>
    </div>
</body>
</html>
