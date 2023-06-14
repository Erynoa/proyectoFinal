<?php

    include("./conexion.php");

    if(isset($_POST["tipoEspecifico"]))
    {
      $tipo = $_POST["tipoEspecifico"];

      $categorias = array();

      $sql = "SELECT codCategoria, nombreCat, descripcionCat, tipo FROM categorias WHERE tipo = '".$tipo."'";
      $resultado = mysqli_query($conexion, $sql);
      while($fila = mysqli_fetch_assoc($resultado))
      {
        $categorias[] = $fila; 
      }

      echo json_encode(array("categorias" => $categorias));
    }


    // Buscar categorias según su tipo
    if(isset($_POST["tipo"]))
    {
      $tipo = $_POST["tipo"];

      $sql = "SELECT codCategoria, nombreCat, descripcionCat, tipo FROM categorias WHERE tipo = '".$tipo."'";
      $resultado = mysqli_query($conexion, $sql);

      $numRows = mysqli_num_rows($resultado);
      if($numRows == 0)
      {
        $categorias = "Seleccione una categoría.";
      }
      else
      {

        $categorias = "<br><h3>Categorías ";
        if($tipo == "gen")
        {
            $categorias .= "generales";
        }
        else
        {
            $categorias .= "deportivas";
        }
        $categorias .= "</h3><br>";

        $categorias .= "<table id='tablaCategorias' class='table table-bordered table-striped' style='text-align: center; vertical-align: middle'>";
        $categorias .= "<thead><tr><th>Código</th><th>Foto</th><th>Denominación</th><th>Descripción</th><th>Acciones</th></tr></thead><tbody>";
        
        while($fila = mysqli_fetch_assoc($resultado))
        {
            extract($fila);

            $categorias .= "<tr>";

            $categorias .= "<td>";
            $categorias .= $codCategoria;
            $categorias .= "</td>";

            $categorias .= "<td>";
            $categorias .= '<img src="../img/CAT'.$codCategoria.'.jpg" width=70 heigth=70>';
            $categorias .= "</td>";

            $categorias .= "<td>";
            $categorias .= $nombreCat;
            $categorias .= "</td>";

            $categorias .= "<td>";
            $categorias .= $descripcionCat;
            $categorias .= "</td>";

            $categorias .= "<td>";
            $categorias .= '<a id="botonAccionAnadir" href="../php/asignarImagen.php?cod=' . $codCategoria . '&redirigido=2" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"><img src="../img/agregar.png" width="40" height="40" ></a>';
            $categorias .= '<a id="botonAccionModificar" href="../php/modificarCategoria.php?codCat=' . $codCategoria . '" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"><img src="../img/editar.png" width="40" height="40" ></a>';
            $categorias .= '<a id="botonAccionBorrar" href="../php/eliminarCategoria.php?codCat=' . $codCategoria . '" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"><img src="../img/papelera.png" width="40" height="40" ></a>';
            $categorias .= "</td>";

            $categorias .= "</tr>";
          }

          $categorias .= "</tbody></table>";
      }

      echo json_encode(array("categorias" => $categorias));
    }

    // Buscar datos de una categoría según su código.
    if(isset($_POST["codigoCat"]))
    {
      $cod = $_POST["codigoCat"];

      $sql = "SELECT codCategoria, nombreCat, descripcionCat, tipo FROM categorias WHERE codCategoria = '".$cod."'";
      $resultado = mysqli_query($conexion, $sql);
      while($fila = mysqli_fetch_assoc($resultado))
      {
        $categoria = $fila; 
      }

      echo json_encode(array("categoria" => $categoria));
    }   

    if(isset($_POST["completo"]))
    {
      $sql = "SELECT codCategoria, nombreCat, descripcionCat, tipo FROM categorias";
      $resultado = mysqli_query($conexion, $sql);
      $resultado = mysqli_query($conexion, $sql);
      while($fila = mysqli_fetch_assoc($resultado))
      {
        $categorias[] = $fila; 
      }

      echo json_encode(array("categorias" => $categorias));
    } 
?>