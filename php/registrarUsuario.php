<?php

    include("./conexion.php");

    
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $provincia = $_POST['provincia'];
    $localidad = $_POST['localidad'];
    $cp = $_POST['cp'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];

    
    $sqlInsert = "INSERT INTO usuarios (dni, nombre, apellidos, direccion, provincia, localidad, cp, email, usuario, pass, tipo) VALUES ('".$dni."', '".$nombre."','".$apellidos."','".$direccion."','".$provincia."','".$localidad."',".$cp.",'".$email."','".$usuario."','".$pass."','cliente')";
    $resultadoInsert = mysqli_query($conexion, $sqlInsert);

    if($resultadoInsert)
    {
        
        $selectCliente = "SELECT codUsuario, dni, nombre, apellidos, direccion, provincia, localidad, cp, email, usuario, pass, tipo FROM usuarios WHERE usuario = '".$usuario."' AND pass = '".$pass."'";
        $resultadoCliente = mysqli_query($conexion, $selectCliente);
        if($fila = mysqli_fetch_assoc($resultadoCliente))
        {	
            $_SESSION['usuario'] = $fila;
            $_SESSION['tipo'] = 'cliente';
            
            echo json_encode(array('resultado'=> 1));
        }	
    }
    else
    {
        echo json_encode(array('resultado'=> 0));	
    }
    
?>