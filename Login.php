<?php
@include 'Conexion.php';
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['Correo']);
    $pass = $_POST['Contraseña']; 
    $select = "SELECT u.*, r.Nombre as rol_Nombre 
               FROM usuario u
               JOIN rol r ON u.Id_Rol = r.Id_Rol 
               WHERE u.Correo = '$email' AND u.Confirmado = 1";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if (password_verify($pass, $row['Contraseña'])) {
            $_SESSION['usuario_id'] = $row['Id_Usuario'];
            $_SESSION['usuario_Nombre'] = $row['Nombre'];
            $_SESSION['rol_Nombre'] = $row['rol_Nombre'];
            $_SESSION['correo'] = $row['Correo']; 

            if ($row['rol_Nombre'] == 'Administrador') {
                header('Location: admin/inicioAdmin.php');
            } elseif ($row['rol_Nombre'] == 'Usuario') {
                header('Location: Index.php');
            }
            exit();
        } else {
            $error[] = 'Correo o Contraseña Incorrecta!';
        }
    } else {
        $error[] = 'Correo o Contraseña Incorrecta o cuenta no confirmada.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inicio de Sesión</title>
   <link rel="stylesheet" href="css/style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
   <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="col-md-6 col-lg-4">
         <div class="card shadow">
            <div class="card-body text-center">
               <div class="mb-4">
                  <img src="imagenes/LOGO.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
               </div>
               <h3 class="card-title text-center mb-4">Nuevo Ingreso</h3>
               <form action="" method="post">
                  <?php
                  if (isset($error)) {
                     foreach ($error as $msg) {
                        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($msg) . '</div>';
                     }
                  }
                  ?>
                  <div class="mb-3">
                     <label for="Correo" class="form-label">Correo Electrónico</label>
                     <input type="email" name="Correo" id="Correo" class="form-control" required placeholder="Ingresa tu correo">
                  </div>
                  <div class="mb-3">
                     <label for="Contraseña" class="form-label">Contraseña</label>
                     <input type="password" name="Contraseña" id="Contraseña" class="form-control" required placeholder="Ingresa tu contraseña">
                  </div>
                  <div class="d-grid">
                     <button type="submit" name="submit" class="btn btn-primary">Iniciar Sesión</button>
                  </div>
                  <div class="text-center mt-3">
                     <p><a href="RcpContra.php">¿Olvidaste tu contraseña?</a></p>
                     <p>¿No tienes una cuenta? <a href="FormRegistro.php">Regístrate ahora</a></p>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
