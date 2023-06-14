<?php

    include("./conexion.php");
    $codProductoEliminar = $_POST["codProd"];
    unset($_SESSION['carrito'][$codProductoEliminar]);
    
    header("Location:../html/carrito.html");

?>