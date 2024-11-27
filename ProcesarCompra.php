<?php
session_start();
include "Conexion.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$total = 0;
if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $cantidad = isset($producto['Cantidad']) ? (int)$producto['Cantidad'] : 1;
        $precio = isset($producto['Precio']) ? (float)$producto['Precio'] : 0.0;
        $total += $precio * $cantidad;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo_pago = $_POST['metodo_pago'];

    $_SESSION['metodo_pago'] = $metodo_pago;
    $_SESSION['total'] = $total;

    echo "Método de Pago: " . $_SESSION['metodo_pago'] . "<br>";
    echo "Total: " . $_SESSION['total'] . "<br>";

    if ($metodo_pago === 'yape') {
        header("Location: PagoYape.php?metodo=" . urlencode($metodo_pago) . "&total=" . urlencode($total));
    } else {
        header("Location: ConfirmacionCompra.php?metodo=" . urlencode($metodo_pago) . "&total=" . urlencode($total));
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Resumen de Compra</h1>
    
    <div class="alert alert-info">
        <h4>Total a pagar: <?php echo number_format($total, 2); ?> soles</h4>
    </div>
    
    <form action="ProcesarCompra.php" method="post">
        <div class="form-group">
            <label for="metodo_pago">Seleccione el método de pago:</label>
            <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                <option value="transferencia">Transferencia Bancaria</option>
                <option value="yape">Yape</option>
                <option value="plin">Plin</option>
            </select>
        </div>
        
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">Proceder con el Pago</button>
            <a href="Carrito.php" class="btn btn-secondary">Volver al Carrito</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
