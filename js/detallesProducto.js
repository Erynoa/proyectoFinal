document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');

const divPanelPrincipal = document.getElementById("panelDetalles");
const formularioAnadir = document.getElementById("formAnadir");

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

    // El código del producto corresponde a arraySeparadoRecibido[1]
    let codProd = arraySeparadoRecibido[1];

    let codigoProducto = new FormData();
    codigoProducto.append("codigoProducto", codProd);

    fetch("../php/buscaProducto.php", {
        method: "POST",
        body: codigoProducto,
    })
    .then((res) => res.json())
    .then(({producto}) => {
        let colImg = document.createElement("div");
        colImg.className = "col-md-6 text-center";
        let img = document.createElement("img");
        img.id = "imgProducto";

        $.ajax({
            url: "../php/imagen.php?redirigido=3&codParaImg="+producto.codBarras,
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function(data) { 
                img.src = '../img/'+data["imagen"]+'';
            },
            error: function() {
                img.src = '../img/noImg.png';
            },
        })

        colImg.append(img);
        divPanelPrincipal.append(colImg);

        let colInfo = document.createElement("div");
        colInfo.className = "col-md-6";
        colInfo.style.alignSelf = "center";

        let rowColInfo = document.createElement("div");
        rowColInfo.className = "row";

        let divColTitulo = document.createElement("div");
        divColTitulo.className = "col-12";

        let h3 = document.createElement("h3");
        h3.textContent = producto.denominacionProd;
        divColTitulo.append(h3);

        let divColDescripcion = document.createElement("div");
        divColDescripcion.className = "col-12";
        let pDescripcion = document.createElement("p");
        pDescripcion.textContent = producto.descripcionProd;
        divColDescripcion.append(pDescripcion);

        let divPrecio = document.createElement("div");
        divPrecio.className = "col-12";
        let pPrecio = document.createElement("p");
        pPrecio.id = "pPrecio";
        pPrecio.textContent = producto.precio;
        divPrecio.append(pPrecio);

        let divBotonComprarUnidades = document.createElement("div");
        divBotonComprarUnidades.className = "col-12";
        let rowColBotones = document.createElement("div");
        rowColBotones.className = "row";

        let divColUnidades = document.createElement("div");
        divColUnidades.className = "col-6";
        let inputUnidades = document.createElement("input");
        inputUnidades.name = "unidadesProducto";
        inputUnidades.type = "number";
        inputUnidades.step = "1";

        let divColBoton = document.createElement("div");
        divColBoton.className = "col-6";
        divColBoton.style.alignSelf = "center";

        if(producto.stock == 0)
        {
            inputUnidades.min = 0;
            inputUnidades.value = 0;
            let noDisp = document.createElement("p");
            noDisp.innerHTML = "No disponible";
            divColBoton.append(noDisp);
        }
        else
        {
            inputUnidades.min = 1;
            inputUnidades.value = 1;

            let inputComprar = document.createElement("input");
            inputComprar.className = "btn btn-primary active";
            inputComprar.id = "botonComprar";
            inputComprar.type = "submit";
            inputComprar.value = "Comprar";

            divColBoton.append(inputComprar);
        }
        inputUnidades.max = producto.stock;

        let labelUnidades = document.createElement("label");
        labelUnidades.textContent = "Unidades: ";
        let brUnidades = document.createElement("br");
        
        divColUnidades.append(labelUnidades);
        divColUnidades.append(brUnidades);
        divColUnidades.append(inputUnidades);

        rowColBotones.append(divColUnidades);
        rowColBotones.append(divColBoton);

        divBotonComprarUnidades.append(rowColBotones);

        rowColInfo.append(divColTitulo);
        rowColInfo.append(divColDescripcion);
        rowColInfo.append(divPrecio);
        rowColInfo.append(divBotonComprarUnidades);
        colInfo.append(rowColInfo);

        divPanelPrincipal.append(colInfo);

        // Información oculta
        let inputHiddenCodigo = document.createElement("input");
        inputHiddenCodigo.type = "hidden";
        inputHiddenCodigo.name = "codigoProducto";
        inputHiddenCodigo.value = producto.codBarras;

        let inputHiddenPrecio = document.createElement("input");
        inputHiddenPrecio.type = "hidden";
        inputHiddenPrecio.name = "precioProducto";
        inputHiddenPrecio.value = producto.precio;

        formularioAnadir.append(inputHiddenCodigo);
        formularioAnadir.append(inputHiddenPrecio);

    })

}