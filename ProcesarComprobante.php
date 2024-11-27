<?php
session_start();
include 'Conexion.php';

if (!isset($_SESSION['usuario_id'], $_SESSION['metodo_pago'], $_SESSION['total'])) {
    echo "Error: Faltan datos necesarios para procesar la orden y el pago.";
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$metodo_pago = $_SESSION['metodo_pago'];
$total = $_SESSION['total'];

// Inicia la transacción
$conn->begin_transaction();

try {
    // Verifica si ya se ha creado la orden
    if (!isset($_SESSION['id_orden'])) {
        $queryInsertOrden = "INSERT INTO orden (Id_Usuario, Metodo_Pago, Total, Fecha, Estado) VALUES (?, ?, ?, NOW(), 'Pendiente')";
        $stmtOrden = $conn->prepare($queryInsertOrden);
        $stmtOrden->bind_param("isd", $id_usuario, $metodo_pago, $total);
        $stmtOrden->execute();

        $_SESSION['id_orden'] = $conn->insert_id;
    }

    $id_orden = $_SESSION['id_orden'];

    // Inserta el pago en la base de datos primero para obtener el id_pago
    $queryInsertPago = "INSERT INTO pagos (id_orden, fecha_pago, metodo_pago, monto, comprobante, estado) VALUES (?, NOW(), ?, ?, '', 'pendiente')";
    $stmtPago = $conn->prepare($queryInsertPago);
    $stmtPago->bind_param("isd", $id_orden, $metodo_pago, $total);
    $stmtPago->execute();

    // Obtiene el id_pago generado
    $id_pago = $conn->insert_id;

    // Verifica y renombra el comprobante usando id_pago
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] == 0) {
        $extension = pathinfo($_FILES['comprobante']['name'], PATHINFO_EXTENSION);
        $rutaComprobante = 'comprobantes/' . $id_pago . '.' . $extension;

        // Mueve el archivo
        if (!move_uploaded_file($_FILES['comprobante']['tmp_name'], $rutaComprobante)) {
            echo "Error al subir el comprobante.";
            exit();
        }

        // Actualiza la ruta del comprobante en el registro de pagos
        $queryUpdateComprobante = "UPDATE pagos SET comprobante = ? WHERE id_pago = ?";
        $stmtUpdate = $conn->prepare($queryUpdateComprobante);
        $stmtUpdate->bind_param("si", $rutaComprobante, $id_pago);
        $stmtUpdate->execute();
    } else {
        echo "Error: No se ha subido un comprobante válido.";
        exit();
    }

    // Confirma la transacción
    $conn->commit();
    echo "Pago procesado exitosamente.";

    // Limpia las variables de sesión
    unset($_SESSION['metodo_pago'], $_SESSION['total']);

    // Redirige a la página de confirmación de compra
    header("Location: ConfirmacionCompra.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Error al procesar la orden y el pago: " . $e->getMessage();
}
?>
