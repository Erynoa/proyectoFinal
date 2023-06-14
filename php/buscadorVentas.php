<?php

    include("./conexion.php");

    $sqlBuscaVentas = "SELECT numPedido, cliente, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha";
    $from = " FROM pedidos";
    $where = " WHERE true";

    if(isset($_POST["fechaInicio"]))
    {
        $where .= " AND fecha >= '".$_POST["fechaInicio"]."'";
        $fechaInicio = $_POST["fechaInicio"];
    }

    if(isset($_POST["fechaFin"]))
    {
        $where .= " AND fecha <= '".$_POST["fechaFin"]."'";
        $fechaFin = $_POST["fechaFin"];
    }

    $sqlBuscaVentas .= $from;
    $sqlBuscaVentas .= $where;

    $resultadoBuscar = mysqli_query($conexion, $sqlBuscaVentas);
    $numRows = mysqli_num_rows($resultadoBuscar);

    if($numRows > 0)
    {
        while($fila = mysqli_fetch_assoc($resultadoBuscar))
        {
            extract($fila);

            $fechaPedido[$numPedido]["fecha"] = $fecha;

            $sqlBuscaLineas = "SELECT numLinea, codProducto, precio, cantidad";
            $fromLineas = " FROM lineas";
            $where = " WHERE numPedido = $numPedido";

            $sqlBuscaLineas .= $fromLineas;
            $sqlBuscaLineas .= $where;

            $resultadoBuscarLineas = mysqli_query($conexion, $sqlBuscaLineas);
            while($filaLineas = mysqli_fetch_assoc($resultadoBuscarLineas))
            {
                extract($filaLineas);
                $ventas[$numPedido][$numLinea]["codProducto"] = $codProducto;
                $ventas[$numPedido][$numLinea]["precio"] = $precio;
                $ventas[$numPedido][$numLinea]["cantidad"] = $cantidad;
                $ventas[$numPedido][$numLinea]["totalProducto"] = $precio * $cantidad;  
            }

        }

        $contenido = "";

        if(isset($fechaInicio) && isset($fechaFin))
        {
            $contenido .= '<a id="descargaPdf" href="../php/verPdfVentas.php?fechaInicio='.$fechaInicio.'&fechaFin='.$fechaFin.'" target="_blank" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Descargar listado ventas</a>';
        }
        else if(isset($fechaInicio) && !isset($fechaFin))
        {
            $contenido .= '<a id="descargaPdf" href="../php/verPdfVentas.php?fechaInicio='.$fechaInicio.'" target="_blank" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Descargar listado ventas</a>';
        }
        else if(!isset($fechaInicio) && isset($fechaFin))
        {
            $contenido .= '<a id="descargaPdf" href="../php/verPdfVentas.php?fechaFin='.$fechaFin.'" target="_blank" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Descargar listado ventas</a>';
        }
        
        $contenido .= "<table id='tablaPedidos' class='table table-bordered table-striped table-responsive' style='text-align: center; vertical-align: middle'>";
        $contenido .= "<thead><tr><th>Num. Pedido</th><th>Fecha</th><th>Información pedido</th><th>Total Pedido</th></tr></thead><tbody>";
        foreach($ventas as $pedido => $linea)
        {
            $contenido .= "<tr>";
            $contenido .= "<td>" . $pedido . "</td>";
            $contenido .= "<td>" . $fechaPedido[$pedido]["fecha"] . "</td><td>";
            $contenido .= "<div class='row'>";
            $contenido .= "<div class='col'><strong>Cod. Producto</strong></div>";
            $contenido .= "<div class='col'><strong>Denominación</strong></div>";
            $contenido .= "<div class='col'><strong>Precio</strong></div>";
            $contenido .= "<div class='col'><strong>Cantidad</strong></div>";
            $contenido .= "<div class='col'><strong>Total producto</strong></div>";
            $contenido .= "</div>";
            $totalPedido = 0;
            foreach($linea as $valor)
            {
                $contenido .= "<div class='row'>";
                $contenido .= "<div class='col'>".$valor["codProducto"]."</div>";
                $sqlNombreProd = "SELECT denominacionProd FROM productos WHERE codBarras = " . $valor["codProducto"];
                $resultadoNombre = mysqli_query($conexion, $sqlNombreProd);
                while($filaNombre = mysqli_fetch_assoc($resultadoNombre))
                {
                    $nombreBuscado = $filaNombre["denominacionProd"];
                }
                $contenido .= "<div class='col'>".$nombreBuscado."</div>";
                $contenido .= "<div class='col'>".$valor["precio"]."</div>";
                $contenido .= "<div class='col'>".$valor["cantidad"]."</div>";
                $contenido .= "<div class='col'>".$valor["totalProducto"]."</div>";

                $contenido .= "</div>";
                $totalPedido += $valor["totalProducto"];
            }
            $contenido .= "</td>";
            $contenido .= "<td>" . $totalPedido . " €</td>";
            $contenido .= "</tr>";
        }

        $contenido .= "</tbody></table>";
    }
    else
    {
        $contenido = "No existen pedidos para esa fecha";
    }

    echo json_encode(array("contenido" => $contenido));

?>