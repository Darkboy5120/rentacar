const pageName = "Ventas";
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