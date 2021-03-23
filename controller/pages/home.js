const pageName = "Home";
document.querySelector("title").textContent = "Rentacar | " + pageName;
document.querySelectorAll("[data-location]").forEach(element => {
    element.textContent = pageName;
});

ScrollReveal().reveal('.card-car', {
    delay: 175,
    duration: 500,
    reset: true,
    scale: 0.85
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

const modalCarOptions = new Modal("#carOptions");
document.querySelectorAll(".card-car > i").forEach(element => {
    element.addEventListener("click", event => {
        modalCarOptions.show();
    });
});