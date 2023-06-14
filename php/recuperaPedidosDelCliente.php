<?php

    include("./conexion.php");

    $codUsuario = $_SESSION["usuario"]["codUsuario"];

    $sqlBuscaPedidos = "SELECT numPedido, cliente, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM pedidos WHERE cliente = $codUsuario";

    $resultadoBuscaPedidos = mysqli_query($conexion, $sqlBuscaPedidos);
    $numRows = mysqli_num_rows($resultadoBuscaPedidos);
    if($numRows == 0)
    {
        $pedidos = "<p>No se han realizado compras</p>";
    }
    else
    {
        $pedidos = "<h1>Pedidos</h1>";
        $pedidos .= "<table id='tablaCompras' class='table table-bordered table-striped' style='text-align: center; vertical-align: middle'>";
        $pedidos .= "<thead><tr><th>Nº pedido</th><th>Fecha</th><th>Artículos</th><th>Total pedido</th><th>Descargar ticket</th></tr></thead>";
        $contador = 0;
        while($fila = mysqli_fetch_assoc($resultadoBuscaPedidos))
        {
            $totalCompra = 0;
            extract($fila);

            $pedidos .= "<tr>";
            $pedidos .= "<td>" . $numPedido . "</td>";
            $pedidos .= "<td>" . $fecha . "</td>";
            
            $sqlBuscaLineas = "SELECT numLinea, numPedido, codProducto, denominacionProd, lineas.precio as precio, cantidad FROM lineas";
            $sqlBuscaLineas .= " INNER JOIN productos ON lineas.codProducto = productos.codBarras";
            $sqlBuscaLineas .= " WHERE numPedido = $numPedido";
            $resultadoBuscaLineas = mysqli_query($conexion, $sqlBuscaLineas);
            if($resultadoBuscaLineas)
            {
                $pedidos .= "<td>";

                $pedidos .= "<div class='row'>";
                    $pedidos .= "<div class='col-6'>";
                    $pedidos .= "<p><strong>Denominación</strong></p>";
                    $pedidos .= "</div>";

                    $pedidos .= "<div class='col-6'>";
                    $pedidos .= "<p><strong>Precio uni.</strong></p>";
                    $pedidos .= "</div>";
                $pedidos .= "</div>";

                while($filaLineas = mysqli_fetch_assoc($resultadoBuscaLineas))
                {   
                    extract($filaLineas);
                    $pedidos .= "<div class='row'>";
                        $pedidos .= "<div class='col-6'>";
                        $pedidos .= $denominacionProd . " <strong>x " . $cantidad . "</strong><br>";
                        $pedidos .= "</div>";

                        $pedidos .= "<div class='col-6'>";
                        $pedidos .= $precio . " €<br>";
                        $pedidos .= "</div>";
                    $pedidos .= "</div>";

                    $totalCompra += $precio * $cantidad;
                }

                $pedidos .= "</td>"; 
            }
            
            $pedidos .= "<td>" . $totalCompra . " €</td>";
            $pedidos .= '<td><a id="botonPdf" href="../php/verPdfPedidoCliente.php?numPedido=' . $numPedido . '" target="_blank" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"><img src="../img/pdf.png" width="40" height="40"></a></td>';
            $pedidos .= "</tr>";
        }

        $pedidos .= "</tbody></table>"; 

        echo json_encode(array("pedidos" => $pedidos));
    }


?>