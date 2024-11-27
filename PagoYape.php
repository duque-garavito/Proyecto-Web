<?php  
session_start();
include "Conexion.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Guardamos en la sesión el método de pago y el total que se utilizarán en ProcesarComprobante.php
if (isset($_GET['metodo']) && isset($_GET['total'])) {
    $_SESSION['metodo_pago'] = $_GET['metodo'];
    $_SESSION['total'] = (float)$_GET['total'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Escanea el QR para pagar con Yape o Plin</h2>
    <p class="text-center">Por favor, utiliza el siguiente QR para completar el pago:</p>
    <div class="text-center mb-4">
        <img src="imagenes/Yape.jpg" alt="QR de Yape y Plin" class="img-fluid" />
        <style>
            .img-fluid{
                height: 200px;
            }
        </style>
    </div>
    <p class="text-center">Luego de realizar el pago, sube el comprobante para confirmar la transacción.</p>
    <p class="text-center">POR FAVOR SUBIR SU COMPROBANTE EN FORMATO: .png .jpg</p>

    <!-- Formulario para subir el comprobante -->
    <form action="ProcesarComprobante.php" method="POST" enctype="multipart/form-data" class="text-center">
        <div class="form-group">
            <label for="comprobante">Subir comprobante:</label>
            <input type="file" name="comprobante" id="comprobante" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary">Enviar comprobante</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>