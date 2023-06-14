<?php

    include("./conexion.php");

    $datos = array();

    $datos["codUsuario"] = $_SESSION["usuario"]["codUsuario"];
    $datos["dni"] = $_SESSION["usuario"]["dni"];
    $datos["nombre"] = $_SESSION["usuario"]["nombre"];
    $datos["apellidos"] = $_SESSION["usuario"]["apellidos"];
    $datos["direccion"] = $_SESSION["usuario"]["direccion"];
    $datos["provincia"] = $_SESSION["usuario"]["provincia"];
    $datos["localidad"] = $_SESSION["usuario"]["localidad"];
    $datos["cp"] = $_SESSION["usuario"]["cp"];
    $datos["email"] = $_SESSION["usuario"]["email"];
    $datos["usuario"] = $_SESSION["usuario"]["usuario"];
    $datos["pass"] = $_SESSION["usuario"]["pass"];
    $datos["tipo"] = $_SESSION["usuario"]["tipo"];

    echo json_encode(array('datos'=> $datos));

?>