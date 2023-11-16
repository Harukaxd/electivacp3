<?php

include("config/conexion.php");
$con=conectar();

$Pro_cod=$_POST['Pro_cod'];
$Nombre_prod=$_POST['Nombre_prod'];
$Precio_prod=$_POST['Precio_prod'];

$sql="UPDATE producto SET  Nombre_prod='$Nombre_prod',Precio_prod='$Precio_prod' WHERE Pro_cod='$Pro_cod'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: index.php");
    }
?>