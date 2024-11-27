<?php
require 'Conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];


    $sql = "SELECT Id_Usuario FROM usuario WHERE token = ? AND token_expira > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = $_POST['Contraseña'];
            $confirmar_password = $_POST['Confirmar_Contraseña'];

            if ($password === $confirmar_password) {
             
                if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $password)) {
                    $nueva_contra = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "UPDATE usuario SET Contraseña = ?, token = NULL, token_expira = NULL WHERE token = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $nueva_contra, $token);
                    $stmt->execute();

                    echo "<div class='alert alert-success'>Contraseña actualizada correctamente. Ahora puedes <a href='Login.php' class='alert-link'>iniciar sesión</a>.</div>";
                } else {
                    echo "<div class='alert alert-danger'>La contraseña debe tener al menos 8 caracteres, incluyendo letras, números y símbolos.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Las contraseñas no coinciden. Inténtalo de nuevo.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-warning'>El enlace de restablecimiento es inválido o ha expirado.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Restablecer Contraseña</h3>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Contraseña">Nueva Contraseña</label>
                                <input type="password" name="Contraseña" id="Contraseña" class="form-control" required placeholder="Introduce tu nueva contraseña">
                            </div>
                            <div class="form-group">
                                <label for="Confirmar_Contraseña">Confirmar Nueva Contraseña</label>
                                <input type="password" name="Confirmar_Contraseña" id="Confirmar_Contraseña" class="form-control" required placeholder="Confirma tu nueva contraseña">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
                            <div class="text-center mt-3">
                                <a href="Login.php">Volver al login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
