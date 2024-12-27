<?php
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");

    session_start();
    $current_user_id = $_SESSION['user_id'] ?? null;

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "Receta no encontrada.";
        exit();
    }

    $cad = new CAD();
    $recipe_id = $_GET['id'];
    $recipe = $cad->getRecipe($recipe_id);


    if (!$recipe || $recipe['user_id'] != $current_user_id) {
        echo "No tienes permisos para editar esta receta.";
        exit();
    }

    $image_url = $recipe['image'] ? 'data:image/jpeg;base64,' . base64_encode($recipe['image']) : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $difficulty = $_POST['difficulty'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $image = $recipe['image']; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tipo = $_FILES['image']['type'];
            if (in_array($tipo, ["image/jpeg", "image/png", "image/jpg", "image/gif"])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            } else {
                echo "Formato de imagen no permitido. Solo JPG, JPEG, PNG y GIF.";
                exit();
            }
        } else {
            $image = $recipe['image'];
        }        
        
        
        $isUpdated = $cad->updateRecipe($recipe_id, $title, $category, $difficulty, $ingredients, $instructions, $image);

        if ($isUpdated) {
            echo "Receta actualizada con éxito.";
            header("Location: ../pages/receta.php?id=$recipe_id");
            exit();
        } else {
            echo "Error al actualizar la receta.";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/agregar-receta.css" rel="stylesheet" type="text/css">
        <title>Editar Receta</title>
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
       <h1>Editar Receta</h1>
       <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>

            <label for="category">Categoría:</label>
            <select id="category" name="category" required>
                <option value="Keto" <?php echo $recipe['category'] === 'Keto' ? 'selected' : ''; ?>>Keto</option>
                <option value="Sin Gluten" <?php echo $recipe['category'] === 'Sin Gluten' ? 'selected' : ''; ?>>Sin Gluten</option>
                <option value="General" <?php echo $recipe['category'] === 'General' ? 'selected' : ''; ?>>General</option>
            </select>

            <label for="difficulty">Dificultad:</label>
            <select id="difficulty" name="difficulty" required>
                <option value="Principiante" <?php echo $recipe['difficulty'] === 'Principiante' ? 'selected' : ''; ?>>Principiante</option>
                <option value="Intermedio" <?php echo $recipe['difficulty'] === 'Intermedio' ? 'selected' : ''; ?>>Intermedio</option>
                <option value="Avanzado" <?php echo $recipe['difficulty'] === 'Avanzado' ? 'selected' : ''; ?>>Avanzado</option>
            </select>

            <label for="ingredients">Ingredientes:</label>
            <textarea id="ingredients" name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>

            <label for="instructions">Instrucciones:</label>
            <textarea id="instructions" name="instructions" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
            <label for="image">Nueva Imagen (opcional):</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit" style="background-color: rgb(50, 28, 10); color: white; font-size: 12px; padding: 8px 15px; border-radius: 15px; cursor: pointer; border:none;">Guardar Cambios</button>
        </form>
     </div>
  </body>
</html>
