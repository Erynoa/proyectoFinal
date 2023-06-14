<?php

    include("./conexion.php");
    $_SESSION["carrito"] = [];

    header("Location: ../html/carrito.html");

?>