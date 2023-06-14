<?php
    include("./conexion.php");


    $errores = array();

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

    $buscaDNI = "SELECT codUsuario FROM usuarios WHERE dni = '".$dni."'";
    $resultadoDNI = mysqli_query($conexion, $buscaDNI);
    if($filaDNI = mysqli_fetch_assoc($resultadoDNI))
    {
        $errores[] = "El DNI ya está registrado.";
    }
    
    $buscaEmail = "SELECT codUsuario FROM usuarios WHERE email = '".$email."'";
    $resultadoEmail = mysqli_query($conexion, $buscaEmail);
    if($filaEmail = mysqli_fetch_assoc($resultadoEmail))
    {
        $errores[] = "El email ya está registrado.";
    }

    $buscaUsuario = "SELECT codUsuario FROM usuarios WHERE usuario = '".$usuario."'";
    $resultadoUsuario = mysqli_query($conexion, $buscaUsuario);
    if($filaUsuario = mysqli_fetch_assoc($resultadoUsuario))
    {
        $errores[] = "El usuario ya está registrado.";
    }

    echo json_encode(array('erroresReg' => $errores));

?>