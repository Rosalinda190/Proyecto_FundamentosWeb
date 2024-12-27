<?php
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    session_start();

    $current_user_id = $_SESSION['user_id'] ?? null;

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Blog no encontrado.";
        exit();
    }

    $cad = new CAD();
    $blog_id = $_GET['id'];
    $blog = $cad->getBlog($blog_id);


    if (!$blog || $blog['author_id'] != $current_user_id) {
        echo "No tienes permisos para editar este blog.";
        exit();
    }

    $image_url = $blog['image'] ? 'data:image/jpeg;base64,' . base64_encode($blog['image']) : null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $intro = $_POST['intro'];
    $content = $_POST['content'];
    $image = $blog['image']; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tipo = $_FILES['image']['type'];
        if (in_array($tipo, ["image/jpeg", "image/png", "image/jpg", "image/gif"])) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            echo "Formato de imagen no permitido. Solo JPG, JPEG, PNG y GIF.";
            exit();
        }
    } else {
        $image = $blog['image'];
    }        
    

    $isUpdated = $cad->updateBlog($blog_id, $title,$intro, $content, $image);

    if ($isUpdated) {
        echo "Blog actualizado con éxito.";
        header("Location: ../pages/blog.php?id=$blog_id");
        exit();
    } else {
        echo "Error al actualizar el blog.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/agregar-blog.css" rel="stylesheet" type="text/css">
    <title>Editar Blog</title>
</head>
<body>
    <div class="Encabezado">
        <div class="titulo">Pastry Delights</div>
        <div class="registro1">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../bd/logout.php"><button class="logout">Logout</button></a>
            <?php endif; ?>
        </div>
    </div>
    <div> 
       <h1>Editar Blog</h1>
       <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>

            <label for="intro">Introdución:</label>
            <input type="text" id="intro" name="intro" value="<?php echo htmlspecialchars($blog['intro']); ?>" required>

            <label for="content">Contenido:</label>
            <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($blog['content']); ?></textarea>

            <label for="image">Imagen:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit" style="background-color: rgb(50, 28, 10); color: white; font-size: 12px; padding: 8px 15px; border-radius: 15px; cursor: pointer; border:none;">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
