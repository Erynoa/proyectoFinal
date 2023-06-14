<?php 
	$tabla = "imagenes";

	include("./conexion.php");


	$redirigido = $_GET["redirigido"];
	$codImg = $_GET["codParaImg"];
	$codigoBuscar = "";
	
	if($redirigido == 3)
	{
		$codigoBuscar = "PROD" . $codImg;
	}
	
	if($redirigido == 2)
	{
		$codigoBuscar = "CAT" . $codImg;
	}

	$sqlBuscarImagen = "SELECT codImagen, nombreImg, fecha FROM imagenes WHERE codImagen = '" . $codigoBuscar . "'";
	$resultadoBusqueda = mysqli_query($conexion, $sqlBuscarImagen);

	if($resultadoBusqueda->num_rows == 0)
	{
		echo json_encode(array("imagen" => "noImg.png"));
	}
	else
	{
		while($fila = mysqli_fetch_assoc($resultadoBusqueda))
		{
			$imagenBuscada = $fila["nombreImg"];
		}

		echo json_encode(array("imagen" => $imagenBuscada));
	}

	

?>