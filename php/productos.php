<?php

    include("./conexion.php");

    if(!isset($_POST["catalogo"]))
    {

        $codCatGen = $_POST["catGen"];

        $sqlBuscar = "SELECT codBarras, denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio";
        $from = " FROM productos";

        if(!isset($_POST["gestionProd"])) 
        {
            $where = " WHERE categoria IN (".$codCatGen.")";

            if(!empty($_POST["catDep"]))
            {
                $codCatDep = $_POST["catDep"];
                if(!empty($codCatGen))
                {
                    $where .= " OR categoriaDepor IN (".$codCatDep.")";
                }
                else
                {
                    $where = " WHERE categoriaDepor IN (".$codCatDep.")";
                }
                
            }
            
        }
        else // Si estamos aquí, viene de la pag gestionProductos, donde queremos todos los productos de la categoria que sea.
        {
            $where = " WHERE categoria = $codCatGen OR categoriaDepor = $codCatGen";
        }
        
        $sqlBuscar .= $from;
        if(!empty($codCatGen) || !empty($codCatDep))
        {
            $sqlBuscar .= $where;
        }

        $resultado = mysqli_query($conexion, $sqlBuscar);
        $numRows = mysqli_num_rows($resultado);
        if($numRows == 0)
        {
            $productos = array();
        }
        else
        {
            $contador = 0;
            while($fila = mysqli_fetch_assoc($resultado))
            {
                $productos[$contador]["codBarras"] = $fila["codBarras"]; 
                $productos[$contador]["denominacionProd"] = $fila["denominacionProd"]; 
                $productos[$contador]["descripcionProd"] = $fila["descripcionProd"]; 
                $productos[$contador]["disponibilidad"] = $fila["disponibilidad"]; 
                $productos[$contador]["categoria"] = $fila["categoria"]; 
                $productos[$contador]["categoriaDepor"] = $fila["categoriaDepor"]; 
                $productos[$contador]["stock"] = $fila["stock"]; 
                $productos[$contador]["precio"] = $fila["precio"];

                $contador++;
            }

            foreach($productos as $numFila => $contenidoFila)
            {
                foreach($contenidoFila as $nombreColumna=>$contenido)
                {
                    if($nombreColumna == "categoria" || $nombreColumna == "categoriaDepor")
                    {
                        if($contenido != null)
                        {
                            $sqlBuscaCat = "SELECT nombreCat FROM categorias WHERE codCategoria = $contenido";
                            $resultadoCat = mysqli_query($conexion, $sqlBuscaCat);

                            while($filaCat = mysqli_fetch_assoc($resultadoCat))
                            {
                                $nombreBuscado = $filaCat["nombreCat"]; 
                            }

                            if($nombreColumna == "categoria")
                            {
                                $productos[$numFila]["categoria"] = $nombreBuscado;
                            }
                            else
                            {
                                $productos[$numFila]["categoriaDepor"] = $nombreBuscado;
                            }
                        }
                        else
                        {
                            $productos[$numFila]["categoriaDepor"] = "No asignada";
                        }
                        
                    }
                }
            }

            $contenido = '<a id="botonDescarga" href="../php/verPdfCategoriaProd.php?categoria=' .$_POST["catGen"]. '" target="_blank" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Descargar listado productos</a>';
            $contenido .= "<table id='tablaProducto' class='table table-bordered table-striped' style='text-align: center; vertical-align: middle'>";
            $contenido .= "<thead><tr><th>Código</th><th>Foto</th><th>Denominación</th><th>Descripción</th><th>Disponibilidad</th><th>Categoría general</th><th>Categoría deportiva</th><th>Stock</th><th>Precio</th><th>Acciones</th></tr></thead><tbody>";
            foreach($productos as $numFila => $contenidoFila)
            {

                    $contenido .= "<tr>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["codBarras"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $sqlBuscarImagen = "SELECT codImagen, nombreImg, fecha FROM imagenes WHERE codImagen = 'PROD".$contenidoFila["codBarras"]."'";
	                $resultadoBusqueda = mysqli_query($conexion, $sqlBuscarImagen);
                    if($resultadoBusqueda->num_rows == 0)
	                {
                        $contenido .= '<img src="../img/noImg.png" width=70 heigth=70>';
                    }
                    else
                    {
                        $contenido .= '<img src="../img/PROD'.$contenidoFila["codBarras"].'.jpg" width=70 heigth=70>';
                    }
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["denominacionProd"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["descripcionProd"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    if($contenidoFila["disponibilidad"] == "s")
                    {
                        $contenido .= "Sí";
                    }
                    else
                    {
                        $contenido .= "No";
                    }
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["categoria"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["categoriaDepor"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["stock"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    $contenido .= $contenidoFila["precio"];
                    $contenido .= "</td>";

                    $contenido .= "<td>";
                    
                    $contenido .= '<a id="botonAccionAnadir" href="../php/asignarImagen.php?cod=' . $contenidoFila["codBarras"] . '&redirigido=1" class="btn btn-primary active" role="button" aria-pressed="true"><img src="../img/agregar.png" width="40" height="40" ></a>';
                    $contenido .= '<a id="botonAccionModificar" href="../php/modificarProducto.php?codProd=' . $contenidoFila["codBarras"] . '" class="btn btn-primary active" role="button" aria-pressed="true"><img src="../img/editar.png" width="40" height="40" ></a>';
                    $contenido .= '<a id="botonAccionBorrar" href="../php/eliminarProducto.php?codProd=' . $contenidoFila["codBarras"] . '" class="btn btn-primary active" role="button" aria-pressed="true"><img src="../img/papelera.png" width="40" height="40" ></a>';
                    
                    $contenido .= "</td>";

                    $contenido .= "</tr>";
            }
                

                $contenido .= "</tbody></table>";
            
        
        }
        
        echo json_encode(array("contenido" => $contenido));
    }
    else
    {
        $codCatGen = $_POST["catGen"];

        $sqlBuscar = "SELECT codBarras, denominacionProd, descripcionProd, disponibilidad, categoria, categoriaDepor, stock, precio";
        $from = " FROM productos";

        if(!isset($_POST["gestionProd"])) 
        {
            $where = " WHERE categoria IN (".$codCatGen.")";

            if(!empty($_POST["catDep"]))
            {
                $codCatDep = $_POST["catDep"];
                if(!empty($codCatGen))
                {
                    $where .= " OR categoriaDepor IN (".$codCatDep.")";
                }
                else
                {
                    $where = " WHERE categoriaDepor IN (".$codCatDep.")";
                }
                
            }
            
        }
        else // Si estamos aquí, viene de la pag gestionProductos, donde queremos todos los productos de la categoria que sea.
        {
            $where = " WHERE categoria = $codCatGen OR categoriaDepor = $codCatGen";
        }
        
        $sqlBuscar .= $from;
        if(!empty($codCatGen) || !empty($codCatDep))
        {
            $sqlBuscar .= $where;
        }

        $resultado = mysqli_query($conexion, $sqlBuscar);
        $numRows = mysqli_num_rows($resultado);
        if($numRows == 0)
        {
            $productos = array();
        }
        else
        {
            $contador = 0;
            while($fila = mysqli_fetch_assoc($resultado))
            {
                $productos[$contador]["codBarras"] = $fila["codBarras"]; 
                $productos[$contador]["denominacionProd"] = $fila["denominacionProd"]; 
                $productos[$contador]["descripcionProd"] = $fila["descripcionProd"]; 
                $productos[$contador]["disponibilidad"] = $fila["disponibilidad"]; 
                $productos[$contador]["categoria"] = $fila["categoria"]; 
                $productos[$contador]["categoriaDepor"] = $fila["categoriaDepor"]; 
                $productos[$contador]["stock"] = $fila["stock"]; 
                $productos[$contador]["precio"] = $fila["precio"];

                $contador++;
            }

            foreach($productos as $numFila => $contenidoFila)
            {
                foreach($contenidoFila as $nombreColumna=>$contenido)
                {
                    if($nombreColumna == "categoria" || $nombreColumna == "categoriaDepor")
                    {
                        if($contenido != null)
                        {
                            $sqlBuscaCat = "SELECT nombreCat FROM categorias WHERE codCategoria = $contenido";
                            $resultadoCat = mysqli_query($conexion, $sqlBuscaCat);

                            while($filaCat = mysqli_fetch_assoc($resultadoCat))
                            {
                                $nombreBuscado = $filaCat["nombreCat"]; 
                            }

                            if($nombreColumna == "categoria")
                            {
                                $productos[$numFila]["categoria"] = $nombreBuscado;
                            }
                            else
                            {
                                $productos[$numFila]["categoriaDepor"] = $nombreBuscado;
                            }
                        }
                        else
                        {
                            $productos[$numFila]["categoriaDepor"] = "No asignada";
                        }
                        
                    }
                }
            }
        }

        echo json_encode(array("productos" => $productos));
    }
?>