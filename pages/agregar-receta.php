<?php
    session_start();
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

 
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'user')) {
        header('Location: login.php'); 
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $title = $_POST['title'];
        $category = $_POST['category'];
        $difficulty = $_POST['difficulty'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $user_id = $_SESSION['user_id']; 
    
        $image = null; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tipo = $_FILES['image']['type'];
            if (in_array($tipo, ["image/jpeg", "image/png", "image/jpg", "image/gif"])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            } else {
                echo "Formato de imagen no permitido. Solo JPG, JPEG, PNG y GIF.";
                exit();
            }
        }
    
        $cad = new CAD();
        $result = $cad->createRecipe($title, $category, $difficulty, $ingredients, $instrucciones, $image, $instructions);
    
        if ($result) {
            $success_message = "Receta agregada exitosamente.";
        } else {
            $error_message = "Hubo un error al agregar la receta.";
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/agregar-receta.css" rel="stylesheet" type="text/css">
        <script src="../script.js"></script>
        <title>Agregar Receta - Pastry Delights</title>
    </head>
    <body>
        <div class="Contenedor">
         <div class="Encabezado">
                <div class="titulo">Pastry Delights</div>
                <div class="registro1">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="../bd/logout.php"><button class="logout">Logout</button></a>
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
            <section class="AgregarReceta">
                <h2>Agregar Nueva Receta</h2>
                <?php

                if (isset($success_message)) {
                    echo "<p class='success-message'>$success_message</p>";
                }
                if (isset($error_message)) {
                    echo "<p class='error-message'>$error_message</p>";
                }
                ?>
                <form action="agregar-receta.php" method="POST" enctype="multipart/form-data">
                    <label for="name">Nombre de la Receta:</label>
                    <input type="text" id="title" name="title" placeholder="Título de receta" required>
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <option value="Keto">Keto</option>
                        <option value="Sin Gluten">Sin Gluten</option>
                        <option value="General">General</option>
                    </select>
                
                    <label for="nivel">Nivel de Dificultad:</label>
                    <select id="nivel" name="nivel" required>
                        <option value="" disabled selected>Selecciona el nivel</option>
                        <option value="Principiante">Principiante</option>
                        <option value="Intermedio">Intermedio</option>
                        <option value="Avanzado">Avanzado</option>
                    </select>
                
                    <label for="ingredientes">Ingredientes:</label>
                    <textarea id="ingredientes" name="ingredientes" placeholder="Ej. Harina, huevo, azúcar..." rows="4" required></textarea>
                
                    <label for="instrucciones">Instrucciones:</label>
                    <textarea id="instrucciones" name="instrucciones" placeholder="Describe paso a paso..." rows="6" required></textarea>
                
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
