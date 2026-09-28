const botonMenu = document.querySelector(".boton-menu");
const menuLateral = document.querySelector(".menu-lateral");

if (botonMenu && menuLateral) {

    botonMenu.addEventListener("click", () => {
        menuLateral.classList.toggle("abierto");
    });

    botonMenu.addEventListener("keydown", event => {

        if (event.key === "Enter") {
            menuLateral.classList.toggle("abierto");
        }

    });
}