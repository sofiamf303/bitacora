const formatoCOP = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    maximumFractionDigits: 0
});

/* 1. Producto más caro */
const productoMasCaro = productos
    .sort((a, b) => b.precio - a.precio)[0];

console.log("Producto más caro:");
console.log(productoMasCaro.nombre, formatoCOP.format(productoMasCaro.precio));


/* 2. Total de unidades por categoría */
const unidadesPorCategoria = productos.reduce((resultado, producto) => {
    resultado[producto.categoria] =
        (resultado[producto.categoria] || 0) + producto.stock;

    return resultado;
}, {});

console.log("Unidades por categoría:");
console.table(unidadesPorCategoria);


/* 3. Productos con stock menor a 5 */
const stockBajo = productos
    .filter(producto => producto.stock < 5)
    .map(producto => ({
        nombre: producto.nombre,
        stock: producto.stock
    }));

console.log("Productos con stock menor a 5:");
console.table(stockBajo);


/* 4. Promedio de precio */
const promedioPrecio = productos
    .map(producto => producto.precio)
    .reduce((total, precio) => total + precio, 0) / productos.length;

console.log("Promedio de precio:");
console.log(formatoCOP.format(promedioPrecio));


/*
   DÍA 8 - DOM E INTERACCIÓN */

/* Tabla de productos */

const tablaProductos = document.querySelector("#tablaProductos");
const buscador = document.querySelector("#buscador");


function pintarTabla(lista) {

    tablaProductos.textContent = "";

    const fragmento = document.createDocumentFragment();

    lista.forEach(producto => {

        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${producto.id}</td>
            <td>${producto.nombre}</td>
            <td>${producto.categoria}</td>
            <td>${formatoCOP.format(producto.precio)}</td>
            <td>${producto.stock}</td>
            <td>
                <button
                    type="button"
                    class="btn btn-secundario"
                    data-id="${producto.id}"
                    data-accion="editar"
                >
                    Editar
                </button>

                <button
                    type="button"
                    class="btn btn-peligro"
                    data-id="${producto.id}"
                    data-accion="eliminar"
                >
                    Eliminar
                </button>
            </td>
        `;

        fragmento.append(fila);
    });

    tablaProductos.append(fragmento);
}

/* Pintar los productos inicialmente */

if (tablaProductos) {
    pintarTabla(productos);
}


if (buscador && tablaProductos) {

    buscador.addEventListener("input", () => {

        const texto = buscador.value.toLowerCase();

        const resultados = productos.filter(producto =>
            producto.nombre.toLowerCase().includes(texto) ||
            producto.categoria.toLowerCase().includes(texto)
        );

        pintarTabla(resultados);
    });

}


/* Delegación de eventos en la tabla */

tablaProductos.addEventListener("click", event => {

    const boton = event.target.closest("button");

    if (!boton) {
        return;
    }

    const id = Number(boton.dataset.id);
    const accion = boton.dataset.accion;

    const producto = productos.find(producto => producto.id === id);

    if (accion === "editar") {
        console.log("Editar producto:", producto);
    }

    if (accion === "eliminar") {
        console.log("Eliminar producto:", producto);
    }
});


/* 
   MENÚ LATERAL
  */

const botonMenu = document.querySelector(".boton-menu");
const menuLateral = document.querySelector(".menu-lateral");

if (botonMenu) {

    botonMenu.addEventListener("click", () => {
        menuLateral.classList.toggle("abierto");
    });

    botonMenu.addEventListener("keydown", event => {

        if (event.key === "Enter") {
            menuLateral.classList.toggle("abierto");
        }

    });
}


/* 
   VALIDACIÓN DEL FORMULARIO */
  

const formProducto = document.querySelector("#formProducto");

if (formProducto) {

    const nombre = document.querySelector("#nombre");
    const categoria = document.querySelector("#categoria");
    const precio = document.querySelector("#precio");
    const stock = document.querySelector("#stock");

    const errorNombre = document.querySelector("#errorNombre");
    const errorCategoria = document.querySelector("#errorCategoria");
    const errorPrecio = document.querySelector("#errorPrecio");
    const errorStock = document.querySelector("#errorStock");


    formProducto.addEventListener("submit", event => {

        event.preventDefault();

        let formularioValido = true;


        /* Nombre */

        errorNombre.textContent = "";

        if (nombre.value.trim().length < 3) {
            errorNombre.textContent =
                "El nombre debe tener mínimo 3 caracteres.";
            formularioValido = false;
        }


        /* Categoría */

        errorCategoria.textContent = "";

        if (categoria.value === "") {
            errorCategoria.textContent =
                "Debes seleccionar una categoría.";
            formularioValido = false;
        }


        /* Precio */

        errorPrecio.textContent = "";

        if (precio.value <= 0) {
            errorPrecio.textContent =
                "El precio debe ser mayor que cero.";
            formularioValido = false;
        }


        /* Stock */

        errorStock.textContent = "";

        if (
            stock.value === "" ||
            Number(stock.value) < 0 ||
            !Number.isInteger(Number(stock.value))
        ) {
            errorStock.textContent =
                "El stock debe ser un entero no negativo.";
            formularioValido = false;
        }


        if (formularioValido) {
            console.log("Formulario válido.");
        }

    });

}
