<?php

    include("./conexion.php");

    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];

    $selectCliente = "SELECT usuario, tipo FROM usuarios WHERE usuario = '".$usuario."'";

    $resultadoCliente = mysqli_query($conexion, $selectCliente);	
	while($fila = mysqli_fetch_assoc($resultadoCliente))
    {
        $tipo = $fila["tipo"];
        $user = $fila["usuario"];
    }

    $_SESSION['user'] = $user;

    if($tipo == "administrador")
    {
        $_SESSION['tipo'] = 'admin';
    }
    else
    {
        $_SESSION['tipo'] = 'cliente';
    }

    echo json_encode(array('tipo'=> $tipo));
?>