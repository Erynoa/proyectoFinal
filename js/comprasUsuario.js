document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');

const divCompras = document.getElementById("divCompras");

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

    fetch("../php/recuperaPedidosDelCliente.php", {
        method: "GET",
    })
    .then((res) => res.json())
    .then(({pedidos}) => {
        divCompras.innerHTML = pedidos;

        $(document).ready(function() {
            $('#tablaCompras').DataTable({
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
    })
}

