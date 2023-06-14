document.addEventListener("DOMContentLoaded", cargaPagina);

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

    fetch("../php/buscadorClientes.php", {
        method: "GET"
    })
    .then((res) => res.json())
    .then(({clientes})=> {
        divListado.innerHTML = clientes;

        $(document).ready(function() {
            $('#tablaClientes').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<i class="fa-regular fa-file-pdf fa-2xl"></i>',
                        className: "botonPDF",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths = 
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                "language": {
                "lengthMenu": "Mostrar _MENU_ lineas",
                "zeroRecords": "No se ha encontrado nada",
                "info": "Enseñando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay información disponible",
                "search": "Buscar cliente:",
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