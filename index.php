<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT Pro_cod, Nombre_prod, Precio_prod, Desc_prod FROM producto");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

//print_r($_SESSION);
session_destroy();

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
                    <a href="productos.php" class="btn btn-primary me-2">
                        Productos <id="num_cart" class="badge bg-secondary">
                    </a>
                    <a href="carrito.php" class="btn btn-primary me-2">
                        Carrito <span id="num_cart" class="badge bg-secondary">
                            <?php echo $num_cart; ?>
                        </span>
                    </a>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="#" class="btn btn-success"><i class="fas fa-user"></i>
                            <?php echo $_SESSION['user_name']; ?>
                        </a>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-success"><i class="fas fa-user"></i>
                            Ingresar </a>
                    <?php } ?>
                </div>
    </header>
    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($resultado as $row) { ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <?php
                            $id = $row['Pro_cod'];
                            $imagen = "imagenes/Productos/" . $id . "/principal.jpg";
                            if (!file_exists($imagen)) {
                                $imagen = "imagenes/no-photo.jpg";
                            }
                            ?>
                            <img src="<?php echo $imagen; ?>" class="d-block w-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $row['Nombre_prod']; ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo number_format($row['Precio_prod'], 2, '.', ','); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="detalles.php?Pro_cod=<?php echo $row['Pro_cod']; ?>&token=<?php echo hash_hmac('sha1', $row['Pro_cod'], KEY_TOKEN); ?>"
                                            class="btn btn-primary">Detalles</a>
                                    </div>
                                    <button class="btn btn-outline-success" type="button"
                                        onclick="addProducto(<?php echo $row['Pro_cod']; ?>, '<?php echo hash_hmac('sha1', $row['Pro_cod'], KEY_TOKEN); ?>')">Agregar
                                        al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        function addProducto(id, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('Pro_cod', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>
</body>

</html>