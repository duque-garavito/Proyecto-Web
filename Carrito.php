<?php
session_start();
include "Conexion.php";


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id_Producto = $_POST['Id_Producto'];
    if ($_POST['action'] === 'add') {
        $consulta = $conn->prepare("SELECT Nombre, Precio FROM productos WHERE Id_Producto = ?");
        $consulta->bind_param("i", $Id_Producto);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $producto = $resultado->fetch_assoc();

        if ($producto) {
            if (isset($_SESSION['carrito'][$Id_Producto])) {
                $_SESSION['carrito'][$Id_Producto]['Cantidad'] += 1;
            } else {
                $_SESSION['carrito'][$Id_Producto] = [
                    'Nombre' => $producto['Nombre'],
                    'Precio' => $producto['Precio'],
                    'Cantidad' => 1
                ];
            }
            $_SESSION['mensaje_carrito'] = "Producto agregado al carrito";
        }
    } elseif ($_POST['action'] === 'remove') {
        unset($_SESSION['carrito'][$Id_Producto]);
        $_SESSION['mensaje_carrito'] = "Producto eliminado del carrito";
    } elseif ($_POST['action'] === 'update') {
            foreach ($_POST['cantidad'] as $id => $cantidad) {
            $_SESSION['carrito'][$id]['Cantidad'] = max(1, (int)$cantidad); // Asegura que la cantidad sea al menos 1
        }
        $_SESSION['mensaje_carrito'] = "Carrito actualizado";
    }
}
$mensaje = "";
if (isset($_SESSION['mensaje_carrito'])) {
    $mensaje = $_SESSION['mensaje_carrito'];
    unset($_SESSION['mensaje_carrito']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Carrito de Compras</h1>

    <?php if ($mensaje): ?>
        <div class="alert alert-success">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <form action="Carrito.php" method="post">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$total = 0;
foreach ($_SESSION['carrito'] as $id => $producto):

    $cantidad = isset($producto['Cantidad']) ? (int)$producto['Cantidad'] : 1; 
    $precio = isset($producto['Precio']) ? (float)$producto['Precio'] : 0.0;   
    $subtotal = $precio * $cantidad;
    $total += $subtotal;
?>
    <tr>
        <td><?php echo htmlspecialchars($producto['Nombre']); ?></td>
        <td><?php echo number_format($precio, 2); ?> soles</td>
        <td>
            <input type="number" name="cantidad[<?php echo $id; ?>]" value="<?php echo $cantidad; ?>" min="1" class="form-control">
        </td>
        <td><?php echo number_format($subtotal, 2); ?> soles</td>
        <td>
            <form action="Carrito.php" method="post">
                <input type="hidden" name="Id_Producto" value="<?php echo $id; ?>">
                <button type="submit" name="action" value="remove" class="btn btn-danger btn-sm">Eliminar</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>


                    <tr>
                        <td colspan="3" class="text-right font-weight-bold">Total</td>
                        <td><?php echo number_format($total, 2); ?> soles</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" name="action" value="update" class="btn btn-primary">Actualizar Carrito</button>
                <a href="Index.php" class="btn btn-secondary">Volver a la Tienda</a>
                <a href="ProcesarCompra.php" class="btn btn-success">Procesar Compra</a>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Tu carrito está vacío. <a href="Index.php">Volver a la tienda</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
