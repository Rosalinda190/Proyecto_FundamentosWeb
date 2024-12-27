<?php
require_once("CAD.php");
require_once("conexion.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "No tienes permisos para realizar esta acción.";
    exit();
}

$type = $_GET['type'] ?? null; 
$id = $_GET['id'] ?? null;

if (!$type || !$id || !is_numeric($id)) {
    echo "Solicitud inválida.";
    exit();
}

$cad = new CAD();

if ($type === "recipe") {
    $deleted = $cad->deleteRecipe($id);
} elseif ($type === "blog") {
    $deleted = $cad->deleteBlog($id);
} else {
    echo "Tipo de contenido no válido.";
    exit();
}

if ($deleted) {
    $redirect = $type === "recipe" ? "recetas.php" : "blogs.php";
    header("Location: ../pages/$redirect");
    exit();
} else {
    echo "Error al eliminar el contenido.";
    exit();
}