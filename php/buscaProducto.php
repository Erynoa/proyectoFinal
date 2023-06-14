<?php

    include("./conexion.php");

    $codProd = $_POST["codigoProducto"];

    $sqlBuscar = "SELECT codBarras, denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio ";
    $from = "FROM productos ";
    $where = "WHERE codBarras = $codProd";

    $sqlBuscar .= $from;
    $sqlBuscar .= $where;

    $resultado = mysqli_query($conexion, $sqlBuscar);

    while($fila = mysqli_fetch_assoc($resultado))
    {
        $producto = $fila;
    }

    echo json_encode(array("producto" => $producto));

?>