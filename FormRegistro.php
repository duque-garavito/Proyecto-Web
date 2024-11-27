<?php

@include 'Conexion.php';

session_start();
if (isset($_POST['submit'])) {

   $nombre = mysqli_real_escape_string($conn, $_POST['Nombre']);
   $apellido = mysqli_real_escape_string($conn, $_POST['Apellido']);
   $email = mysqli_real_escape_string($conn, $_POST['Correo']);
   $pass = $_POST['Contraseña'];
   $cpass = $_POST['Confirmar_Contraseña'];
   $id_rol = $_POST['Id_Rol'];

   $error = [];

   if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $pass)) {
      $error[] = 'La contraseña debe tener al menos 8 caracteres, incluyendo letras, números y símbolos.';
   }

   $select = "SELECT * FROM usuario WHERE Correo = '$email'";
   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $error[] = '¡El usuario ya existe!';
   }

   if ($pass != $cpass) {
      $error[] = '¡Las contraseñas no coinciden!';
   }

   if (empty($error)) {
     $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);   
      $insert = "INSERT INTO usuario(Nombre, Apellido, Correo, Contraseña, Id_Rol) 
                 VALUES('$nombre', '$apellido', '$email', '$hashed_pass', '$id_rol')";

      if (mysqli_query($conn, $insert)) {
         $to = $email;
         $subject = "Confirmación de Registro";
         $message = "
         <html>
         <head>
         <title>Confirmación de Registro</title>
         </head>
         <body>
         <p>Hola, $nombre $apellido,</p>
         <p>Gracias por registrarte. Haz clic en el enlace a continuación para confirmar tu registro:</p>
         <a href='http://localhost/loginweb/Confirmacion.php?email=$email'>Confirmar Registro</a>
         </body>
         </html>
         ";
         $headers = "MIME-Version: 1.0" . "\r\n";
         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
         $headers .= 'From: artesanosa3@gmail.com' . "\r\n";

         if (mail($to, $subject, $message, $headers)) {
            echo "<div class='alert alert-success'>Usuario registrado exitosamente. Revisa tu correo para confirmar.</div>";
         } else {
            echo "<div class='alert alert-danger'>Error al enviar el correo de confirmación.</div>";
         }
      } else {
         echo "<div class='alert alert-danger'>Error al registrar el usuario.</div>";
      }
   }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Formulario de Registro</title>
   <link rel="stylesheet" href="css/style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
        <form action="" method="post">
            <h3 class="text-center mb-4">Regístrate ahora</h3>

            <?php
            if (!empty($error)) {
                foreach ($error as $err) {
                    echo '<div class="alert alert-danger">' . $err . '</div>';
                }
            }
            ?>

            <div class="mb-3">
                <label for="Nombre" class="form-label">Nombre:</label>
                <input type="text" name="Nombre" class="form-control" id="Nombre" required placeholder="Ingresa tu nombre">
            </div>
            
            <div class="mb-3">
                <label for="Apellido" class="form-label">Apellido:</label>
                <input type="text" name="Apellido" class="form-control" id="Apellido" required placeholder="Ingresa tu apellido">
            </div>
            
            <div class="mb-3">
                <label for="Correo" class="form-label">Correo:</label>
                <input type="email" name="Correo" class="form-control" id="Correo" required placeholder="Ingresa tu correo">
            </div>
            
            <div class="mb-3">
                <label for="Contraseña" class="form-label">Contraseña:</label>
                <input type="password" name="Contraseña" class="form-control" id="Contraseña" required placeholder="Ingresa tu contraseña">
            </div>
            
            <div class="mb-3">
                <label for="Confirmar_Contraseña" class="form-label">Confirmar Contraseña:</label>
                <input type="password" name="Confirmar_Contraseña" class="form-control" id="Confirmar_Contraseña" required placeholder="Confirma tu contraseña">
            </div>
            
            <div class="mb-3">
                <label for="Id_Rol" class="form-label">Rol:</label>
                <select name="Id_Rol" class="form-select" id="Id_Rol">
                    <option value="1">Usuario</option>
                </select>
            </div>
            
            <button type="submit" name="submit" class="btn btn-primary w-100">Regístrate ahora</button>

            <p class="text-center mt-3">¿Ya tienes una cuenta? <a href="Login.php">Inicia sesión</a></p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
