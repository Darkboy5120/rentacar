const pageName = "Conductores";
document.querySelector("title").textContent = "Rentacar | " + pageName;
document.querySelectorAll("[data-location]").forEach(element => {
    element.textContent = pageName;
});
var slideRight = {
delay: 500,
distance: '100%',
origin: 'left',
opacity: null,
afterReveal: el => {
    document.querySelector(".fixed-location").classList.add("slide-left-fl");
}
};

ScrollReveal().reveal('.fixed-location', slideRight);

const modalNewDriverConfirm = new Modal("#newDriverConfirm");
const modalDriverCode = new Modal("#newDriverCode");
const modalDriverOptions = new Modal("#driverOptions");
document.querySelector("#newDriver").addEventListener("click", e => {
    modalNewDriverConfirm.show();
});
document.querySelector("#newDriverGen").addEventListener("click", e => {
    modalNewDriverConfirm.hide();
    modalDriverCode.show();
});
document.querySelectorAll(".card-sale").forEach(element => {
    element.addEventListener("click", event => {
        modalDriverOptions.show();
    });
});
document.querySelector("#searchAction").addEventListener("click", e => {
    document.querySelector("#searchAction").querySelector("input").focus();
});