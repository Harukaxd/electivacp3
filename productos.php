<?php
include('config/conexion.php');
$con = conectar();

$sql = "SELECT *  FROM producto";
$query = mysqli_query($con, $sql);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header data-bs-theme="dark">
        <div class="collapse text-bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2"
                        viewBox="0 0 24 24">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                    <strong>Tienda Nico</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Ropa</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Contactanos</a>
                        </li>
                        <li class="nav-item">
                            <a href>Nicolas Agudelo Gómez - ID: 695076</h2>
                        </li>
                    </ul>
                </div>
    </header>
    <main>
        <div class="container">
            <div class="container mt-5">
                <div class="row">

                    <div class="col-md-3">
                        <h1>Productos</h1>
                        <form action="insertar.php" method="POST">

                            <input type="text" class="form-control mb-3" name="Nombre_prod"
                                placeholder="Nombre del producto">
                            <input type="text" class="form-control mb-3" name="Precio_prod"
                                placeholder="Precio del producto">
                            <input type="text" class="form-control mb-3" name="Stock_prod" placeholder="Cantidad">
                            <input type="text" class="form-control mb-3" name="Desc_prod"
                                placeholder="Detalles/descripción">

                            <input type="submit" class="btn btn-primary">

                        </form>
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <thead class="table-success table-striped">
                                <tr>
                                    <th>ID Producto</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <th>
                                            <?php echo $row['Pro_cod'] ?>
                                        </th>
                                        <th>
                                            <?php echo $row['Nombre_prod'] ?>
                                        </th>
                                        <th>
                                            <?php echo $row['Precio_prod'] ?>
                                        </th>
                                        <th>
                                            <?php echo $row['Stock_prod'] ?>
                                        </th>
                                        <th>
                                            <?php echo $row['Desc_prod'] ?>
                                        </th>
                                        <th><a href="actualizar.php?id=<?php echo $row['Pro_cod'] ?>"
                                                class="btn btn-info">Editar</a></th>
                                        <th><a href="delete.php?id=<?php echo $row['Pro_cod'] ?>"
                                                class="btn btn-danger">Eliminar</a></th>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>

</body>

</html>