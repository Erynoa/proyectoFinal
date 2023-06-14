document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');
let mensaje = document.getElementById('mensaje');
let salida ="";

let formulario = document.getElementById("formularioAna");
let errores = [];
let hayErrores = false;

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

}

formulario.addEventListener("submit", function(event) {
    event.preventDefault();

    mensaje.innerHTML = "";
    errores = [];
    hayErrores = false;

    let nombreCat = formulario.denominacion.value.trim();
    let descripcionCat = formulario.areaDescripcion.value.trim();
    let tipo = formulario.comboTipoCat.value;

    if(tipo == 0)
    {
        errores.push("No ha seleccionado el tipo de categoría.");
    }

    if(errores.length > 0)
    {
        salida = "<ul>";
        for(let error of errores)
        {
            salida += "<li>" + error + "</li>";
        }
        salida += "</ul>";

        alertaError();
    }
    else
    {
        let datos = new FormData();
        datos.append("nombreCat", nombreCat);
        datos.append("descripcionCat", descripcionCat);
        datos.append("tipo", tipo);

        fetch("../php/anadirCategoria.php", {
            method: "POST",
            body: datos,
        })
        .then((resultadoAnadirCat) => resultadoAnadirCat.json())
        .then(({resultado}) => {
            if(resultado ===1)
            {
                // Todo ha salido bien ¿Mensaje abajo o pop up? 
                console.log("guay");
                formulario.reset();
            }
            else
            {
                if(resultado == 3)
                {
                    salida = "El nombre de ese producto ya ha sido registrado.";
                    alertaError();
                }
                else
                {
                    salida = "Hubo un problema al añadir a la base de datos.";
                    alertaError();
                }
            }
        })
    }
    
})

function alertaError()
{
    mensaje.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>ERROR.</strong><br>` + salida + `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
}