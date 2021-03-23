document.querySelectorAll(".input-layout input").forEach(element => {
    element.onclick = function (event) {
        let input = event.target;
        let label = input.parentNode.parentNode.querySelector("label");
        label.classList.add("fade-transition");
        input.classList.add("hide-placeholder");
    }
});
document.querySelectorAll(".input-layout input").forEach(element => {
    element.onblur = function (event) {
        let input = event.target;
        let label = input.parentNode.parentNode.querySelector("label");
        label.classList.remove("fade-transition");
        input.classList.remove("hide-placeholder");
    }
});
input_firstname = new FieldControl("#firstname", {
    regex : "[^A-Za-z]+",
    min : 1,
    max : 25
});