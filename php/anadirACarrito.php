<?php

    include("./conexion.php");

    $codProd = $_POST["codigoProducto"];
	$precio = $_POST["precioProducto"];
	$unidades = (int)$_POST["unidadesProducto"];

    if(isset($_SESSION["carrito"][$codProd]))
    {
        $_SESSION["carrito"][$codProd]["unidades"] += $unidades;
    }
    else
    {
        $_SESSION["carrito"][$codProd]["unidades"] = $unidades;
		$_SESSION["carrito"][$codProd]["precio"] = $precio;
    }

    header("Location:../html/categorias.html");

?>