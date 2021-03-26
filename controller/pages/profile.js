const pageName = "Perfil";
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

const input_firstname = new FieldControl("#input-firstname", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_lastname = new FieldControl("#input-lastname", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_email = new FieldControl("#input-email", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_bussinessname = new FieldControl("#input-bussinessname", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_phone = new FieldControl("#input-phone", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_passold = new FieldControl("#input-passold", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_pass = new FieldControl("#input-pass", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});
const input_passconfirm = new FieldControl("#input-passconfirm", {
    regex : "[^A-Za-z]+", min : 1, max : 25
});