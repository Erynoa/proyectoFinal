document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');

const divListado = document.getElementById("divListado");
const formulario = document.getElementById("formularioVentas");

document.getElementById("cerrarVacia").addEventListener("click", interactuaModal);
document.getElementById("cerrarMal").addEventListener("click", interactuaModal2);

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
}

formulario.addEventListener("submit", function(event)
{
    event.preventDefault();

    divListado.innerHTML = "";

    let fechaInicio = new Date(formulario.fechaInicio.value);
    let fechaFin = new Date(formulario.fechaFin.value);
    let fechaActual = new Date();

    if(fechaInicio > fechaFin || fechaInicio > fechaActual)
    {
        // Fechas incorrectas
        interactuaModal2();
    }
    else
    {
        let diaInicio = fechaInicio.getDate();
        let mesInicio = fechaInicio.getMonth() + 1;
        if(mesInicio < 10)
        {
            mesInicio = "0" + mesInicio;
        }
        let anyoInicio = fechaInicio.getFullYear();

        let fechaInicioTransformada = anyoInicio + "/" + mesInicio + "/" + diaInicio;

        let diaFin = fechaFin.getDate();
        let mesFin = fechaFin.getMonth() + 1;
        if(mesFin < 10)
        {
            mesFin = "0" + mesFin;
        }
        let anyoFin = fechaFin.getFullYear();

        let fechaFinTransformada = anyoFin + "/" + mesFin + "/" + diaFin;

        let datos = new FormData();
        if(fechaInicioTransformada == "NaN/NaN/NaN" && fechaFinTransformada == "NaN/NaN/NaN")
        {
            // Están mal las fechas
            interactuaModal();
        }
        else
        {
            if(fechaInicioTransformada == "NaN/NaN/NaN")
            {
                datos.append("fechaFin", fechaFinTransformada);
            }
            else if(fechaFinTransformada == "NaN/NaN/NaN")
            {
                datos.append("fechaInicio", fechaInicioTransformada);
            }
            else
            {
                datos.append("fechaInicio", fechaInicioTransformada);
                datos.append("fechaFin", fechaFinTransformada);
            }

            fetch("../php/buscadorVentas.php", {
                method: "POST",
                body: datos,
            })
            .then((res) => res.json())
            .then(({contenido}) => {
                divListado.innerHTML = contenido;

                $(document).ready(function() {
                    $('#tablaPedidos').DataTable({
                        searching: false,
                        "language": {
                        "lengthMenu": "Mostrar _MENU_ lineas",
                        "zeroRecords": "No se ha encontrado nada",
                        "info": "Enseñando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay información disponible",
                        "infoFiltered": "(Filtrado de _MAX_ en total)",
                        "paginate": {
                        "first": "Primera",
                        "last": "Ultima",
                        "next": "Siguiente",
                        "previous": "Anterior"
                            }
                        }
                    });
                } );
            })
        }
    }

})

function interactuaModal()
{
    $('#errorVacia').toggle();
}

function interactuaModal2()
{
    $('#errorMal').toggle();
}