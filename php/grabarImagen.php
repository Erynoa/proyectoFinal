<?php

    include("./conexion.php");


    $directorio = "img"; // Carpeta en la que se guardan las imágenes dentro del proyecto.

    if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK)
    {
        switch ($_FILES['uploadfile']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            die('El tamaño del archivo excede el permitido por la directiva upload_max_filesize establecida en php.ini. ' );
            break;
        case UPLOAD_ERR_FORM_SIZE:
            die('El tamaño  del archivo cargado excede el permitido por la directiva  MAX_FILE_SIZE establecida en  el formulario HTML.');
            break;
        case UPLOAD_ERR_PARTIAL:
            die('El archivo se ha cargado parcialmente ');
            break;
        case UPLOAD_ERR_NO_FILE:
            die('No ha cargado ningún archivo');
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            die('No se encuentra el directorio temporal del servidor ');
            break;
        case UPLOAD_ERR_CANT_WRITE:
            die('El servidor ha fallado al intentar escribir el archivo en el disco');
            break;
        case UPLOAD_ERR_EXTENSION:
            die('Subida detenida por la extensión');
            break;
        }
    }


    if($_POST["redirigido"] == "producto")
    {
        $img_titulo = "PROD" . $_POST["titulo"];
    }

    if($_POST["redirigido"] == "categoria")
    {
        $img_titulo = "CAT" . $_POST["titulo"];
    }

    
    
    $img_fecha = @date('Y-m-d');
    list($width, $height, $type, $attr) = getimagesize($_FILES['uploadfile']['tmp_name']);
    $error = "El archivo no es del tipo soportado";
    switch ($type) {
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or die($error);
            $ext = ".gif";
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or die($error);
            $ext = ".jpg";
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or die($error);
            $ext = ".png";
            break;
        default:
            die($error);
    }

    $img_nombre = $img_titulo . ".jpg";

    $sqlBuscarImagen = "SELECT codImagen FROM imagenes WHERE codImagen = '".$img_titulo."'";
    $resultadoBusqueda = mysqli_query($conexion, $sqlBuscarImagen);

	if($resultadoBusqueda->num_rows == 0)
	{
        $sqlGrabarImg = "INSERT INTO imagenes (codImagen, nombreImg, fecha) VALUES ('".$img_titulo."', '".$img_nombre."', '".$img_fecha."')";  
    }
    else
    {
        $sqlGrabarImg = "UPDATE imagenes SET nombreImg = '".$img_nombre."', fecha = '".$img_fecha."' WHERE codImagen = '".$img_titulo."'";
    }

    $resultadoGrabar = mysqli_query($conexion, $sqlGrabarImg);

    switch ($type) {
        case IMAGETYPE_GIF:
            imagegif($image, "../" . $directorio.'/'.$img_nombre);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($image, "../" . $directorio.'/'.$img_nombre,100);
            break;
        case IMAGETYPE_PNG:
            imagepng($image, "../" . $directorio.'/'.$img_nombre);
            break;  
        }

    imagedestroy($image);   
    
    if($_POST["redirigido"] == "producto")
    {
        header("Location: ../html/gestionProductos.html");
    }

    if($_POST["redirigido"] == "categoria")
    {
        header("Location: ../html/gestionCategorias.html");
    }
?>