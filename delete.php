<?php

include("config/conexion.php");
$con=conectar();

$Pro_cod=$_GET['id'];

$sql="DELETE FROM producto WHERE Pro_cod='$Pro_cod'";
$query=mysqli_query($con,$sql);

    if($query){
        Header("Location: index.php");
    }
?>
