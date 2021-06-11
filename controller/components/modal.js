const Modal = function (select) {
    let selector = select;
    let element = document.querySelector(selector);
    let card = element.querySelector("div");
    let state = false;
    let show = function () {
        element.classList.remove("hidden");
        document.activeElement.blur();
        let first_button = element.querySelector(".modal-body > button");
        if (first_button != null) {
            first_button.focus();
        }
        state = true;
    }
    let hide = function () {
        card.classList.add("modal-popDown");
        state = false;
        window.setTimeout(() => {
            card.classList.remove("modal-popDown");
            element.classList.add("hidden");
        }, 250);
    }
    let closeButton = element.querySelector(".modal-header > button");
    closeButton.setAttribute("title", l_arr.global.title_0);
    closeButton.addEventListener("click", e => {
        hide();
    });
    window.addEventListener("keyup", (e) => {
        if (state && e.which == 27) {
            hide();
        }
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