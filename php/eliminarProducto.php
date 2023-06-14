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

		<link rel="stylesheet" href="../css/modificarProducto.css" />

		<link rel="icon" href="../img/logo.png" />
		<title>Modificar producto</title>
	</head>
    <body>
        <div class="container-fluid">
        
        <?php

            extract($_GET);

            $categoriasGenerales = buscaCategorias("gen");
            $categoriasDeportivas = buscaCategorias("dep");

            function buscaCategorias($tipoRec)
            {
                $tipo = $tipoRec;
                $categorias = array();
                
                $servername = "localhost";
                $username = "id20911187_root";
                $password = "Dawsport13+";
                $basedatos = "id20911187_dawsport";
                $conexion = mysqli_connect($servername, $username, $password, $basedatos);
                $conexion->set_charset("utf8");

                $sql = "SELECT codCategoria, nombreCat, descripcionCat, tipo FROM categorias WHERE tipo = '".$tipo."'";
                $resultado = mysqli_query($conexion, $sql);
                while($fila = mysqli_fetch_assoc($resultado))
                {
                    extract($fila);
                    $categorias[$codCategoria]["codCategoria"] = $codCategoria;
                    $categorias[$codCategoria]["nombreCat"] = $nombreCat;
                    $categorias[$codCategoria]["descripcionCat"] = $descripcionCat;  
                }

                return $categorias;
            }

            if(!isset($_POST["eliminar"]))
            {  

                $sqlBuscaProd = "SELECT codBarras, denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio";
                $from = " FROM productos";
                $where = " WHERE codBarras = $codProd";
        
                $sqlBuscaProd .= $from;
                $sqlBuscaProd .= $where;
        
                $resultado = mysqli_query($conexion, $sqlBuscaProd);
                while($fila = mysqli_fetch_assoc($resultado))
                {
        ?>
            
            <div id="formularioDelete">
            <h1>Eliminar producto</h1>
            <a href="../html/gestionProductos.html" id="botonVolver" class="btn btn-primary active" role="button" aria-pressed="true">Volver a la gestión de productos</a>
            
                <form id="formularioDel" name="formularioDel" method="POST" action="#">
                <h3>¿Desea eliminar el siguiente producto?</h3>
                    <div class="row m-3">
						<div class="col col-12 col-md-3 ">
                        <label for="denominacion" class="form-label">Denominación:</label>
                        </div>
						<div class="col">
                        <input
                            type="text"
                            class="form-control"
                            id="denominacion"
                            name="denominacion"
                            value="<?php echo $fila["denominacionProd"]; ?>"
                            readonly />
                            </div>
                    </div>
                    <div class="row m-3">
					<div class="col col-12 col-md-3 ">
                        <label for="areaDescripcion" class="form-label">Descripción:</label>
                        </div>
						<div class="col">
                        <div class="form-floating">
                            <textarea
                                class="form-control"
                                id="areaDescripcion"
                                maxlength="200"
                                name="areaDescripcion"
                                readonly><?php echo $fila["descripcionProd"]; ?></textarea>
                        </div>
                        </div>
                    </div>
                    <div class="row m-3">
						<div class="col col-12 col-md-3 ">
                        <label for="catGen" class="form-label"
                            >Categoría general:</label
                        >
                        </div>
						<div class="col">
                            <?php
                                foreach($categoriasGenerales as $categoria)
                                {
                                    if($categoria["codCategoria"] == $fila["categoria"])
                                    { ?>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="catGen"
                                        name="catGen"
                                        value="<?php echo $categoria["nombreCat"]; ?>"
                                        readonly />
                                    <?php } 
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row m-3">
						<div class="col col-12 col-md-3 ">
                        <label for="catDep" class="form-label"
                            >Categoría deportiva:</label
                        >
                        </div>
						<div class="col">
                        <?php
                                foreach($categoriasDeportivas as $categoria)
                                {
                                    if($categoria["codCategoria"] == $fila["categoriaDepor"])
                                    { ?>
                                        <input
                                        type="text"
                                        class="form-control"
                                        id="catDep"
                                        name="catDep"
                                        value="<?php echo $categoria["nombreCat"]; ?>"
                                        readonly />
                                <?php } 
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row m-3">
					<div class="col col-12 col-md-3 ">
                        <label for="radioDisponibilidad" class="form-label"
                            >Disponibilidad:</label
                        >
                        </div>
						<div class="col">
                        <?php

                        if($fila["disponibilidad"] == "s")
                        {
                            echo '<input
                                type="text"
                                class="form-control"
                                id="radioDisponibilidad"
                                name="radioDisponibilidad"
                                value="Sí"
                                readonly />';
                        }
                        else
                        {
                            echo '<input
                                type="text"
                                class="form-control"
                                id="radioDisponibilidad"
                                name="radioDisponibilidad"
                                value="No"
                                readonly />';
                        }
                        
                        ?>
                        </div>
                    </div>
                    <div class="row m-3">
					<div class="col col-12 col-md-3 ">
                        <label for="stockProd" class="form-label">Stock:</label>
                    </div>
					<div class="col">
                        <input type="text" class="form-control" name="stockProd" value="<?php echo $fila["stock"]; ?>" readonly />
                    </div>
                    </div>
                    <div class="row m-3">
					<div class="col col-12 col-md-3 ">
                        <label for="precioProd" class="form-label">Precio:</label>
                    </div>
					<div class="col">
                        <input
                            type="text"
                            class="form-control"
                            id="precioProd"
                            name="precioProd"
                            value="<?php echo $fila["precio"];?>"
                            readonly />
                            </div>
                    </div>
                    <input type="hidden" name="codBarras" value="<?php echo $fila["codBarras"]; ?>">
                    <div class="row m-3">
					<div class="col">
                    <button type="submit" name="eliminar" class="btn btn-primary">Eliminar</button>
                    </div>
					</div>
                </form>
            </div>
            <?php
                }

            }
            else
            {
                extract($_POST);

                $sqlDelete = "DELETE FROM productos WHERE codBarras = $codBarras";
                $resultadoDelete = mysqli_query($conexion, $sqlDelete);

                if($resultadoDelete)
                {
                    echo "<div id='resultado'>";
                    echo "<h1>Producto eliminado</h1><br>";
                    echo '<a id="botonVolver" href="../html/gestionProductos.html" id="botonInicio" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Volver a la gestión de productos</a>';
                    echo "</div>";
                }
                else
                {
                    echo "<div id='resultado'>";
                    echo "<h1>Hubo un problema para eliminar el producto</h1><br>";
                    echo '<a id="botonVolver" href="../html/gestionProductos.html" id="botonInicio" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Volver a la gestión de productos</a>';
                    echo "</div>";
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


