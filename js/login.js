document.addEventListener("DOMContentLoaded", cargaPagina);

let divForm = document.getElementById("formLogin");
let formulario = document.getElementById("formularioLogin");
let mensaje = document.getElementById('mensaje');
let redirigidoCarrito = 1;

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');
const tipoUsuario = sessionStorage.getItem('tipoUsuario');

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

    let recibido = window.location.search.substring(1);
    let arrayRecibido = recibido.split ("&");
    let parametros = {};

    for ( var i = 0; i < arrayRecibido.length; i++) {
        var arraySeparadoRecibido = arrayRecibido[i].split("=");
        parametros[arraySeparadoRecibido[0]] = arraySeparadoRecibido[1];
    }

    let redirigido = arraySeparadoRecibido[1];
    if(redirigido == 1)
    {
        redirigidoCarrito = 0;
        mensajeRedirigido();
    }
}

formulario.addEventListener("submit", function(event)
{
    event.preventDefault();

    let usuario = document.getElementById("usuario").value.trim();
    let pass = formulario.pass.value.trim();

    let datos = new FormData();
    datos.append("usuario", usuario);
    datos.append("pass", pass);

    fetch("../php/login.php", {
        method: "POST",
        body: datos,
    })
    .then((res) => res.json())
    .then(({success}) => {
        if(success === 1)
        {
            // El usuario existe en la base de datos
            // Habrá que comprobar qué tipo de usuario es
            fetch("../php/tipoUsuario.php", {
                method: "POST",
                body: datos,
            })
            .then((resTipo) => resTipo.json())
            .then(({tipo}) => {
                if(tipo == "administrador")
                {
                    sessionStorage.setItem('tipoUsuario', 'admin');
                }
                else if(tipo == "cliente")
                {
                    sessionStorage.setItem('tipoUsuario', 'usu');
                }

                if(redirigidoCarrito == 0)
                {
                    location.href = "../html/carrito.html";
                }
                else
                {
                    location.href = "../index.html";
                }  
            })
        }
        else
        {
            // El usuario no existe en la base de datos
            alerta();
        }
    });
});

function alerta()
{
    mensaje.innerHTML = `<div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Datos incorrectos o campos vacíos.</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
}


function mensajeRedirigido()
{
    mensaje.innerHTML = `<div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Debe iniciar sesión para realizar la compra</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
}
