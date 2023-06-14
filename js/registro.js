document.addEventListener("DOMContentLoaded", cargaPagina);
let formulario = document.getElementById("formularioReg");
let mensaje = document.getElementById('mensaje');

let errores = [];
let hayErrores = false;
let salida ="";

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

}

formulario.addEventListener("submit", function(event) {

    event.preventDefault();
    mensaje.innerHTML = "";

    errores = [];
    hayErrores = false;
    salida ="";

    let dni = formulario.dni.value.trim();
    let nombre = formulario.nombre.value.trim();
    let apellidos = formulario.apellidos.value.trim();
    let direccion = formulario.direccion.value.trim();
    let provincia = formulario.provincia.value.trim();
    let localidad = formulario.localidad.value.trim();
    let cp = formulario.cp.value.trim();
    let email = formulario.email.value.trim();
    let usuario = formulario.usuario.value.trim();
    let password = formulario.password.value.toString().trim();

    const validaDNI = /^[0-9]{7,8}[A-Z]$/;
    const validaNombreApellidos = /^[A-ZÑÁÉÍÓÚ][a-zñáéíóú]*(s[A-ZÑÁÉÍÓÚ][a-zñáéíóú]*)*/;
    const validaCp = /\d\d\d\d\d/;
    const validaUsuario = /^[a-z]{7}[0-9]{3}$/;
    
    if(!validaDNI.test(dni))
    {
        errores.push("DNI");
        hayErrores = true;
    }

    if(!validaNombreApellidos.test(nombre))
    {
        errores.push("Nombre");
        hayErrores = true;
    }

    if(!validaNombreApellidos.test(apellidos))
    {
        errores.push("Apellidos");
        hayErrores = true;
    }

    if(!validaCp.test(cp))
    {
        errores.push("Código postal");
        hayErrores = true;
    }

    if(!validaUsuario.test(usuario))
    {
        errores.push("Usuario");
        hayErrores = true;
    }

    if(hayErrores)
    {
        event.preventDefault();
        
        salida += "Hay conflico con los siguientes campos:<br><ul>";
        for(let campo of errores)
        {
            salida += "<li>" + campo + "</li>";
        }
        salida += "</ul>";

        alerta();
    }

    let datos = new FormData();
    datos.append("dni", dni);
    datos.append("nombre", nombre);
    datos.append("apellidos", apellidos);
    datos.append("direccion", direccion);
    datos.append("provincia", provincia);
    datos.append("localidad", localidad);
    datos.append("cp", cp);
    datos.append("email", email);
    datos.append("usuario", usuario);
    datos.append("pass", password);
    
    fetch("../php/comprobarUsuario.php", {
        method: "POST",
        body: datos,
    })
    .then((res) => res.json())
    .then(({erroresReg}) => {
        if(erroresReg.length > 0)
        { // Hay errores porque el DNI, el usuario o el email ya están registrados
            salida = "<ul>";
            for(let error of erroresReg)
            {
                salida += "<li>" + error + "</li>";
            }
            salida += "</ul>";

            alerta();
        }
        else
        { // No hay errores, el usuario puede ser registrado. 
  
            fetch("../php/registrarUsuario.php", {
                method: "POST",
                body: datos,
            })
            .then((resReg) => resReg.json())
            .then(({resultado}) => {
                if(resultado === 1)
                {
                    // Se ha registrado al usuario, por lo tanto volvemos al index como "cliente"
                    sessionStorage.setItem('tipoUsuario', 'usu');
                    location.href = "../index.html";
                }
                else
                {
                    salida = "Ha habido un problema con el registro."
                    alerta();
                }
            })
            
        }
        
    });
    
});

function alerta()
{
    mensaje.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>ERROR.</strong><br>` + salida + `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
}
