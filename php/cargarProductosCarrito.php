<?php

    include("./conexion.php");
    
    $codigosProductos = array_keys($_SESSION["carrito"]);
    if(!empty($codigosProductos))
    {
        $codigosImplode = implode(",", $codigosProductos);
        $sqlProductosCarrito = "SELECT * FROM productos WHERE codBarras in($codigosImplode)";
        $resultado = mysqli_query($conexion, $sqlProductosCarrito);
        $numRows = mysqli_num_rows($resultado);
        if($numRows == 0)
        {
            $productos = array();
        }
        else
        {
            $contador = 0;
            while($fila = mysqli_fetch_assoc($resultado))
            {
                extract($fila);
                $productos[$contador]["codBarras"] = $codBarras; 
                $productos[$contador]["denominacionProd"] = $denominacionProd; 
                $productos[$contador]["descripcionProd"] = $descripcionProd; 
                $productos[$contador]["unidades"] = $_SESSION["carrito"][$codBarras]["unidades"];
                $productos[$contador]["precio"] = $fila["precio"];
                $productos[$contador]["totalProducto"] = $_SESSION["carrito"][$codBarras]["unidades"] * $fila["precio"];
                $productos[$contador]["stock"] = $stock;
                $contador++;
            }
        
        }
    }
    else
    {
        $productos = array();
    }

    echo json_encode(array("productosCarrito" => $productos));

?>