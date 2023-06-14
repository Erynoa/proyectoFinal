document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');

const divForm = document.getElementById("divDatos");
let contenido;

function cargaPagina()
{
    // Configuración navegación ---------------------------
    if(tipoUsuario == 'admin')
    {
        liAnon.style.display = 'none';
        liAdmin.style.display = 'block';
        liUsu.style.display = 'none';
        liCerrar.style.display = 'block';
        liCarrito.style.display = 'none';
    }
    else if(tipoUsuario == 'usu')
    {
        liAnon.style.display = 'none';
        liAdmin.style.display = 'none';
        liUsu.style.display = 'block';
        liCerrar.style.display = 'block';
    }
    else
    {
        liAnon.style.display = 'block';
        liAdmin.style.display = 'none';
        liUsu.style.display = 'none';
        liCerrar.style.display = 'none';
    }
    // Configuración navegación ---------------------------

    creaFormularioMod();
}

function creaFormularioMod()
{
    divForm.innerHTML = "";

    fetch("../php/datosUsuario.php", {
        method: "GET",
    })
    .then((res) => res.json())
    .then(({datos}) => {
        
        contenido = "<form id='formularioMod' method='POST' action='../php/modificarUsuario.php'>";
        contenido += '<div class="row">';
        contenido += '<div class="col">';
        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="dni" class="form-label">DNI</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="dni" name="dni" value="'+datos.dni+'" readonly /> </div></div>';


        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="nombre" class="form-label">Nombre</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="nombre" name="nombre" value="'+datos.nombre+'" required /> </div></div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="apellidos" class="form-label">Apellidos</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="apellidos" name="apellidos" value="'+datos.apellidos+'" required /></div> </div>';
                    
        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="direccion" class="form-label">Dirección</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="direccion" name="direccion" value="'+datos.direccion+'" required /> </div></div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="provincia" class="form-label">Provincia</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="provincia" name="provincia" value="'+datos.provincia+'" required /> </div></div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="localidad" class="form-label">Localidad</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="localidad" name="localidad" value="'+datos.localidad+'" required /> </div></div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="cp" class="form-label">Código postal</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="cp" name="cp" value="'+datos.cp+'" required /> </div></div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="email" class="form-label">Email</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="email" class="form-control" id="email" name="email" value="'+datos.email+'" readonly /> </div></div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="usuario" class="form-label">Usuario</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="text" class="form-control" id="usuario" name="usuario" value="'+datos.usuario+'" readonly />';
        contenido += '<div id="usuarioAyuda" class="form-text"> Deberá comenzar con siete caracteres en minúscula, evitando Ñ y tildados, y finalizar con tres dígitos. </div></div> </div>';

        contenido += '<div class="row m-3">';
        contenido += '<div class="col col-12 col-md-2 ">';
        contenido += '<label for="password" class="form-label">Contraseña</label></div>';
        contenido += '<div class="col">';
        contenido += '<input type="password" class="form-control" id="password" name="password" value="'+datos.pass+'" required /> </div></div>';

        contenido += '<input type="hidden" name="codUsuario" value="'+datos.codUsuario+'">';

        contenido += '<div class="row text-center m-3"><div class="col">';
        contenido += '<button type="submit" class="btn btn-primary">Modificar</button>';
        contenido += '</div></div>';

        contenido += "</form>";

        divForm.innerHTML = contenido;

    });

    
}