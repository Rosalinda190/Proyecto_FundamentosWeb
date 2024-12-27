<?php
require_once("../bd/CAD.php");
require_once("../bd/conexion.php");

session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = $_POST['recipe_id'];
    $user_id = $_SESSION['user_id'];
    $rating = (int) $_POST['rating'];


    if ($rating < 1 || $rating > 5) {
        header("Location: ../pages/receta.php?id=$recipe_id&error=invalid_rating");
        exit();
    }

    $cad = new CAD();

    if ($cad->saveOrUpdateRating($recipe_id, $user_id, $rating)) {
        header("Location: ../pages/receta.php?id=$recipe_id&success=rating_saved");
    } else {
        header("Location: ../pages/receta.php?id=$recipe_id&error=rating_failed");
    }
    exit();
}
?>
