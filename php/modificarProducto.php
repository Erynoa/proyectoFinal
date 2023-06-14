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
			content="página para eliminar productos" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
			crossorigin="anonymous" />

		<link rel="stylesheet" href="../css/modificarProducto.css" />

		<link rel="icon" href="../img/logo.png" />
		<title>Eliminar producto</title>
	</head>
    <body>
    <div class="container-fluid">

<?php

    extract($_GET);

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

    if(!isset($_POST["modificar"]))
    {    
        $categoriasGenerales = buscaCategorias("gen");
        $categoriasDeportivas = buscaCategorias("dep");

        $sqlBuscaProd = "SELECT codBarras, denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio";
        $from = " FROM productos";
        $where = " WHERE codBarras = $codProd";

        $sqlBuscaProd .= $from;
        $sqlBuscaProd .= $where;

        $resultado = mysqli_query($conexion, $sqlBuscaProd);
        while($fila = mysqli_fetch_assoc($resultado))
        {
?>
    
        <div id="formularioModificar">
            <h1>Modificar producto</h1>
            <a href="../html/gestionProductos.html" id="botonVolver" class="btn btn-primary active" role="button" aria-pressed="true">Volver a la gestión de productos</a>
            <form id="formularioMod" name="formularioMod" method="POST" action="#">
                <h3>Modifique los datos correspondientes</h3>
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
                        required />
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
                            required><?php echo $fila["descripcionProd"]; ?></textarea>
                    </div>
                    </div>
                </div>
                <div class="row m-3">
                <div class="col col-12 col-md-3 ">
                    <label for="comboCatGen" class="form-label"
                        >Categoría general:</label
                    ></div>
                    <div class="col">
                    <select id="comboCatGen" name="comboCatGen">
                        <?php
                            foreach($categoriasGenerales as $categoria)
                            {
                                if($categoria["codCategoria"] == $fila["categoria"])
                                {
                                    echo "<option value='".$categoria["codCategoria"]."' selected>".$categoria["nombreCat"]."</option>";
                                }
                                else
                                {
                                    echo "<option value='".$categoria["codCategoria"]."'>".$categoria["nombreCat"]."</option>";
                                }
                            }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="row m-3">
                <div class="col col-12 col-md-3 ">
                    <label for="comboCatDep" class="form-label"
                        >Categoría deportiva:</label
                    ></div>
                    <div class="col">
                    <select id="comboCatDep" name="comboCatDep">
                        <?php
                            foreach($categoriasDeportivas as $categoria)
                            {
                                if($categoria["codCategoria"] == $fila["categoriaDepor"])
                                {
                                    echo "<option value='".$categoria["codCategoria"]."' selected>".$categoria["nombreCat"]."</option>";
                                }
                                else
                                {
                                    echo "<option value='".$categoria["codCategoria"]."'>".$categoria["nombreCat"]."</option>";
                                }
                                
                            }
                        ?>
                    </select>
                </div></div>
                <div class="row m-3">
                <div class="col col-12 col-md-3 ">
                    <label for="radioDisponibilidad" class="form-label"
                        >Disponibilidad:</label
                    ></div>
                    <div class="col">

                    <?php

                    if($fila["disponibilidad"] == "s")
                    {
                        echo '<input
                            type="radio"
                            id="siDisp"
                            name="radioDisponibilidad"
                            value="s"
                            checked />
                        <label for="siDisp">Sí</label><br />
                        <input
                            type="radio"
                            id="noDisp"
                            name="radioDisponibilidad"
                            value="n" />
                        <label for="noDisp">No</label><br />';
                    }
                    else
                    {
                        echo '<input
                            type="radio"
                            id="siDisp"
                            name="radioDisponibilidad"
                            value="s" />
                        <label for="siDisp">Sí</label><br />
                        <input
                            type="radio"
                            id="noDisp"
                            name="radioDisponibilidad"
                            value="n" 
                            checked />
                        <label for="noDisp">No</label><br />';
                    }
                    
                    ?>
                </div></div>
                <div class="row m-3">
                <div class="col col-12 col-md-3 ">
                    <label for="stockProd" class="form-label">Stock:</label>
                    </div>
                    <div class="col">
                    <input type="number" name="stockProd" value="<?php echo $fila["stock"]; ?>" required />
                </div></div>

                <div class="row m-3">
                <div class="col col-12 col-md-3 ">
                    <label for="precioProd" class="form-label">Precio:</label></div>
                    <div class="col">
                    <input
                        type="text"
                        class="form-control"
                        id="precioProd"
                        name="precioProd"
                        value="<?php echo $fila["precio"];?>"
                        required />
                        </div>
                </div>
                <input type="hidden" name="codBarras" value="<?php echo $fila["codBarras"]; ?>">
                <div class="row m-3">
				<div class="col">
                <button type="submit" name="modificar" class="btn btn-primary">Modificar</button>
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

        if(($radioDisponibilidad == "s" && $stockProd == 0) || ($radioDisponibilidad == "n" && $stockProd > 0))
        {
            echo "Error. El stock y la disponibilidad deben coincidir.<br>";
            echo "<a href='modificarProducto.php?codProd=$codBarras'>Volver a la modificación</a>";

        }
        else
        {
            $sqlUpdate = "UPDATE productos ";
            $set = " SET denominacionProd = '".$denominacion."', descripcionProd = '".$areaDescripcion."', disponibilidad = '".$radioDisponibilidad."', categoria = $comboCatGen, ";
            if($comboCatDep == 0)
            {
                $set .= "categoriaDepor = NULL, ";
            }
            else
            {
                $set .= "categoriaDepor = $comboCatDep, ";
            }

            $set .= "stock = $stockProd, precio = $precioProd";

            $where = " WHERE codBarras = $codBarras";

            $sqlUpdate .= $set;
            $sqlUpdate .= $where;

            $resultadoUpdate = mysqli_query($conexion, $sqlUpdate);

            if($resultadoUpdate)
            {
                echo "<div id='resultado'>";
                echo "<h1>Producto actualizado</h1><br>";
                echo '<a id="botonVolver" href="../html/gestionProductos.html" id="botonInicio" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Volver a la gestión de productos</a>';
                echo "</div>";
            }
            else
            {
                echo "Hubo un problema para actualizar los datos del producto.<br>";
                echo "<a href='../html/gestionProductos.html'>Volver a la gestión de productos.</a>";
            }

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