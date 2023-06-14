document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');
const divCarrito = document.getElementById("divCarrito");
let totalCompra = 0;

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

    fetch("../php/cargarProductosCarrito.php", {
        method: "GET",
    })
    .then((res) => res.json())
    .then(({productosCarrito}) => {
        if(productosCarrito.length > 0)
        {
            let divBoton = document.createElement("div");
            divBoton.className = "row";
            divBoton.id = "divVaciar";
            let botonVaciarCarrito = document.createElement("a");
            botonVaciarCarrito.href = "../php/vaciarCarrito.php";
            botonVaciarCarrito.className = "btn btn-primary active";
            botonVaciarCarrito.role = "button";
            botonVaciarCarrito.id = "vaciarCarrito";
            botonVaciarCarrito.textContent = "Vaciar carrito";

            let tabla = document.createElement("table");
            tabla.className = "table table-bordered table-striped border-dark";
            tabla.id = "tablaCarrito";

            let thead = document.createElement("thead");

            let trCabecera = document.createElement("tr");

            let thDenominacion = document.createElement("th");
            thDenominacion.textContent = "Denominación";

            let thUnidades = document.createElement("th");
            thUnidades.textContent = "Unidades";

            let thPrecioUnitario = document.createElement("th");
            thPrecioUnitario.textContent = "Precio uni.";

            let thTotalProducto = document.createElement("th");
            thTotalProducto.textContent = "Total producto";

            let thEliminar = document.createElement("th");
            thEliminar.textContent = "Eliminar del carrito";

            trCabecera.append(thDenominacion);

            trCabecera.append(thUnidades);
            trCabecera.append(thPrecioUnitario);
            trCabecera.append(thTotalProducto);
            trCabecera.append(thEliminar);
            thead.append(trCabecera);
            tabla.append(thead);

            let tbody = document.createElement("tbody");
            tabla.append(tbody);

            for(let producto of productosCarrito)
            {
                let trProducto = document.createElement("tr");

                let tdDenominacion = document.createElement("td");
                tdDenominacion.textContent = producto.denominacionProd;

                let tdUnidades = document.createElement("td");
                let inputUnidades = document.createElement("input");
                inputUnidades.type = "number";
                inputUnidades.value = producto.unidades;
                inputUnidades.max = producto.stock;
                inputUnidades.min = 1;
                inputUnidades.addEventListener("change", cambiaUnidades);
                //inputUnidades.onchange = "cambiaUnidades("+producto.codBarras+", "+inputUnidades.value+")";
                

                tdUnidades.append(inputUnidades);

                let tdPrecioUnitario = document.createElement("td");
                tdPrecioUnitario.textContent = producto.precio + " €";

                let tdTotalProducto = document.createElement("td");
                tdTotalProducto.textContent = producto.totalProducto + " €";

                let tdEliminar = document.createElement("td");

                let formDeleteProd = document.createElement("form");
                formDeleteProd.action = "../php/eliminarProdCarrito.php";
                formDeleteProd.method = "POST";

                let inputSubmit = document.createElement("input");
                inputSubmit.type = "submit";
                inputSubmit.className = "btn btn-danger active";
                inputSubmit.id = "botonBorrar";
                inputSubmit.value = "Eliminar";

                let inputHiddenCod = document.createElement("input");
                inputHiddenCod.type = "hidden";
                inputHiddenCod.name = "codProd";
                inputHiddenCod.value = producto.codBarras;

                formDeleteProd.append(inputSubmit);
                formDeleteProd.append(inputHiddenCod);

                tdEliminar.append(formDeleteProd);

                trProducto.append(tdDenominacion);
                trProducto.append(tdUnidades);
                trProducto.append(tdPrecioUnitario);
                trProducto.append(tdTotalProducto);
                trProducto.append(tdEliminar);

                tbody.append(trProducto);

                totalCompra += producto.totalProducto;
            }

            let trTotalCompra = document.createElement("tr");
            trTotalCompra.id = "trTotal";
            let tdTotalCompra = document.createElement("td");
            tdTotalCompra.colSpan = 6;
            let totalFixed = totalCompra.toFixed(2);
            tdTotalCompra.textContent = "TOTAL COMPRA: " + totalFixed + " €";
            tdTotalCompra.id = "tdTotal";
            
            trTotalCompra.append(tdTotalCompra);
            tbody.append(trTotalCompra);

            //let botonComprar = document.createElement("a"); 
            //botonComprar.href = "../php/procesarPedido.php";
            let botonComprar = document.createElement("button");
            botonComprar.type = "button";
            botonComprar.setAttribute("data-bs-toggle", "modal");
            botonComprar.setAttribute("data-bs-target", "#modalConfirmacion");
            botonComprar.className = "btn btn-primary";
            botonComprar.id = "botonComprar";
            botonComprar.role = "button";
            botonComprar.textContent = "Procesar pedido";

            divBoton.append(botonVaciarCarrito);

            divCarrito.append(divBoton);
            divCarrito.append(tabla);
            divCarrito.append(botonComprar);

        }
        else
        {
            divCarrito.innerHTML = "No hay productos en el carrito."
        }
    })
}

function cambiaUnidades(event)
{  
    // Cuando cambia el número de unidades en el carrito, este evento se dispara para guardar el cambio en la variable de session del PHP
    let target = event.target;

    let codBarras = target.parentElement.parentElement.lastChild.lastChild.lastChild.value;
    let nuevoValor = target.value;

    let datos = new FormData();
    datos.append("codigoProd", codBarras);
    datos.append("nuevasUnidades", nuevoValor);
    fetch("../php/cambiaUnidades.php", {
        method: "POST",
        body: datos,
    })

}