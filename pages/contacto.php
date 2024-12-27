<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/contacto.css" rel="stylesheet" type="text/css">
    <script src="../script.js"></script>
    <title>Contacto - Pastry Delights</title>
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
        <div class="Contacto">
            <h2>Contáctanos</h2>
            <form action="back/enviar.php" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            
                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
            
                <button type="submit">Enviar</button>
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
