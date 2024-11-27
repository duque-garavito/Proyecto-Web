<?php
require 'Conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Correo'];

    $sql = "SELECT Id_Usuario FROM usuario WHERE Correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $token = bin2hex(random_bytes(50));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour")); 

        $sql = "UPDATE usuario SET token = ?, token_expira = ? WHERE Correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $expira, $email);
        $stmt->execute();


        $url = "http://localhost/loginweb/RestContra.php?token=$token";
        $mensaje = "Hola,\n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n\n$url\n\nSi no solicitaste este cambio, puedes ignorar este mensaje.";
        $headers = "From: artesanosa3@gmail.com";

        if (mail($email, "Recuperación de contraseña", $mensaje, $headers)) {
            echo "<div class='alert alert-success'>Se ha enviado un enlace de recuperación a tu correo electrónico.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al enviar el correo de recuperación.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>No se encontró ninguna cuenta con ese correo electrónico.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Recuperar Contraseña</h3>
                        <form action="RcpContra.php" method="POST">
                            <div class="form-group">
                                <label for="Correo">Correo Electrónico</label>
                                <input type="email" name="Correo" id="Correo" class="form-control" required placeholder="Introduce tu correo electrónico">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Enviar enlace de Recuperación</button>
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

