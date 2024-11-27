<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros</title>
    <link rel="stylesheet" href="css/Nosotros.css">
</head>
<body>

<?php session_start(); ?>

<div class="content">
    <main class="container my-5">
        <h1 class="display-4">Nosotros</h1>

        <section class="row">
            <div class="col-md-5">
                <div class="card">
                    <h2>Misión</h2>
                    <p>
                        La Asociación de Artesanos de Catacaos, 
                        ubicada en el Departamento de Piura, 
                        Provincia de Piura y Distrito de Catacaos, 
                        tiene como misión promover y preservar el arte 
                        y la cultura artesanal de la región. 
                        Su objetivo es fomentar el desarrollo sostenible 
                        de los artesanos, mejorar sus condiciones de vida y 
                        facilitar el acceso a mercados para sus productos. 
                        A través de la capacitación, la innovación y la promoción de sus creaciones, 
                        buscan fortalecer la identidad cultural y generar un impacto positivo en la comunidad.
                    </p>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <h2>Visión</h2>
                    <p>
                        La Asociación de Artesanos de Catacaos aspira a ser reconocida 
                        a nivel nacional e internacional como un referente de la artesanía peruana de calidad. 
                        Su visión es construir un futuro donde los artesanos de la región puedan prosperar 
                        y sus productos sean valorados en los mercados globales, 
                        manteniendo siempre su esencia y tradición cultural.
                    </p>
                </div>
            </div>
        </section>
    </main>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
