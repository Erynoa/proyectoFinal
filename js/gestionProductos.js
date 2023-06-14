document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');

const comboCatGen = document.getElementById("comboCatGen");
const formulario = document.getElementById("formularioCat");
const divTabla = document.getElementById("divTabla");
const tablaProducto = document.createElement("tablaProducto");

let contenido = "";


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

    let completo = new FormData();
    completo.append("completo", true);

    fetch("../php/categorias.php", {
        method: "POST",
        body: completo,
    })
    .then((res) => res.json())
    .then(({categorias}) => {
        for(let cat of categorias)
        {
            let option = document.createElement("OPTION");
            option.setAttribute("value", cat.codCategoria);
            option.innerHTML = cat.nombreCat;
            
            comboCatGen.appendChild(option);
        }
    });

    //divTabla.innerHTML = "";

}

formulario.addEventListener("submit", function(event) {

    event.preventDefault();
    divTabla.innerHTML = "";

    let codigoCat = comboCatGen.value; 

    let catGen = new FormData();
    catGen.append("catGen", codigoCat);
    catGen.append("gestionProd", true);
    
    fetch("../php/productos.php", {
        method: "POST",
        body: catGen,
    })
    .then((res) => res.json())
    .then(({contenido}) => {
        divTabla.innerHTML = contenido;

        $(document).ready(function() {
            $('#tablaProducto').DataTable({
                "language": {
                "lengthMenu": "Mostrar _MENU_ lineas",
                "zeroRecords": "No se ha encontrado nada",
                "info": "Enseñando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay información disponible",
                "search": "Buscar producto:",
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
    });
});


