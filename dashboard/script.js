function setActiveLink(clickedLink, active = true) {
    var navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(function(link) {
        link.classList.remove("active");
    });

    if (active) {
        clickedLink.classList.add("active");
    }
}

window.addEventListener('load', function() {
    var rutinaLink = document.querySelector('.a-rutina');
    setActiveLink(rutinaLink);
});

function setActiveButton(clickedLink) {
    var Buttons = document.querySelectorAll(".tab");
    Buttons.forEach(function(btn) {
        btn.classList.remove("color");
    });

    clickedLink.classList.add("color");
}

var rangoPrecio = document.getElementById("rangoPrecio");
var rangoPrecioValor = document.getElementById("rangoPrecioValor");

rangoPrecio.addEventListener("input", function() {
    rangoPrecioValor.textContent = "$" + this.value;
});

var productos = [{
        nombre: "camiseta",
        imagen: "../images/camiseta.jpg",
        precio: 20.0,
    },
    {
        nombre: "licras",
        imagen: "../images/licras.jpg",
        precio: 30.0,
    },
    {
        nombre: "sudaderas",
        imagen: "../images/sudadera.jpg",
        precio: 25.0,
    },
    {
        nombre: "suplementos",
        imagen: "../images/suplementos.jpg",
        precio: 20.0,
    },
    {
        nombre: "mancuernas",
        imagen: "../images/mancuernas.jpg",
        precio: 30.0,
    },
    {
        nombre: "tennis",
        imagen: "../images/zapatos.jpg",
        precio: 25.0,
    },
];

function mostrarProductos(productosAMostrar) {
    var listaProductos = document.getElementById("listaProductos");
    var carrusel = document.getElementById("resultadosProductos");
    var mensaje = document.getElementById("mensajeNoProductos");

    if (productosAMostrar.length === 0) {
        mensaje.style.display = "block";
        carrusel.style.display = "none";
        return;
    } else {
        mensaje.style.display = "none";
        carrusel.style.display = "block";
    }

    listaProductos.innerHTML = "";

    for (var i = 0; i < productosAMostrar.length; i += 3) {
        var divCarouselItem = document.createElement("div");
        divCarouselItem.classList.add("carousel-item");
        if (i === 0) {
            divCarouselItem.classList.add("active");
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row");

        for (var j = i; j < i + 3 && j < productosAMostrar.length; j++) {
            var producto = productosAMostrar[j];
            var divProducto = document.createElement("div");
            divProducto.classList.add("col-md-4");

            var divCardBody = document.createElement("div");
            divCardBody.classList.add("carte", "mb-4", "text-center", "h-100");

            var imgProducto = document.createElement("img");
            imgProducto.classList.add("card-img-top");
            imgProducto.style.borderRadius = "20px";
            imgProducto.src = producto.imagen;
            imgProducto.alt = producto.nombre;

            var divCardBodyInner = document.createElement("div");
            divCardBodyInner.classList.add(
                "card-body",
                "d-flex",
                "flex-column",
                "justify-content-between"
            );

            var h5Producto = document.createElement("h5");
            h5Producto.classList.add("card-title");
            h5Producto.textContent = producto.nombre;

            var pPrecio = document.createElement("p");
            pPrecio.classList.add("card-text");
            pPrecio.textContent = "Precio: $" + producto.precio.toFixed(2);

            var btnComprar = document.createElement("button");
            btnComprar.classList.add("btn", "btn-primary", "mt-4");
            btnComprar.textContent = "Buy";
            btnComprar.addEventListener(
                "click",
                (function(producto) {
                    return function() {
                        var telefono = "3155748135";
                        var mensaje =
                            "¡Hola! Estoy interesado en comprar el producto " +
                            producto.nombre +
                            ". ¿Está disponible?";
                        var url =
                            "https://api.whatsapp.com/send?phone=" +
                            telefono +
                            "&text=" +
                            encodeURIComponent(mensaje);
                        window.open(url, "_blank");
                    };
                })(producto)
            );

            divCardBodyInner.appendChild(h5Producto);
            divCardBodyInner.appendChild(pPrecio);
            divCardBodyInner.appendChild(btnComprar);
            divCardBody.appendChild(imgProducto);
            divCardBody.appendChild(divCardBodyInner);
            divProducto.appendChild(divCardBody);
            divRow.appendChild(divProducto);
        }

        divCarouselItem.appendChild(divRow);
        listaProductos.appendChild(divCarouselItem);
    }
}

mostrarProductos(productos);

document.getElementById("buscador").addEventListener("input", function() {
    var filtro = this.value.toLowerCase();
    var productosFiltrados = productos.filter(function(producto) {
        return producto.nombre.toLowerCase().includes(filtro);
    });
    mostrarProductos(productosFiltrados);
});

document.getElementById("rangoPrecio").addEventListener("input", function() {
    var precioMaximo = parseFloat(this.value);
    var productosFiltrados = productos.filter(function(producto) {
        return producto.precio <= precioMaximo;
    });
    mostrarProductos(productosFiltrados);
});

const toggleButtons = document.querySelectorAll('.toggle-details');

toggleButtons.forEach(button => {
    button.addEventListener('click', () => {
        const details = button.nextElementSibling;

        if (details.style.display === 'none' || details.style.display === '') {
            details.style.display = 'block';
            button.textContent = 'Cancelar';
        } else {
            details.style.display = 'none';
            button.textContent = 'Agregar nuevo material';
        }
    });
});

function enableInput(input) {
    input.removeAttribute('readonly');
}

var inputs = document.querySelectorAll('input[type="number"]');

inputs.forEach(function(input) {
    input.addEventListener('input', function() {
        var valor = this.value.trim();
        var soloNumeros = valor.replace(/[^0-9]/g, '');
        this.value = soloNumeros;
    });
});

function openTab(tabName) {
    var i, tabContent;
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "flex";
}

window.addEventListener('load', function() {
    if (window.location.href.indexOf('#calendar') !== -1) {
        var calendarLink = document.querySelector('.a-calendar');
        setActiveLink(calendarLink);
        openTab('container-calendario');
    }
});

window.addEventListener('load', function() {
    if (window.location.href.indexOf('#info') !== -1) {
        var calendarLink = document.querySelector('.buton-info');
        setActiveLink(calendarLink);
        openTab('info');
    }
});
