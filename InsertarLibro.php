<?php
@include 'Conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el correo está en la sesión antes de usarlo
if (isset($_SESSION['correo'])) {
    $email = $_SESSION['correo'];
} else {
    echo "<div class='alert alert-warning'>No se encontró el correo en la sesión.</div>";
    exit();
}

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['usuario_id'];
    $telefono = $_POST['telefono'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];
    $estado = 'Pendiente'; // Estado inicial para cada reclamo

    // Insertar el reclamo en la base de datos
    $sql = "INSERT INTO reclamos (id_usuario, telefono, asunto, descripcion, estado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_usuario, $telefono, $asunto, $descripcion, $estado);

    if ($stmt->execute()) {
        // Enviar correo de confirmación
        $to = $email;
        $subject = "Confirmación de Reclamo";
        $message = "
        <html>
        <head>
        <title>Confirmación de Reclamo</title>
        </head>
        <body>
        <p>Estimado cliente,</p>
        <p>Hemos recibido tu reclamo con el siguiente detalle:</p>
        <p><strong>Asunto:</strong> $asunto</p>
        <p><strong>Mensaje:</strong> $descripcion</p>
        <p>Nos pondremos en contacto contigo a la brevedad para brindarte una solución.</p>
        <p>Gracias por tu confianza en nosotros.</p>
        </body>
        </html>
        ";
        
        // Encabezados del correo
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: artesanosa3@gmail.com' . "\r\n";

        // Enviar el correo
        if (mail($to, $subject, $message, $headers)) {
            echo "<div class='alert alert-success'>Reclamo enviado y correo de confirmación enviado al cliente.</div>";
        } else {
            echo "<div class='alert alert-warning'>Reclamo registrado, pero no se pudo enviar el correo de confirmación.</div>";
        }

    } else {
        echo "<div class='alert alert-danger'>Error al registrar el reclamo.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reclamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <div class="alert alert-success text-center" role="alert">
                <h4 class="alert-heading">Reclamo Enviado</h4>
                <p>Reclamo enviado y correo de confirmación enviado al cliente.</p>
                <hr>
                <p class="mb-0">Gracias por tu paciencia. Nos pondremos en contacto contigo a la brevedad.</p>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
