<?php

    include("./conexion.php");

    $sqlBuscaClientes = "SELECT codUsuario, dni, nombre, apellidos, direccion, provincia, localidad, cp, email, usuario";
    $from = " FROM usuarios";
    $where = " WHERE tipo = 'cliente'";

    $sqlBuscaClientes .= $from;
    $sqlBuscaClientes .= $where;

    $resultadoBuscar = mysqli_query($conexion, $sqlBuscaClientes);
    $numRows = mysqli_num_rows($resultadoBuscar);

    if($numRows > 0)
    {
        $clientes = "<table id='tablaClientes' class='table table-bordered table-striped table-responsive' style='text-align: center; vertical-align: middle'>";
        $clientes .= "<thead><tr><th>DNI</th><th>Nombre</th><th>Apellidos</th><th>Dirección</th><th>Procinvia</th><th>Localidad</th><th>Código Postal</th><th>email</th><th>Usuario</th></tr></thead>";
        while($fila = mysqli_fetch_assoc($resultadoBuscar))
        {
            extract($fila);
            $clientes .= "<tr>";

            $clientes .= "<td>".$dni."</td>";
            $clientes .= "<td>".$nombre."</td>";
            $clientes .= "<td>".$apellidos."</td>";
            $clientes .= "<td>".$direccion."</td>";
            $clientes .= "<td>".$provincia."</td>";
            $clientes .= "<td>".$localidad."</td>";
            $clientes .= "<td>".$cp."</td>";
            $clientes .= "<td>".$email."</td>";
            $clientes .= "<td>".$usuario."</td>";

            $clientes .= "</tr>";
        }
    }
    else
    {
        $clientes = "No hay clientes registrados en la base de datos";
    }

    echo json_encode(array("clientes" => $clientes));

?>