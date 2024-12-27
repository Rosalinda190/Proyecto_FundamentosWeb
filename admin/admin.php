<?php
    session_start();
    require_once("../bd/CAD.php");
    require_once("../bd/conexion.php");


    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../login.php');
        exit();
    }

    $cad = new CAD();
    $message = "";


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_user'])) {
            $userId = intval($_POST['delete_user']);
            if ($cad->deleteUser($userId)) {
                $message = "Usuario eliminado correctamente.";
            } else {
                $message = "Error al eliminar el usuario.";
            }
        } elseif (isset($_POST['update_role']) && isset($_POST['role'])) {
            $userId = intval($_POST['update_role']);
            $newRole = $_POST['role'];
            if ($cad->updateUserRole($userId, $newRole)) {
                $message = "Rol actualizado correctamente.";
            } else {
                $message = "Error al actualizar el rol.";
            }
        }
    }


    $users = $cad->getAllUsers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="Encabezado">
        <div class="titulo">Gestión de Usuarios - Admin</div>
        <div class="registro1">
            <a href="../bd/logout.php"><button class="logout">Logout</button></a>
        </div>
    </div>

    <h1>Gestionar Usuarios</h1>

    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <table border="1" style="width: 100%; text-align: center;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
         <?php foreach ($users as $user): ?>
          <tr>
             <td><?php echo htmlspecialchars($user['id']); ?></td>
             <td><?php echo htmlspecialchars($user['username']); ?></td>
             <td><?php echo htmlspecialchars($user['email']); ?></td>
             <td><?php echo htmlspecialchars($user['role']); ?></td>
             <td>

              <form method="POST" style="display: inline;">
                  <select name="role">
                     <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
                     <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                     <option value="guest" <?php echo $user['role'] === 'guest' ? 'selected' : ''; ?>>Invitado</option>
                  </select>
                   <button type="submit" name="update_role" value="<?php echo $user['id']; ?>">Actualizar Rol</button>
              </form>


                <form method="POST" style="display: inline;">
                    <button type="submit" name="delete_user" value="<?php echo $user['id']; ?>" 
                            onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                        Eliminar
                    </button>
                </form>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
