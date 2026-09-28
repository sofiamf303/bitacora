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