<?php
    session_start();
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    $cad = new CAD();

    $difficulty = $_GET['difficulty'] ?? null; 
    $category = $_GET['category'] ?? null; 

    $filters = [
        'difficulty' => $difficulty,
        'category' => $category
    ];

    $recipes = $cad->getFilteredRecipes($filters);

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/recetas.css" rel="stylesheet" type="text/css">
        <script src="../script.js"></script>
        <title>Recetas - Pastry Delights</title>
    </head>

    <body>
        <div class="Contenedor">
            <div class="Encabezado">
                <div class="titulo">Pastry Delights</div>
                <div class="registro1">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="../logout.php"><button class="logout">Logout</button></a>
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
            
           <div class="contenido-principal">
             <div class="Filtros">
                <a href="agregar-receta.php"><button class="agregar-receta">Añadir Receta</button></a>
                <br>
                <h2 class="filtros-titulo">Filtrar por:</h2>
                <div class="filtros-nivel">
                <h3>Nivel</h3>
                <button onclick="window.location.href='recetas.php?difficulty=Principiante'">Principiante</button>
                <button onclick="window.location.href='recetas.php?difficulty=Intermedio'">Intermedio</button>
                <button onclick="window.location.href='recetas.php?difficulty=Avanzado'">Avanzado</button>
                </div>
             <div class="filtros-categoria">
                <h3>Categoría</h3>
                <button onclick="window.location.href='recetas.php?category=Sin Gluten'">Normal (con azúcar)</button>
                <button onclick="window.location.href='recetas.php?category=Keto'">Keto</button>
                <button onclick="window.location.href='recetas.php?category=Sin Gluten'">Sin Gluten</button>
             </div>

            </div>

            <section class="Recetas">
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <?php $averageRating = $cad->getAverageRating($recipe['id']); ?>
                     <article class="receta">
                        <a href="receta.php?id=<?php echo $recipe['id']; ?>">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['image']); ?>" alt="Imagen de la receta">
                            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                            <div class="rating">
                                <p>Calificación: <?php echo number_format($averageRating, 1); ?> ★</p>
                                <small>Creado por: <?php echo htmlspecialchars($recipe['username']); ?></small>
                            </div>
                        </a>
                     </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay recetas disponibles.</p>
                <?php endif; ?>
            </section>

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
