<?php

    /*$servername = "localhost";
    $username = "root";
    $password = "";
    $basedatos = "dawsport";*/
    
    $servername = "localhost";
    $username = "id20911187_root";
    $password = "Dawsport13+";
    $basedatos = "id20911187_dawsport";

    $conexion = mysqli_connect($servername, $username, $password, $basedatos);
    $conexion->set_charset("utf8");

    session_start();

?>