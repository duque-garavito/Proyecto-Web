<?php
session_start();
@include 'Conexion.php';

$queryProductos = "SELECT Nombre, Precio, Descripcion FROM productos";
$resultado = mysqli_query($conn, $queryProductos);
?>



<?php include 'header.php'; ?>
    
<?php include 'home.php'; ?>

<?php include 'footer.php'; ?>
