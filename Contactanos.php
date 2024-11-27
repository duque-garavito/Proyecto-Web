<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="css/Contactanos.css">
</head>
<body>
    
<main>

<?php session_start(); ?>
<div class="contact-form">
    <div class="form-container">
      <h2>Contacto</h2>
      <form action="EnviarContacto.php" method="POST">
        <div class="form-group">
          <label for="first_name">Nombre *</label>
          <input type="text" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
          <label for="last_name">Apellido *</label>
          <input type="text" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
          <label for="email">Correo electrónico *</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="comment">Comentario *</label>
          <textarea id="comment" name="comment" required></textarea>
        </div>
        <div class="form-group">
          <button type="submit">Enviar</button>
        </div>
      </form>
    </div>
    <div class="map-container">
      <p>Ubícanos en:<br>Jr. Comercio N° 400 Catacaos-Piura</p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15605.19829231091!2d-80.666595!3d-5.2696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMTYnMDEuMiJTIDgwwrAzOSc5OS4xIlc!5e0!3m2!1ses!2spe!4v1696899222923!5m2!1ses!2spe" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
    </main>
    <?php include 'footer.php'; ?>
    </body>

</html>