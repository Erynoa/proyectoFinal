<?php

    include("./conexion.php");

    extract($_POST);

    $validaNombreApellidos = "/^[A-ZÑÁÉÍÓÚ][a-zñáéíóú]*(s[A-ZÑÁÉÍÓÚ][a-zñáéíóú]*)*/";
    $validaCp = "/\d\d\d\d\d/";

    if(preg_match($validaNombreApellidos, $nombre) && preg_match($validaNombreApellidos, $apellidos) && preg_match($validaCp, $cp))
    {
        $sqlUpdateUsuario = "UPDATE usuarios ";
        $set = "SET nombre = '".$nombre."', apellidos = '".$apellidos."', direccion = '".$direccion."', provincia = '".$provincia."', localidad = '".$localidad."', cp = $cp, ";
        $set .= "pass = '".$password."' ";
        $where = "WHERE codUsuario = $codUsuario";

        $sqlUpdateUsuario .= $set;
        $sqlUpdateUsuario .= $where;
    
        $resultadoUpdate = mysqli_query($conexion, $sqlUpdateUsuario);	

        if($resultadoUpdate)
        {
            echo "bien";
        }
        else
        {
            echo "mal";
        }
    
    }
    else
    {
        echo "no";
    }



    
?>