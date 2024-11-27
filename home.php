<?php
@include "Conexion.php"; 

$sql = "SELECT * FROM productos";
$resultProductos = mysqli_query($conn, $sql);

if (!$resultProductos) {
    die('Error en la consulta: ' . mysqli_error($conn));
}
?>

<body>
    <main>
        <div class="container">
            <center><h1>Nuestros Productos</h1></center>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach($resultProductos as $row) { ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <?php
                            $Id_Producto = $row['Id_Producto'];

                            $imagen = "imagenes/".$Id_Producto."/Principal.jpg";

                            if(!file_exists($imagen)){
                                $imagen = "imgproductos/no-disponible.jpg";
                            }
                            ?>
                            <center><img src="<?php echo $imagen ?>" alt="Imagen del Producto"></center>
                            
                            <div class="card-body">
                                <h5 class="card-title"><strong>Nombre:</strong> <?php echo $row['Nombre']; ?> </h5>
                                <p class="card-text"><strong>Precio:</strong> <?php echo $row['Precio']; ?> </p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                    <form action="Carrito.php" method="post">
                                        <input type="hidden" name="Id_Producto" value="<?php echo $row['Id_Producto']; ?>">
                                        <center><button type="submit" name="action" value="add" class="btn btn-primary">Comprar</button></center>
                                        </form>

                                    </div>
                                    <p class="card-text"><strong>Descripción:</strong> <?php echo $row['Descripcion']; ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>
