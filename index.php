<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['role'] = 'guest'; 
    }

    include_once("bd/conexion.php");
    include_once("bd/CAD.php");

    $conexion = new Conexion();
    $conexion = $conexion->conectar();
    $cad = new CAD();

    $user = null;
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $user = $cad->getUser($_SESSION['user_id']);
    }

?>

<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/index.css" rel="stylesheet" type="text/css">
    <script src="script.js"></script>
    <title>Pastry Delights</title>
</head>

<body>
    <div class="Contenedor"> 
        <div class="Encabezado">
            <div class="titulo">Pastry Delights</div>
            <div class="registro1">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="bd/logout.php"><button class="logout">Logout</button></a>
                <?php else: ?>
                    <a href="pages/registro.php"><button class="registrarse">Sign Up</button></a>
                    <a href="pages/login.php"><button class="entrar">Log In</button></a>
                <?php endif; ?>
            </div>            
        </div>

         <div class="menu-contenedor">
            <div class="menu">
                <a href="index.php">Home</a>
                <a href="pages/recetas.php">Recetas</a>
                <a href="pages/blogs.php">Blog Post</a>
            </div>
        </div>

        <div class="Descubre">
            <div class="capa-transparente"></div>
            <div class="SubD">DESCUBRE EL ARTE DE CREAR RECETAS DELICIOSAS</div>
            <<a href="pages/recetas.php" class="seccionD">Conoce nuestras recetas, da click aquí...</a>
        </div>

        <div class="Registro">
            <div class="SubR">Regístrate aquí para formar parte de nuestra comunidad repostera</div>
            <div class="seccionR">
                <input type="email" class="correo" placeholder="Escribe tu correo electrónico aquí">
                <a href="pages/registro.php"><button class="registrarse">Sign Up</button></a>
            </div>
        </div>

        <div class="Temporada">
            <div class="SubT">Recetas de Temporada</div>
            <div class="seccionesT">
                <a href="churros.html" class="C1"></a>
                <a href="piedelimon.html" class="C2"></a>
                <a href="cupcakedefresa.html" class="C3"></a>
            </div>
        </div>

        <div class="Pie">
            <div class="SubP">Busca nuestras redes sociales para más ideas</div>
            <div class="logos">
                <a href="https://www.facebook.com" target="_blank"><img src="./img/f.jpg" alt="Facebook"></a>
                <a href="https://www.instagram.com" target="_blank"><img src="./img/i.jpg" alt="Instagram"></a>
                <a href="https://www.twitter.com" target="_blank"><img src="./img/t.jpg" alt="Twitter"></a>
            </div>
        </div>
    </div>
</body>
</html>
