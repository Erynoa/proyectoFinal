<?php

    include("./conexion.php");
    $codigoProd = $_POST["codigoProd"];

    $_SESSION["carrito"][$codigoProd]["unidades"] = $_POST["nuevasUnidades"];

?>