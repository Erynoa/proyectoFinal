<?php

    require('../fpdf/fpdf.php');
    include("./conexion.php");

    $pdf = new FPDF('P','mm','A4');

    $codCat = $_GET["categoria"];

    $sqlBuscar = "SELECT codBarras, denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio";
    $from = " FROM productos";

    if($codCat == 0)
    {
        $where = " WHERE true";
    }
    else
    {
        $where = " WHERE categoria = $codCat OR categoriaDepor = $codCat";
    }

    

    $sqlBuscar .= $from;
    $sqlBuscar .= $where;


    $resultado = mysqli_query($conexion, $sqlBuscar);
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
            $productos[$contador]["codBarras"] = $fila["codBarras"]; 
            $productos[$contador]["denominacionProd"] = $fila["denominacionProd"]; 
            $productos[$contador]["descripcionProd"] = $fila["descripcionProd"]; 
            $productos[$contador]["disponibilidad"] = $fila["disponibilidad"]; 
            $productos[$contador]["categoria"] = $fila["categoria"]; 
            $productos[$contador]["categoriaDepor"] = $fila["categoriaDepor"]; 
            $productos[$contador]["stock"] = $fila["stock"]; 
            $productos[$contador]["precio"] = $fila["precio"];

            $contador++;
        }

        foreach($productos as $numFila => $contenidoFila)
        {
            foreach($contenidoFila as $nombreColumna=>$contenido)
            {
                if($nombreColumna == "categoria" || $nombreColumna == "categoriaDepor")
                {
                    if($contenido != null)
                    {
                        $sqlBuscaCat = "SELECT nombreCat FROM categorias WHERE codCategoria = $contenido";
                        $resultadoCat = mysqli_query($conexion, $sqlBuscaCat);

                        while($filaCat = mysqli_fetch_assoc($resultadoCat))
                        {
                            $nombreBuscado = $filaCat["nombreCat"]; 
                        }

                        if($nombreColumna == "categoria")
                        {
                            $productos[$numFila]["categoria"] = $nombreBuscado;
                        }
                        else
                        {
                            $productos[$numFila]["categoriaDepor"] = $nombreBuscado;
                        }
                    }
                    else
                    {
                        $productos[$numFila]["categoriaDepor"] = "No asignada";
                    }
                    
                }
            }
        }
    }

    $sqlBuscaNombreCat = "SELECT nombreCat FROM categorias WHERE codCategoria = $codCat";
    $resultadoCat = mysqli_query($conexion, $sqlBuscaNombreCat);

    while($filaCat = mysqli_fetch_assoc($resultadoCat))
    {
        $nombreBuscado = $filaCat["nombreCat"]; 
    }

    if($codCat == 0)
    {
        $nombreBuscado = " Todas";
    }

    /*Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
    
    w: ancho celda
    h: alto celda
    txt: Texto - por defecto es una cadena vacía
    border: 0 - sin borde | 1 - marco
            o una cadena que contenga una o una combinación de los siguientes caracteres (en cualquier orden):
            L: izquierda
            T: superior
            R: derecha
            B: inferior
            Valor por defecto: 0.
    ln: Indica donde la posición actula debería ir antes de invocar. Los valores posibles son:
        0: a la derecha
        1: al comienzo de la siguiente línea
        2: debajo

    align: Permite centrar o alinear el texto. Los posibles valores son:
        L o una cadena vacia: alineación izquierda (valor por defecto)
        C: centro
        R: alineación derecha

    fill: Indica si elfondo de la celda debe ser dibujada (true) o transparente (false). Valor por defecto: false.
    link: URL o identificador retornado por AddLink().
    */

    $pdf->AddPage();

    $pdf->Image("../img/logo.png",null,null,25,25, 'PNG');   
    $pdf->Cell(0, 8, '',0,'', 'C');
    $pdf->Ln();
    
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(71 ,10,'',0,0);
	$pdf->Cell(59 ,5,utf8_decode('Productos de la categoría: ' . $nombreBuscado),0,0);
	$pdf->Cell(59 ,10,'',0,1);

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0 ,10,'',0,1);

    foreach($productos as $numFila => $contenidoFila)
    {
        $pdf->Cell(50 , 8, utf8_decode("Código: ".$contenidoFila["codBarras"]), 1, '', 'C');
        $pdf->Cell(0 , 8, utf8_decode("Denominación: ".$contenidoFila["denominacionProd"]), 1, '', 'C');
        $pdf->Ln();
        $pdf->MultiCell(0 , 8, utf8_decode("Descripción: \n".$contenidoFila["descripcionProd"]), 1, 'L');
        if($contenidoFila["disponibilidad"] == "s")
        {
            $pdf->Cell(50 , 8, utf8_decode("Disponibilidad: Sí"), 1, '', 'C');
        }
        else
        {
            $pdf->Cell(50 , 8, utf8_decode("Disponibilidad: No"), 1, '', 'C');
        }
        
        $pdf->Cell(26 , 8, utf8_decode('Stock: '. $contenidoFila["stock"]), 1, '', 'C');
        $pdf->Cell(26 , 8, utf8_decode('Precio: '. $contenidoFila["precio"]), 1, '', 'C');
        $pdf->Cell(40 , 8, utf8_decode('Cat.General: '. $contenidoFila["categoria"]), 1, '', 'C');
        $pdf->Cell(0 , 8, utf8_decode('Cat. Deportiva: '. $contenidoFila["categoriaDepor"]), 1, '', 'C');
        $pdf->Cell(0 ,10,'',0,1);
        $pdf->Ln();

    }

    $pdf->Output('I', 'Productos de la categoría: ' . $nombreBuscado, true);

?>