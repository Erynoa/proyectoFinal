<?php

    include("./conexion.php");
    
    $_SESSION = array();
    $_SESSION["carrito"] = [];
    session_unset();
	session_destroy();

    header("Location: ../html/logout.html");
?>