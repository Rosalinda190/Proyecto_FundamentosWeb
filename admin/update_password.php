<?php
    require_once("../bd/conexion.php");

    $conexion = new Conexion();


    $hashedPassword = password_hash("ma22@2024", PASSWORD_DEFAULT);


    $email = "marissa1@gmail.com"; 


    $query = "UPDATE users SET password = :password WHERE email = :email";
    $resultado = $conexion->conectar()->prepare($query);
    $resultado>bindParam(':password', $hashedPassword);
    $resultado->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "Contraseña actualizada correctamente.";
    } else {
        echo "Error al actualizar la contraseña.";
    }
?>
