<?php
    session_start();

    require_once '../bd/CAD.php';

    $error_message = '';

    if (isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $cad = new CAD();
        $user = $cad->loginUser($email, $password); 

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header('Location: ../admin/admin.php');
            } else {
                header('Location: ../index.php');
            }
            exit();
        } else {
            $error_message = "Correo o contraseña incorrectos.";
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
    <title>Login - Pastry Delights</title>
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
            <h2>Iniciar Sesión</h2>

            <?php

            if (!empty($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>

            <form action="login.php" method="POST">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Ingresar</button>
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
