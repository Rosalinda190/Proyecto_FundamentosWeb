<?php
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    session_start();
    $role = $_SESSION['role'] ?? null;
    $current_user_id = $_SESSION['user_id'] ?? null; 


    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Blog no encontrado.";
        exit();
    }

    $cad = new CAD();
    $blog_id = $_GET['id'];
    $blog = $cad->getBlog($blog_id);

    if (!$blog) {
        echo "Blog no encontrado.";
        exit();
    }

    $comments = $cad->getCommentsByBlog($blog_id);
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/blogIndividual.css" rel="stylesheet" type="text/css">
        <script src="../script.js"></script>
        <title><?php echo htmlspecialchars($blog['title']); ?></title>
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
                <h1 class="titulo-blog"><?php echo htmlspecialchars($blog['title']); ?></h1>
                <div class="imagen-blog">
                    <?php if (!empty($blog['image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($blog['image']); ?>" alt="Imagen del blog">
                    <?php else: ?>
                        <p>No hay imagen disponible para este blog.</p>
                    <?php endif; ?>
                </div>
                <div class="blog-contenido">
                    <div class="blog-detalle">
                        <p><strong>Publicado el:</strong> <?php echo date('d M Y', strtotime($blog['created_at'])); ?></p>
                        <p><strong>Autor:</strong> <?php echo htmlspecialchars($blog['username']); ?></p>
                    </div>
                    <div class="blog-texto">
                        <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                    </div>
                </div>
            </div>

        <?php if ($current_user_id == $blog['author_id']): ?>
            <div class="botones">
                <a href="../bd/editar-blog.php?id=<?php echo $blog_id; ?>"><button class="Editar">Editar</button></a>
                <a href="../bd/eliminar.php?type=blog&id=<?php echo $blog_id; ?>" class="Eliminar" data-type="blog">Eliminar</a>
            </div>
        <?php endif; ?>

            <div class="Comentarios">
                <h2>Deja tu comentario</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form class="form-comentario" action="../bd/guardar-comentario.php" method="POST">
                        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
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
                                <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong></p>
                                <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                <small>Publicado el: <?php echo htmlspecialchars($comment['created_at']); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
                    <?php endif; ?>
            </div>

            <div class="Pie">
                <div class="SubP">¿Qué te pareció este blog?</div>
                <div class="logos">
                    <a href="https://www.facebook.com" target="_blank"><img src="../img/f.jpg" alt="Facebook"></a>
                    <a href="https://www.instagram.com" target="_blank"><img src="../img/i.jpg" alt="Instagram"></a>
                    <a href="https://www.twitter.com" target="_blank"><img src="../img/t.jpg" alt="Twitter"></a>
                </div>
            </div>
        </div>
    </body>
</html>