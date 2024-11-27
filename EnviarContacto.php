<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del formulario
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $comment = htmlspecialchars(trim($_POST['comment']));

    // Verifica que el correo sea válido
    if (!$email) {
        echo "Correo electrónico no válido.";
        exit;
    }

    // Dirección de correo de la empresa
    $empresaEmail = "artesanosa3@gmail.com";

    // Asunto del correo para la empresa
    $subjectEmpresa = "Nuevo mensaje de contacto de $firstName $lastName";
    $messageEmpresa = "Has recibido un nuevo mensaje de contacto.\n\n" .
                      "Nombre: $firstName $lastName\n" .
                      "Correo electrónico: $email\n" .
                      "Comentario: $comment\n";

    // Enviar correo a la empresa
    $headersEmpresa = "From: $email\r\n";
    $mailSentEmpresa = mail($empresaEmail, $subjectEmpresa, $messageEmpresa, $headersEmpresa);

    // Asunto y mensaje de confirmación para el usuario
    $subjectUsuario = "Confirmación de recepción de mensaje - Artesanías Catacaos";
    $messageUsuario = "Hola $firstName $lastName,\n\n" .
                      "Gracias por ponerte en contacto con nosotros. Hemos recibido tu mensaje y te responderemos a la brevedad.\n\n" .
                      "Este es el resumen de tu mensaje:\n" .
                      "Nombre: $firstName $lastName\n" .
                      "Correo electrónico: $email\n" .
                      "Comentario: $comment\n\n" .
                      "Saludos,\n" .
                      "Artesanías Catacaos";

    // Enviar correo de confirmación al usuario
    $headersUsuario = "From: $empresaEmail\r\n";
    $mailSentUsuario = mail($email, $subjectUsuario, $messageUsuario, $headersUsuario);

    // Comprobar si se enviaron los correos
    if ($mailSentEmpresa && $mailSentUsuario) {
        // Redireccionar o mostrar mensaje de éxito
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirmación de Envío</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='d-flex justify-content-center align-items-center vh-100 bg-light'>
            <div class='text-center'>
                <div class='alert alert-success' role='alert'>
                    <h4 class='alert-heading'>Gracias por tu mensaje</h4>
                    <p>Te hemos enviado un correo de confirmación.</p>
                </div>
                <a href='index.php' class='btn btn-primary'>Volver al inicio</a>
            </div>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
        </body>
        </html>";
    } else {
        echo "Error al enviar el mensaje. Por favor, intenta nuevamente más tarde.";
    }
} else {
    echo "Error al enviar el mensaje.";
}
?>
