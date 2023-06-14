<?php

    include("./conexion.php");

    $nombreCat = $_POST["nombreCat"];
    $descripcionCat = $_POST["descripcionCat"];
    $tipo = $_POST["tipo"];

    $sqlComprobar = "SELECT 1 FROM categorias WHERE nombreCat = '".$nombreCat."'";
    $resultadoComprobar = mysqli_query($conexion, $sqlComprobar);
    $numRows = mysqli_num_rows($resultadoComprobar);

    if($numRows > 0)
    {
        // Existe ya una categoría con ese nombre
        echo json_encode(array('resultado' => 3));
    }
    else
    {
        $sqlInsert = "INSERT INTO categorias (nombreCat, descripcionCat, tipo) VALUES ('".$nombreCat."', '".$descripcionCat."', '".$tipo."')";

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