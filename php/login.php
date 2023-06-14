<?php

    include("./conexion.php");

    
    if(isset($_POST['usuario']) && !empty($_POST['usuario']) && isset($_POST['pass']) && !empty($_POST['pass']))
    {
      $usuario = $_POST['usuario'];
      $pass = $_POST['pass'];
      $selectCliente = "SELECT codUsuario, dni, nombre, apellidos, direccion, provincia, localidad, cp, email, usuario, pass, tipo";
      $from = " FROM usuarios";
      $where = " WHERE usuario = '".$usuario."' AND pass = '".$pass."'";

      $selectCliente .= $from;
      $selectCliente .= $where;

      $resultadoCliente = mysqli_query($conexion, $selectCliente);	
      if($fila = mysqli_fetch_assoc($resultadoCliente))
      {	
        $_SESSION['usuario'] = $fila;

        echo json_encode(array('success'=> 1));		
      }
      else
      {
        echo json_encode(array('success'=> 0));
      }
    }
    else
    {
      echo json_encode(array('success' => 0));
    }
?>