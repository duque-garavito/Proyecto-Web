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

    <header>
        <a href="Index.php" class="nombre"><img src="imagenes/LOGO.png" class="Logo">Artesanias Catacaos</a>
        <nav class="nav">
            <ul class="dropdowns">
                <li><a href="Index.php" class="menu">Inicio</a></li>
                <li><a href="Nosotros.php" class="menu">Nosotros</a></li>
                <li><a href="Contactanos.php" class="menu">Contáctanos</a></li>
                <li><a href="Seguimiento.php" class="menu">Mis pedidos</a></li>
                <form class="busqueda" role="search" action="buscar.php" method="GET">
                  <div class="search-container">
                <i class='bx bx-search'></i>
                 <input class="form-control me-2" type="search" placeholder="Buscar" name="query" aria-label="Search">
                </div>
              </form>
     
                <a href="Carrito.php"><i class='bx bx-cart' id="cart"></i></a>
                <div class="login-container">
                 <button id="loginButton" onclick="window.location.href='Login.php'">Iniciar Sesión</button>
              </div>
                <div>
                    <form action="CerrarSesion.php" method="post">
                    <button type="submit" id="loutButton">Cerrar Sesión</button>
                    </form>
                </div>
                
            </ul>
        </nav>
    </header>

    <script>
        
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            header.classList.toggle('scrolled', window.scrollY > 50);
        });
        
        function toggleMenu() {
    const menu = document.getElementById("loginMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

window.onclick = function(event) {
    const menu = document.getElementById("loginMenu");
    const button = document.getElementById("loginButton");
    if (!menu.contains(event.target) && event.target !== button) {
        menu.style.display = "none";
    }
};


    </script>