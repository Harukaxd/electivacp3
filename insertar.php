<!DOCTYPE html>
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
    <main>
        <div class="container">
            <?php
            include("config/conexion.php");
            $con = conectar();

            $Pro_cod = $_POST['Pro_cod'];
            $Nombre_prod = $_POST['Nombre_prod'];
            $Precio_prod = $_POST['Precio_prod'];
            $Stock_prod = $_POST['Stock_prod'];
            $Desc_prod = $_POST['Desc_prod'];


            $sql = "INSERT INTO producto VALUES('$Pro_cod','$Nombre_prod','$Precio_prod','$Stock_prod','$Desc_prod')";
            $query = mysqli_query($con, $sql);

            if ($query) {
                Header("Location: productos.php");

            } else {
            }
            ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
        </div>
    </main>
</body>


</html>