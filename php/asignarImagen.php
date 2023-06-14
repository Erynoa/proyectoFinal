<?php
include("./conexion.php");
?>
<!DOCTYPE html>
    <html lang="es">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="author" content="Sandra Durán" />
		<meta
			name="description"
			content="página inicial tienda de artículos deportivos" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
			crossorigin="anonymous" />

		<link rel="stylesheet" href="../css/asignarImagen.css" />

		<link rel="icon" href="../img/logo.png" />
		<title>Modificar producto</title>
	</head>
    <body>
    <div class="container-fluid">

    <?php

    


    $cod = $_GET["cod"];
    if($_GET["redirigido"] == 1)
    {
        $redirigido = "producto";
        $botonRedirigido = '<a href="../html/gestionProductos.html" id="botonVolver" class="btn btn-primary active" role="button" aria-pressed="true">Volver a la gestión de productos</a>';
    }
    
    if($_GET["redirigido"] == 2)
    {
        $redirigido = "categoria";
        $botonRedirigido = '<a href="../html/gestionCategorias.html" id="botonVolver" class="btn btn-primary active" role="button" aria-pressed="true">Volver a la gestión de categorías</a>';
    }

    ?>
        <div id="divFormularioImagen">
        <h1>Asignación de imagen para el artículo</h1>
        <?php echo $botonRedirigido; ?>
        <p>Selecciona la imagen para el artículo: </p>
            <form enctype="multipart/form-data" name="formularioImagen" action="./grabarImagen.php" method="POST">
                <p>
                    <b>Selecciona la imagen:</b><br>
                    <input type="file" name="uploadfile"> <br>
                    <small><em>* Admite los formatos: GIF, JPG/JPEG and PNG.
                </p>
                <p>
                    <b>Título de la imagen:</b><br>
                    <input type="text" name="titulo" value="<?php echo $cod; ?>" readonly><br>
                    <small><em>* No editable. El título de la imagen es asignado por defecto.
                </p>
                <p>
                    <input class="btn btn-primary" type="submit" name="enviar" value="Grabar">
                </p>

                <input type="hidden" name="redirigido" value="<?php echo $redirigido; ?>">
            </form>
        </div>
    </div>
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
			crossorigin="anonymous"></script>

		<script
			src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
			integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
			crossorigin="anonymous"></script>

		
	</body>
</html>

