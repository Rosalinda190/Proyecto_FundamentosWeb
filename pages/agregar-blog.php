<?php
    session_start();
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user')) {
        header('Location: ../pages/login.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $intro = $_POST['intro'];
        $content = $_POST['content'];
        $author_id = $_SESSION['user_id'];


        $imagen = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tipo = $_FILES['image']['type'];
            if ($tipo == "image/jpeg" || $tipo == "image/png" || $tipo == "image/jpg" || $tipo == "image/gif") {
                $imagen = file_get_contents($_FILES['image']['tmp_name']);
            } else {
                echo "Formato de imagen no permitido. Solo JPG, JPEG, PNG y GIF.";
                exit();
            }
        }

        $cad = new CAD();
        $result = $cad->createBlog($title, $intro, $content, $imagen, $author_id);

        if ($result) {
            $success_message = "Blog creado exitosamente.";
        } else {
            $error_message = "Error al crear el blog.";
        }
    }

?>

<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/agregar-blog.css" rel="stylesheet" type="text/css">
        <script src="../script.js"></script>
        <title>Agregar Blog - Pastry Delights</title>
    </head>
    <body>
        <div class="Contenedor">

        <div class="Encabezado">
            <div class="titulo">Pastry Delights</div>
             <div class="registro1">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="bd/logout.php"><button class="logout">Logout</button></a>
                <?php else: ?>
                    <a href="pages/registro.php"><button class="registrarse">Sign Up</button></a>
                    <a href="pages/login.php"><button class="entrar">Log In</button></a>
                <?php endif; ?>
             </div>            
            </div>

            <div class="menu-contenedor">
                <div class="menu">
                    <a href="../index.php">Home</a>
                    <a href="recetas.php">Recetas</a>
                    <a href="blogs.php">Blog Post</a>
                </div>
            </div>

            <main class="contenido-principal">
                <section class="AgregarBlog">
                    <h2>Agregar Nuevo Blog</h2>
                    <?php

                    if (isset($success_message)) {
                        echo "<p class='success-message'>$success_message</p>";
                    }
                    if (isset($error_message)) {
                        echo "<p class='error-message'>$error_message</p>";
                    }
                    ?>
                    <form action="agregar-blog.php" method="POST" enctype="multipart/form-data">
                        <label for="title">Título del Blog:</label>
                        <input type="text" id="title" name="title" placeholder="Ej. Las mejores tartas de chocolate" required>
                    
                        <label for="intro">Introducción:</label>
                        <textarea id="intro" name="intro" placeholder="Escribe una introducción del blog..." rows="3" required></textarea>
                    
                        <label for="content">Contenido:</label>
                        <textarea id="content" name="content" placeholder="Escribe el contenido del blog aquí..." rows="10" required></textarea>
                    
                        <label for="image">Sube una Imagen:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    
                        <button type="submit">Aceptar</button>
                    </form>
                    
                </section>
            </main>

            <footer class="Pie">
                <div class="SubP">Busca nuestras redes sociales para más ideas</div>
                <div class="logos">
                    <a href="https://www.facebook.com" target="_blank"><img src="../img/f.jpg" alt="Facebook"></a>
                    <a href="https://www.instagram.com" target="_blank"><img src="../img/i.jpg" alt="Instagram"></a>
                    <a href="https://www.twitter.com" target="_blank"><img src="../img/t.jpg" alt="Twitter"></a>
                </div>
            </footer>
        </div>
    </body>
</html>
