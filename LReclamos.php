<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones Virtual</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center">Libro de Reclamaciones</h2>
            <p>En nuestra empresa, nos tomamos muy en serio las quejas de nuestros clientes. Nos esforzamos por brindar
                un servicio excepcional y estamos comprometidos a mejorar continuamente. Si tienes alguna inquietud, por
                favor llena este formulario y nos comunicaremos contigo a la brevedad.</p>

            <form action="InsertarLibro.php" class="mt-4" method="POST">
                <div class="form-group mb-3">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="9"
                        placeholder="Ingresa un número de contacto." pattern="9[0-9]{8}" title="Ingrese un número valido."
                        required>
                </div>
                <div class="form-group mb-3">
                    <label for="asunto">Asunto</label>
                    <select class="form-control" id="asunto" name="asunto" required>
                        <option value="">Selecciona un asunto</option>
                        <option value="Calidad del producto">Calidad del producto</option>
                        <option value="Servicio al cliente">Servicio al cliente</option>
                        <option value="Compra">Problemas con mi compra</option>
                        <option value="Página Web">Conflictos en la página web</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Mensaje</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5"
                        placeholder="Escribe tu mensaje aquí" title="Ingrese un mensaje valido."
                        maxlength="255" required></textarea>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <a href="Index.php" class="btn btn-secondary">Regresar al Inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
