<?php 
session_start();
@include 'Conexion.php'; // Asegúrate de tener una conexión a la base de datos
include 'header.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php"); // Redirige al login si no está autenticado
    exit();
}

// Obtiene el ID del usuario desde la sesión
$id_usuario = $_SESSION['usuario_id'];

// Consulta para obtener las órdenes y pagos del usuario
$sql = "SELECT 
            o.Id_Orden, o.Fecha, o.Total, o.Estado AS estado_orden, o.Metodo_Pago,
            p.fecha_pago, p.monto, p.estado AS estado_pago
        FROM 
            orden o
        LEFT JOIN 
            pagos p ON o.Id_Orden = p.id_orden
        WHERE 
            o.Id_Usuario = ?
        ORDER BY 
            o.Fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Pedido</title>
    <link rel="stylesheet" href="css/seguimiento.css">
</head>
<body>
<main>

<div class="container">
    <h2>Seguimiento de Pedido</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha de Orden</th>
                    <th>Total</th>
                    <th>Estado de Orden</th>
                    <th>Método de Pago</th>
                    <th>Fecha de Pago</th>
                    <th>Monto Pago</th>
                    <th>Estado de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date("d-m-Y", strtotime($row['Fecha'])); ?></td>
                        <td><?php echo number_format($row['Total'], 2); ?></td>
                        <td class="status status-<?php echo strtolower($row['estado_orden']); ?>">
                            <?php echo ucfirst($row['estado_orden']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['Metodo_Pago']); ?></td>
                        <td><?php echo isset($row['fecha_pago']) ? date("d-m-Y", strtotime($row['fecha_pago'])) : 'No realizado'; ?></td>
                        <td><?php echo isset($row['monto']) ? number_format($row['monto'], 2) : '-'; ?></td>
                        <td class="status status-<?php echo strtolower($row['estado_pago'] ?? 'pendiente'); ?>">
                            <?php echo isset($row['estado_pago']) ? ucfirst($row['estado_pago']) : 'Pendiente'; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
