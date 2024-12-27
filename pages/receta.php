<?php
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    session_start();
    $role = $_SESSION['role'] ?? null;
    $current_user_id = $_SESSION['user_id'] ?? null;

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Receta no encontrada.";
        exit();
    }

    $cad = new CAD();
    $recipe_id = $_GET['id'];
    $recipe = $cad->getRecipe($recipe_id);

    if (!$recipe) {
        echo "Receta no encontrada.";
        exit();
    }

    $comments = $cad->getCommentsByRecipe($recipe_id);

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/recetaIndividual.css" rel="stylesheet" type="text/css">
        <script src="../script.js"></script>
        <title><?php echo htmlspecialchars($recipe['title']); ?></title>
    </head>

    <body>
        <div class="Contenedor">

            <div class="Encabezado">
                <div class="titulo">Pastry Delights</div>
                <div class="registro1">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="../bd/logout.php"><button class="logout">Logout</button></a>
                    <?php else: ?>
                        <a href="registro.php"><button class="registrarse">Sign Up</button></a>
                        <a href="login.php"><button class="entrar">Log In</button></a>
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

            <div class="Contenido">
                <h1 class="titulo-receta"><?php echo htmlspecialchars($recipe['title']); ?></h1>
                <div class="imagen-receta">
                    <?php if (!empty($recipe['image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['image']); ?>" alt="Imagen de la receta">
                    <?php else: ?>
                        <p>No hay imagen disponible para esta receta.</p>
                    <?php endif; ?>
                </div>
            <div class="receta-contenido">
                <div class="ingredientes">
                    <h2>Ingredientes:</h2>
                    <ul>
                        <?php
                        $ingredientes = explode("\n", $recipe['ingredients']);
                        foreach ($ingredientes as $ingrediente): ?>
                            <li><?php echo htmlspecialchars($ingrediente); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="instrucciones">
                <h2>Instrucciones:</h2>
                <?php
                $instrucciones = explode("\n", $recipe['instructions']); 
                foreach ($instrucciones as $paso): ?>
                    <p><?php echo htmlspecialchars($paso); ?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($current_user_id == $recipe['user_id']): ?>
                <div class="botones">
                    <a href="../bd/editar-receta.php?id=<?php echo $recipe_id; ?>"><button class="Editar">Editar</button></a>
                    <a href="../bd/eliminar.php?type=recipe&id=<?php echo $recipe_id; ?>" class="Eliminar" data-type="recipe">Eliminar</a>
                </div>
        <?php endif; ?>

        <div class="rating-container">
                <h2>Califica esta receta</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form class="form-rating" action="../bd/guardar-rating.php" method="POST">
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                        <div class="star-rating">
                            <input type="radio" name="rating" id="star5" value="5" required>
                            <label for="star5">★</label>
                            <input type="radio" name="rating" id="star4" value="4">
                            <label for="star4">★</label>
                            <input type="radio" name="rating" id="star3" value="3">
                            <label for="star3">★</label>
                            <input type="radio" name="rating" id="star2" value="2">
                            <label for="star2">★</label>
                            <input type="radio" name="rating" id="star1" value="1">
                            <label for="star1">★</label>
                        </div>
                        <button type="submit" class="btn-enviar">Enviar Calificación</button>
                    </form>
                <?php else: ?>
                    <p>Inicia sesión para calificar esta receta.</p>
                <?php endif; ?>
            </div>

            <div class="Comentarios">
                <h2>Deja tu comentario</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form class="form-comentario" action="../bd/guardar-comentario.php" method="POST">
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                        <label for="comentario">Comentario:</label>
                        <textarea id="comentario" name="comentario" rows="4" placeholder="Escribe aquí tu comentario..." required></textarea>
                        <button type="submit" class="btn-enviar">Enviar</button>
                    </form>
                <?php else: ?>
                    <p>Inicia sesión para dejar un comentario.</p>
                <?php endif; ?>

                <h2>Comentarios:</h2>
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comentario">
                            <p><strong><?php echo htmlspecialchars($comment['username']); ?>
                            <p><?php echo htmlspecialchars($comment['content']); ?></p>
                            <small>Publicado el: <?php echo htmlspecialchars($comment['created_at']); ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
                <?php endif; ?>
            </div>
            </div>


            <div class="Pie">
                <div class="SubP">¿Qué te pareció esta receta?</div>
                <div class="logos">
                    <a href="https://www.facebook.com" target="_blank"><img src="../img/f.jpg" alt="Facebook"></a>
                    <a href="https://www.instagram.com" target="_blank"><img src="../img/i.jpg" alt="Instagram"></a>
                    <a href="https://www.twitter.com" target="_blank"><img src="../img/t.jpg" alt="Twitter"></a>
                </div>
            </div>
        </div>
    </body>
</html>
