const Modal = function (select) {
    let selector = select;
    let element = document.querySelector(selector);
    let state = false;
    let show = function () {
        element.classList.remove("hidden");
        state = true;
    }
    let hide = function () {
        element.classList.add("hidden");
        state = false;
    }
    let closeButton = element.querySelector("div > .modal-header > i");
    closeButton.addEventListener("click", e => {
        hide();
    });
    element.addEventListener("click", e => {
        if (e.target.classList.contains("modal")) {
            hide();
        }
    });
    return {
        show : show,
        hide : hide,
        element: element
    };
}