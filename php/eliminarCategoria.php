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
			content="página para eliminar categorías" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
			crossorigin="anonymous" />

		<link rel="stylesheet" href="../css/modificarProducto.css" />

		<link rel="icon" href="../img/logo.png" />
		<title>Eliminar categoría</title>
	</head>
    <body>
        <div class="container-fluid">

<?php

    extract($_GET);
    
    if(!isset($_POST["eliminar"]))
    {
        $sqlBuscarCat = "SELECT codCategoria, nombreCat, descripcionCat, tipo ";
        $from = "FROM categorias ";
        $where = "WHERE codCategoria = $codCat";

        $sqlBuscarCat .= $from;
        $sqlBuscarCat .= $where;

        $resultado = mysqli_query($conexion, $sqlBuscarCat);

        while($fila = mysqli_fetch_assoc($resultado))
        {
?>
            
            <div id="formularioDelete">
            <h1>Eliminar categoría</h1>
            <a href="../html/gestionCategorias.html" id="botonVolver" class="btn btn-primary active" role="button" aria-pressed="true">Volver a la gestión de categorías</a>
            
                <form id="formularioDel" name="formularioDel" method="POST" action="#">
                <h3>¿Desea eliminar la siguiente categoría?</h3>    
                <div class="mb-3">
						<label for="denominacion" class="form-label">Denominación:</label>
						<input
							type="text"
							class="form-control"
							id="denominacion"
							name="denominacion"
                            value="<?php echo $fila["nombreCat"]; ?>"
							readonly />
					</div>
					<div class="mb-3">
						<label for="areaDescripcion" class="form-label">Descripción:</label>
						<div class="form-floating">
							<textarea
								class="form-control"
								id="areaDescripcion"
								maxlength="200"
								name="areaDescripcion"
								readonly><?php echo $fila["descripcionCat"]; ?></textarea>
						</div>
					</div>
					<div class="mb-3">
						<label for="comboTipoCat" class="form-label"
							>Tipo de categoría:</label
						>
<?php
                    if($fila["tipo"] == "gen")
                    {
                        $tipo = "General";
                    }
                    else
                    {
                        $tipo = "Deportiva";
                    }
?>
						<input
                        type="text"
                        class="form-control"
                        id="catGen"
                        name="catGen"
                        value="<?php echo $tipo; ?>"
                        readonly />
					</div>
                    <input type="hidden" name="codCat" value="<?php echo $fila["codCategoria"]; ?>">
                    <button type="submit" name="eliminar" class="btn btn-primary">Eliminar</button>
                </form>
            </div>

<?php
        }
    }
    else
    {
        extract($_POST);

        $sqlDelete = "DELETE FROM categorias WHERE codCategoria = $codCat";
        try
        {
            $resultadoDelete = mysqli_query($conexion, $sqlDelete);
            if($resultadoDelete)
            {
                echo "<div id='resultado'>";
                echo "<h1>Categoría eliminada</h1><br>";
                echo '<a id="botonVolver" href="../html/gestionCategorias.html" id="botonInicio" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Volver a la gestión de productos</a>';
                echo "</div>";
            }
            else
            {
                echo "<div id='resultado'>";
                echo "<h1>Hubo un problema para eliminar la categoría</h1><br>";
                echo '<a id="botonVolver" href="../html/gestionCategorias.html" id="botonInicio" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Volver a la gestión de productos</a>';
                echo "</div>";
            }
        }
        catch (Exception $e)
        {
            echo "No puede eliminarse la categoría al existir productos que referencian a la misma.";
        }
        
        
    }

?>

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