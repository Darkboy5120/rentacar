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
    let closeButton = element.querySelector(".modal-header > i");
    closeButton.setAttribute("title", l_arr.global.title_0);
    closeButton.addEventListener("click", e => {
        hide();
    });
    window.addEventListener("keyup", (e) => {
        if (state) {
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