<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <?php
                    @include 'Conexion.php';

                    if (isset($_GET['email'])) {
                        $email = mysqli_real_escape_string($conn, $_GET['email']);

                        $check_query = "SELECT * FROM usuario WHERE Correo = '$email' AND confirmado = 0";
                        $check_result = mysqli_query($conn, $check_query);

                        if (mysqli_num_rows($check_result) > 0) {
                        
                            $update_query = "UPDATE usuario SET confirmado = 1 WHERE Correo = '$email'";
                            if (mysqli_query($conn, $update_query)) {
                                echo "<div class='alert alert-success'>¡Registro confirmado exitosamente! Ahora puedes <a href='Login.php?' class='alert-link'>iniciar sesión</a>.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Error al confirmar el registro. Inténtalo de nuevo más tarde.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-warning'>El registro ya ha sido confirmado o el correo es incorrecto.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Enlace inválido.</div>";
                    }
                    ?>
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
