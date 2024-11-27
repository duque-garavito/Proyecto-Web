<?php
session_start();
include 'Conexion.php';


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$id_orden = $_SESSION['id_orden'] ?? null; 


$total = 0; 

if ($id_orden) {
   
    $conn->begin_transaction();

    try {
       
        foreach ($_SESSION['carrito'] as $id_producto => $producto) {
            $cantidad = $producto['Cantidad'];
            $precio_unitario = $producto['Precio'];
            $nombre_producto = $producto['Nombre'];

        
            $total += $cantidad * $precio_unitario;

          
            $queryInsertCarrito = "INSERT INTO carrito (Cantidad, Id_Usuario, Id_Producto, Id_Orden) VALUES (?, ?, ?, ?)";
            $stmtCarrito = $conn->prepare($queryInsertCarrito);
            $stmtCarrito->bind_param("iiii", $cantidad, $id_usuario, $id_producto, $id_orden);
            $stmtCarrito->execute();

           
            $queryInsertDetalle = "INSERT INTO detalle_orden (Cantidad, Id_Orden, Id_Producto, Nombre_Producto) VALUES (?, ?, ?, ?)";
            $stmtDetalle = $conn->prepare($queryInsertDetalle);
            $stmtDetalle->bind_param("iiis", $cantidad, $id_orden, $id_producto, $nombre_producto);
            $stmtDetalle->execute();
        }

        $conn->commit();
        unset($_SESSION['id_orden']); 
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al procesar los detalles de la compra: " . $e->getMessage();
        exit();
    }
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
    <h1 class="text-center mb-4">Compra en Proceso</h1>

    <div class="alert alert-success text-center">
        <h4>Su compra esta en proceso, puede ver el seguimiento de su compra.</h4>
        <p>Total a pagar: <?php echo number_format($total, 2); ?> soles</p>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

if (isset($stmtCarrito)) $stmtCarrito->close();
if (isset($stmtDetalle)) $stmtDetalle->close();
$conn->close();

