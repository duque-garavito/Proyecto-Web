<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto</title>
    <link rel="stylesheet" href="css/homestyle.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <?php
    // Conexión y consulta
    @include "Conexion.php";

    $query = isset($_GET['query']) ? $_GET['query'] : '';

    if (!empty($query)) {
        $sql = "SELECT * FROM productos WHERE Nombre LIKE ? OR Descripcion LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $resultProductos = $stmt->get_result();
    } else {
        $sql = "SELECT * FROM productos";
        $resultProductos = mysqli_query($conn, $sql);
    }

    if (!$resultProductos) {
        die('Error en la consulta: ' . mysqli_error($conn));
    }
    ?>

    <!-- Main content -->
    <main>
        <div class="container">
            <center>
                <h1>
                    <?php echo !empty($query) ? "Resultados de la búsqueda: " . htmlspecialchars($query) : "Nuestros Productos"; ?>
                </h1>
            </center>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php if ($resultProductos->num_rows > 0) : ?>
                    <?php foreach ($resultProductos as $row) : ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <?php
                                $Id_Producto = $row['Id_Producto'];
                                $imagen = "imagenes/" . $Id_Producto . "/Principal.jpg";

                                if (!file_exists($imagen)) {
                                    $imagen = "imgproductos/no-disponible.jpg";
                                }
                                ?>
                                <center>
                                    <img src="<?php echo $imagen; ?>" alt="Imagen del Producto">
                                </center>
                                
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Nombre:</strong> <?php echo $row['Nombre']; ?></h5>
                                    <p class="card-text"><strong>Precio:</strong> <?php echo $row['Precio']; ?></p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <form action="Carrito.php" method="post">
                                                <input type="hidden" name="Id_Producto" value="<?php echo $row['Id_Producto']; ?>">
                                                <center><button type="submit" name="action" value="add" class="btn btn-primary">Comprar</button></center>

                                            </form>
                                        </div>
                                        <p class="card-text"><strong>Descripción:</strong> <?php echo $row['Descripcion']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <center><p>No se encontraron resultados para "<?php echo htmlspecialchars($query); ?>"</p></center>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            header.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Toggle menu visibility
        function toggleMenu() {
            const menu = document.getElementById("loginMenu");
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }

        // Close menu when clicking outside
        window.onclick = function(event) {
            const menu = document.getElementById("loginMenu");
            const button = document.getElementById("loginButton");
            if (!menu.contains(event.target) && event.target !== button) {
                menu.style.display = "none";
            }
        };
    </script>
</body>
</html>
