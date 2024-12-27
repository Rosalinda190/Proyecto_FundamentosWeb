<?php
require_once("../bd/CAD.php");
require_once("../bd/conexion.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//petición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['comentario']);
    $recipe_id = $_POST['recipe_id'] ?? null; 
    $blog_id = $_POST['blog_id'] ?? null;    

    if (empty($content) || (!$recipe_id && !$blog_id)) {
        $redirect = $recipe_id ? "receta.php?id=$recipe_id" : "blog.php?id=$blog_id";
        header("Location: $redirect&error=invalid_request");
        exit();
    }

    $cad = new CAD();
    $success = false;

    if ($recipe_id) {
        $success = $cad->saveComment($user_id, $recipe_id, $content);
    } elseif ($blog_id) {
        $success = $cad->saveBlogComment($user_id, $blog_id, $content);
    }

    $redirect = $recipe_id ? "../pages/receta.php?id=$recipe_id" : "../pages/blog.php?id=$blog_id";
    if ($success) {
        header("Location: $redirect&success=comment_saved");
    } else {
        header("Location: $redirect&error=save_failed");
    }
    exit();
}
?>
