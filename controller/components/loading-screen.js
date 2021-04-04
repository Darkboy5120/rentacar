let lsMsg = ["Ya casi llegamos...", "Cambiando neumatico...", "Enserando auto...",
        "Limpiando ventanas...", "Arrancando el motor...", "Buscando las llaves...",
        "Abrochando cinturón de seguridad"];
const getLoadingScreenMsg = () => {
    return lsMsg[Math.floor(Math.random() * (lsMsg.length-1))];
}
var slideRight = {
    delay: 500,
    distance: '100%',
    origin: 'left',
    opacity: null,
    afterReveal: el => {
        document.querySelector(".fixed-location").classList.add("slide-left-fl");
    }
};
let loadingScreen = document.querySelector("#loading-screen");
loadingScreen.querySelector("p").textContent = getLoadingScreenMsg();
const hideLoadingScreen = () => {
    window.setTimeout(() => {
        loadingScreen.classList.add("loading-screen-done");
        ScrollReveal().reveal('.fixed-location', slideRight);
        window.setTimeout(() => {
            loadingScreen.classList.add("hidden");
        }, 300);
    }, 1000);
}