<?php

    require('../fpdf/fpdf.php');
    include("./conexion.php");

    $pdf = new FPDF('P','mm','A4');

    $numPedido = $_GET["numPedido"];

    $sqlFecha = "SELECT DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM pedidos WHERE numPedido = $numPedido";
    $resultadoFecha = mysqli_query($conexion, $sqlFecha);
    while($filaFecha = mysqli_fetch_assoc($resultadoFecha))
    {
        $fechaPedido = $filaFecha["fecha"];
    }

    $sqlBuscaLineas = "SELECT lineas.numLinea as numLinea, lineas.numPedido as numPedido, lineas.codProducto as codProducto, denominacionProd, ";
    $sqlBuscaLineas .= "lineas.precio as precio, lineas.cantidad as cantidad FROM lineas";
    $sqlBuscaLineas .= " INNER JOIN productos ON lineas.codProducto = productos.codBarras";
    $sqlBuscaLineas .= " WHERE lineas.numPedido = $numPedido";

    $resultado = mysqli_query($conexion, $sqlBuscaLineas);

    $pdf->AddPage();

    $pdf->Image("../img/logo.png",null,null,25,25, 'PNG');   
    $pdf->Cell(0, 8, '',0,'', 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0,10,utf8_decode('Detalles del pedido nº: ' . $numPedido),0,0);
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 15);

    $pdf->Cell(0, 15, utf8_decode('Fecha de compra: ' . $fechaPedido),0,0);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 8, utf8_decode('Artículos'),1,'', 'C');
    $pdf->Ln();
    $pdf->Cell(137 , 8, utf8_decode('Denominación'), 0, '', ' ');
    $pdf->Cell(26 , 8, utf8_decode('Unidades'), 0, '', 'C');
    $pdf->Cell(0 , 8, utf8_decode('Precio uni.'), 0, '', 'C');
    $pdf->Ln();
    $totalCompra = 0;
    while($fila = mysqli_fetch_assoc($resultado))
    {
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(137 , 8, utf8_decode($fila["denominacionProd"]), 0, '', ' ');
        $pdf->Cell(26 , 8, utf8_decode($fila["cantidad"]), 0, '', 'C');
        $pdf->Cell(0 , 8, utf8_decode($fila["precio"]), 0, '', 'C');
        $pdf->Ln();

        $totalCompra += $fila["cantidad"] * $fila["precio"];
    }
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 8, utf8_decode('Total de la compra: ' . $totalCompra),1,'', '');

    $pdf->Output('I', 'Pedido nº: ' . $numPedido, true);

?>