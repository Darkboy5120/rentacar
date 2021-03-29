const pageName = "Ver auto";
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

/*const modalNewDriverConfirm = new Modal("#newDriverConfirm");
document.querySelector("#newDriver").addEventListener("click", e => {
    modalNewDriverConfirm.show();
});*/

const input_name = new FieldControl("#input-name", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_price = new FieldControl("#input-price", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_doors = new FieldControl("#input-doors", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_chairs = new FieldControl("#input-chairs", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_tank = new FieldControl("#input-tank", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_transmission = new FieldControl("#input-transmission", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_aircond = new FieldControl("#input-aircond", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_gps = new FieldControl("#input-gps", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_darkglass = new FieldControl("#input-darkglass", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});