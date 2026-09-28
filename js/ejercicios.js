
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
