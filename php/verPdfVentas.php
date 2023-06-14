<?php

    require('../fpdf/fpdf.php');
    include("./conexion.php");

    $pdf = new FPDF('P','mm','A4');

    $sqlBuscaVentas = "SELECT numPedido, cliente, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha";
    $from = " FROM pedidos";
    $where = " WHERE true";

    if(isset($_GET["fechaInicio"]))
    {
        $where .= " AND fecha >= '".$_GET["fechaInicio"]."'";
    }

    if(isset($_GET["fechaFin"]))
    {
        $where .= " AND fecha <= '".$_GET["fechaFin"]."'";
    }

    $sqlBuscaVentas .= $from;
    $sqlBuscaVentas .= $where;

    $resultadoBuscar = mysqli_query($conexion, $sqlBuscaVentas);
    $numRows = mysqli_num_rows($resultadoBuscar);

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
            $sqlNombreProd = "SELECT denominacionProd FROM productos WHERE codBarras = " . $codProducto;
            $resultadoNombre = mysqli_query($conexion, $sqlNombreProd);
            while($filaNombre = mysqli_fetch_assoc($resultadoNombre))
            {
                $nombreBuscado = $filaNombre["denominacionProd"];
            }
            $ventas[$numPedido][$numLinea]["denominacionProd"] = $nombreBuscado;
            $ventas[$numPedido][$numLinea]["precio"] = $precio;
            $ventas[$numPedido][$numLinea]["cantidad"] = $cantidad;
            $ventas[$numPedido][$numLinea]["totalProducto"] = $precio * $cantidad;  
        }

    }

    $pdf->AddPage();

    $pdf->Image("../img/logo.png",null,null,25,25, 'PNG');   
    $pdf->Cell(0, 8, '',0,'', 'C');
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0,10,utf8_decode("Ventas realizadas"),0,0);
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 10);


    foreach($ventas as $pedido => $linea)
    {
        $totalPedido = 0;
        $pdf->Cell(0 , 8, utf8_decode("Pedido nº: ".$pedido), 1, '', 'C');
        $pdf->Ln();
        $pdf->Cell(20 , 8, utf8_decode("Cod prod"), 0, '', 'C');
        $pdf->Cell(80 , 8, utf8_decode("Denominacion"), 0, '', 'C');
        $pdf->Cell(30 , 8, utf8_decode("Precio"), 0, '', 'C');
        $pdf->Cell(20 , 8, utf8_decode("cantidad"), 0, '', 'C');
        $pdf->Cell(0 , 8, utf8_decode("total producto"), 0, '', 'C');
        $pdf->Ln();
        foreach($linea as $valor)
        {
            $pdf->Cell(20 , 8, utf8_decode($valor["codProducto"]), 0, '', 'C');
            $pdf->Cell(80 , 8, utf8_decode($valor["denominacionProd"]), 0, '', 'C');
            $pdf->Cell(30 , 8, utf8_decode($valor["precio"]), 0, '', 'C');
            $pdf->Cell(20 , 8, utf8_decode($valor["cantidad"]), 0, '', 'C');
            $pdf->Cell(0 , 8, utf8_decode($valor["totalProducto"]), 0, '', 'C');
            $pdf->Ln();
            $totalPedido += $valor["totalProducto"];
        }
        $pdf->Cell(0 , 8, utf8_decode("Total pedido: ".$totalPedido), 1, '', 'C');
        $pdf->Cell(0 ,10,'',0,1);
        $pdf->Ln();
    }

    if(isset($_GET["fechaInicio"]) && !isset($_GET["fechaFin"]))
    {
        $nombrePdf = "VENTAS_POST_".$_GET["fechaInicio"]."'";
    }
    else if(!isset($_GET["fechaInicio"]) && isset($_GET["fechaFin"]))
    {
        $nombrePdf = "VENTAS_PRE_".$_GET["fechaFin"]."'";
    }
    else
    {
        $nombrePdf = "VENTAS_BTW_".$_GET["fechaInicio"]."&".$_GET["fechaFin"];
    }

    $pdf->Output('I', $nombrePdf, true);

?>