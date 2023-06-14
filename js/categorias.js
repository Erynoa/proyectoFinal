document.addEventListener("DOMContentLoaded", cargaPagina);

let liAnon = document.getElementById('espacioAnon');
let liAdmin = document.getElementById('espacioAdmin');
let liUsu = document.getElementById('espacioUsu');
let liCerrar = document.getElementById('cerrarSesion');
let liCarrito = document.getElementById('carrito');

const tipoUsuario = sessionStorage.getItem('tipoUsuario');

const formulario = document.getElementById("formularioCat");
const seccionGen = document.getElementById("catGen");
const seccionDep = document.getElementById("catDep");
const divResultados = document.getElementById("resultadoBusqueda");

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

    buscaCategorias("gen", seccionGen);
    buscaCategorias("dep", seccionDep);
}

function buscaCategorias(tipoCat, seccion)
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
            let input = document.createElement("INPUT");
            input.setAttribute("type", "checkbox");
            input.setAttribute("value", cat.codCategoria);
            input.id = "check";

            if(tipoCat == "gen")
            {
                input.setAttribute("name", "categoriasGen");
            }
            
            if(tipoCat == "dep")
            {
                input.setAttribute("name", "categoriasDep");
            }
            
            let label = document.createElement("LABEL");
            label.id = "labelCheck";
            label.appendChild(document.createTextNode(cat.nombreCat));
            

            let br = document.createElement("BR");

            seccion.appendChild(input);
            seccion.appendChild(label);
            //seccion.appendChild(br);
        }
    });
}

formulario.addEventListener("submit", function(event) {
    event.preventDefault();

    divResultados.innerHTML = "";

    let categoriasGenerales = formulario.categoriasGen; 
    let codCatGeneralesSeleccionadas = []; // Guarda los codigos de las categorias generales seleccionadas
    let categoriasDeportivas = formulario.categoriasDep;
    let codCatDeportivasSeleccionadas = []; // Guarda los codigos de las categorias deportivas seleccionadas.

    for(let cat of categoriasGenerales)
    {
        if(cat.checked)
        {
           codCatGeneralesSeleccionadas.push(cat.value); 
        }  
    }
    
    for(let cat of categoriasDeportivas)
    {
        if(cat.checked)
        {
            codCatDeportivasSeleccionadas.push(cat.value); 
        }  
    }

    let datos = new FormData();
    datos.append("catGen", codCatGeneralesSeleccionadas);
    datos.append("catDep", codCatDeportivasSeleccionadas);
    datos.append("catalogo", true);

    let row = document.createElement("div");
    row.className = "row justify-content-center";

    fetch("../php/productos.php", {
        method: "POST",
        body: datos,
    })
    .then((res) => res.json())
    .then(({productos}) => {
        if(productos.length > 0)
        {
            for(let prod of productos)
            {
                let col = document.createElement("div");
                col.className = "col col-md-5 col-lg-3 mb-4";
                let card = document.createElement("div");
                card.className = "card h-100";
                let img = document.createElement("img");

                $.ajax({
                    url: "../php/imagen.php?redirigido=3&codParaImg="+prod.codBarras,
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

                
                img.className = "card-img-top";
                img.id = "imagenCard";

                let divCardBody = document.createElement("div");
                divCardBody.className = "card-body";
                let h4 = document.createElement("h4");
                h4.textContent = prod.denominacionProd;
                let p = document.createElement("p");
                p.id = "precio";
                p.textContent = prod.precio;

                let botonDetalles = document.createElement("a");
                botonDetalles.className = 'btn btn-primary active';
                botonDetalles.role = "button";
                botonDetalles.href = "../html/detallesProducto.html?codProd="+prod.codBarras+"";
                botonDetalles.textContent = "Detalles";
                botonDetalles.id = "botonDetalles";

                divCardBody.append(h4);
                divCardBody.append(p);
                if(prod.stock == 0)
                {
                    card.style.border = "1px solid #a80202";
                    h4.style.color = "#a80202";
                    let agotado = document.createElement("p");
                    agotado.textContent = "Agotado";
                    agotado.style.fontWeight = 500;
                    agotado.style.color = "#a80202";
                    divCardBody.append(agotado);
                }
                divCardBody.append(botonDetalles);
                    
                card.append(img);
                card.append(divCardBody);
                col.append(card);
                row.append(col);
                
            }
        }
        else
        {
            let textoVacio = document.createElement("p");
            textoVacio.textContent = "Vacio";
            row.append(textoVacio);
        }
        
    });

    divResultados.append(row);

})
