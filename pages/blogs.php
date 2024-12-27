<?php
    session_start();
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    $cad = new CAD();

    try {

        $blogs = $cad->getAllBlogs();
    } catch (Exception $e) {
        $error = "Error al cargar los blogs: " . $e->getMessage();
        $blogs = [];
    }
?>

<!DOCTYPE html>
<html lang="es">
        
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/blog.css" rel="stylesheet" type="text/css">
        <script src="../script.js"></script>
        <title>Blog - Pastry Delights</title>
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

            <div class="blog-titulo">
                <h1>PASTRY BLOG</h1>
            </div>

            <div class="blog-contenido">
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php elseif (!empty($blogs)): ?>
                    <?php foreach ($blogs as $blog): ?>
                        <article class="blog-card">
                            <div class="card-fecha"><?php echo date('d M Y', strtotime($blog['created_at'])); ?></div>
                            <div class="card-autor">Autor: <?php echo htmlspecialchars($blog['username']); ?></div>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($blog['image']); ?>" alt="Imagen del blog">
                            <div class="card-contenido">
                                <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                                <p><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                                <a href="blog.php?id=<?php echo $blog['id']; ?>"><button class="leer">Seguir leyendo</button></a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se encontraron blogs.</p>
                <?php endif; ?>
            </div>

            <a href="agregar-blog.php"><button class="agregar-blog">Añadir Blog</button></a>
            
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
