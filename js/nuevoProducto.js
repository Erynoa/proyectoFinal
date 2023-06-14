document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');
let mensaje = document.getElementById('mensaje');
let salida ="";

const comboCatGen = document.getElementById("comboCatGen");
const comboCatDep = document.getElementById("comboCatDep");

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

    buscaCategorias("gen", comboCatGen);
    buscaCategorias("dep", comboCatDep);
}

function buscaCategorias(tipoCat, combo)
{
    let tipoEspecifico = new FormData();
    tipoEspecifico.append("tipoEspecifico", tipoCat);

    fetch("../php/categorias.php", {
        method: "POST",
        body: tipoEspecifico,
    })
    .then((res) => res.json())
    .then(({categorias}) => {
        for(let cat of categorias)
        {
            let option = document.createElement("OPTION");
            option.setAttribute("value", cat.codCategoria);
            option.innerHTML = cat.nombreCat;
            
            combo.appendChild(option);
        }
    });
}

formulario.addEventListener("submit", function(event) {

    event.preventDefault();
    mensaje.innerHTML = "";
    errores = [];
    hayErrores = false;

    let denominacion = formulario.denominacion.value.trim();
    let descripcion = formulario.areaDescripcion.value.trim();
    let categoriaGen = formulario.comboCatGen.value;
    let categoriaDep = formulario.comboCatDep.value;
    let disponibilidad = formulario.radioDisponibilidad.value;
    let stock = formulario.stockProd.value;
    let precio = formulario.precioProd.value;

    const validaPrecio = /^\d*(\.\d{1})?\d{0,1}$/;
    
    if(!validaPrecio.test(precio))
    {
        errores.push("El precio es incorrecto. Asegúrese de que sean números positivos.");
        hayErrores = true;
    }

    if(categoriaGen == 0)
    {
        errores.push("No ha seleccionado una cateogría principal.");
    }

    if(disponibilidad == "n" && stock > 0 || disponibilidad == "s" && stock == 0)
    {
        errores.push("No hay concordancia entre la disponibilidad y el stock.");
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
        datos.append("denominacion" , denominacion);
        datos.append("descripcion", descripcion);
        datos.append("categoriaGen", categoriaGen);
        datos.append("categoriaDep", categoriaDep);
        datos.append("disponibilidad", disponibilidad);
        datos.append("stock", stock);
        datos.append("precio", precio);

        fetch("../php/anadirProducto.php" , {
            method : "POST",
            body: datos,
        })
        .then((resAP) => resAP.json())
        .then(({resultado}) => {
            if(resultado === 1)
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