<?php

    include("./conexion.php");

    $carrito = $_SESSION["carrito"];

    function conseguirDatosDeCarrito($carrito, $conexion)
    {
        $codigosProductos = array_keys($_SESSION["carrito"]);
        $codigosImplode = implode(",", $codigosProductos);

        $sqlProductosCarrito = "SELECT * FROM productos WHERE codBarras in($codigosImplode)";

        $resultado = mysqli_query($conexion, $sqlProductosCarrito);

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

            $contador++;
        }

        return $productos;
    }

    function crearCorreo($carrito, $correo, $conexion)
    {

        $tema= "Pedido almacenado";
		$headers = array();
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset="utf-8"' ;
		$headers[] ='Content-Transfer-Encoding: 7bit' ;
		$headers[]= 'From: dawsport.gg.com';
		$texto="<h3>Pedido del cliente: $correo</h3>";
		
        $productos = conseguirDatosDeCarrito($carrito, $conexion);
 
        $totalCompra = 0;
		$texto .= "<table border='1'><tr><th>Denominación</th><th>Unidades</th><th>Precio Uni.</th><th>Total Prod.</th></tr>";
		foreach($productos as $contenido)
        {
           /* echo "<pre>";
            print_r($contenido);
            echo "</pre>";*/
            $texto .= "<tr>";
            $texto .= "<td align='center'>".$contenido["denominacionProd"]."</td>";
            $texto .= "<td align='center'>".$contenido["unidades"]."</td>";
            $texto .= "<td align='center'>".$contenido["precio"]."</td>";
            $texto .= "<td align='center'>".$contenido["totalProducto"]."</td>";
            $texto .= "</tr>";

            $totalCompra += $contenido["totalProducto"];
            
        }

        $texto .= "<tr><td colspan=4 align='right'>TOTAL: " . $totalCompra . "</td></tr>";
        $texto.="</table>";
        mail($correo, $tema, $texto, join("\r\n", $headers));
        return $texto; 
    }

    if(!isset($_SESSION["usuario"]))
    {
        // Si no se ha registrado como usuario, hay que pedirle que lo haga
        header("Location: ../html/login.html?redirigido=1");
    }
    else
    {
        $codUsuario = $_SESSION["usuario"]["codUsuario"];
        $fecha = date("Y-m-d H:i:s", time());

        $sqlInserta = "INSERT INTO pedidos (cliente, fecha) VALUES ($codUsuario, '".$fecha."')";
        $resultadoInsert = mysqli_query($conexion, $sqlInserta);
        
        if($resultadoInsert)
        {
            // Buscar el último id de la tabla pedidos.
            $sqlNumPedido = "SELECT MAX(numPedido) as numPedido FROM pedidos";
            $resultadoBuscar = mysqli_query($conexion, $sqlNumPedido);

            while($fila = mysqli_fetch_assoc($resultadoBuscar))
            {
                $numPedido = $fila["numPedido"];
            }

            $productosCarrito = conseguirDatosDeCarrito($carrito, $conexion);
            foreach($productosCarrito as $contenido)
            {
                $cantidad = $contenido["unidades"];
                $precio = $contenido["precio"];
                $codProd = $contenido["codBarras"];

                $sqlInsertLineas = "INSERT INTO lineas (numPedido, codProducto, precio, cantidad) VALUES ($numPedido, $codProd, $precio, $cantidad)";
                $resultadoInsertLineas = mysqli_query($conexion, $sqlInsertLineas);

                // Actualizar la tabla de los productos con el nuevo stock
                $sqlBuscarStock = "SELECT stock FROM productos WHERE codBarras = $codProd";
                $resultadoBuscarStock = mysqli_query($conexion, $sqlBuscarStock); 
                while($filaStock = $resultadoBuscarStock->fetch_assoc())
                {
                    $stockPreVenta = $filaStock["stock"];
                }

                $stockPostVenta = $stockPreVenta - $cantidad;

                $sqlUpdateStock = "UPDATE productos";
                $set = " SET stock = $stockPostVenta";
                if($stockPostVenta == 0)
                {
                    $set .= ", disponibilidad = 'n'";
                }
                
                $where = " WHERE codBarras = $codProd";

                $sqlUpdateStock .= $set;
                $sqlUpdateStock .= $where;

		        $resultadoBuscarStock = mysqli_query($conexion,$sqlUpdateStock);
            }
            
            $subject = crearCorreo($_SESSION["carrito"], $_SESSION["usuario"]["email"], $conexion);
            //$_SESSION["realizado"] = "Pedido nº ".$resul." almacenado correctamente";
            $_SESSION["hecho"] = $subject;

            header("Location: ../html/confirmacionCompra.html");
        }
        else
        {
            $_SESSION["realizado"] = "No se ha podido realizar el pedido<br>";
        }

        $_SESSION['carrito'] = [];

        
    }

?>