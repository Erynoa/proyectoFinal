<?php

    include("./conexion.php");


    $denominacion = $_POST["denominacion"];
    $descripcion = $_POST["descripcion"];
    $categoriaGen = $_POST["categoriaGen"];
    $categoriaDep = $_POST["categoriaDep"];
    $disponibilidad = $_POST["disponibilidad"];
    $stock = $_POST["stock"];
    $precio = $_POST["precio"];

    $sqlComprobar = "SELECT 1 FROM productos WHERE denominacionProd = '".$denominacion."'";
    $resultadoComprobar = mysqli_query($conexion, $sqlComprobar);
    $numRows = mysqli_num_rows($resultadoComprobar);

    if($numRows > 0)
    {
        // Existe ya un producto con ese nombre
        echo json_encode(array('resultado' => 3));
    }
    else
    {
        // No hay productos registrados con el nombre
        
        if($categoriaDep == 0)
        {
            $sqlInsert = "INSERT INTO productos (denominacionProd, descripcionProd, disponibilidad, categoria, stock, precio) VALUES ('".$denominacion."', '".$descripcion."', '".$disponibilidad."', $categoriaGen, $stock, $precio)";
        }
        else
        {
            $sqlInsert = "INSERT INTO productos (denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio) VALUES ('".$denominacion."', '".$descripcion."', '".$disponibilidad."', $categoriaGen, $categoriaDep, $stock, $precio)";
        }

        
        $resultadoInsert = mysqli_query($conexion, $sqlInsert);

        if($resultadoInsert)
        {
            echo json_encode(array('resultado'=> 1));
        }
        else
        {
            echo json_encode(array('resultado'=> 0));	
        }
    }
  
?>