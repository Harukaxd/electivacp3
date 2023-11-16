<?php 
    include("config/conexion.php");
    $con=conectar();

    $sql="SELECT * FROM usuario";
    $query=mysqli_query($con,$sql);
?>
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
    <div class="container mt-5">
        <div class="row">

            <div class="col-md-3">
                <h1>Registrate</h1>
                <form action="insertar.php" method="POST">

                    <input type="text" class="form-control mb-3" name="Usu_cod" placeholder="ID">
                    <input type="text" class="form-control mb-3" name="Usuario" placeholder="Usuario">
                    <input type="text" class="form-control mb-3" name="Contraseña" placeholder="Contraseña">

                    <input type="submit" class="btn btn-primary">
                </form>
            </div>

            <div class="col-md-8">
                <table class="table">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <th>
                                    <?php echo $row['Usu_cod'] ?>
                                </th>
                                <th>
                                    <?php echo $row['Usuario'] ?>
                                </th>
                                <th>
                                    <?php echo $row['Contraseña'] ?>
                                </th>
                                <th><a href="actualizar.php?id=<?php echo $row['Usu_cod'] ?>"
                                        class="btn btn-info">Editar</a></th>
                                <th><a href="delete.php?id=<?php echo $row['Usu_cod'] ?>"
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
    <main>
    </main>
</body>


</html>