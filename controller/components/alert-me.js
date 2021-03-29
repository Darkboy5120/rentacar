const AlertMe = function (title, body) {
    let root = document.querySelector("#alert");
    if (root == null) {
        root = document.createElement("DIV");
        root.id = "alert";
        root.classList.add("alert");
        document.body.appendChild(root);
    }
    let element = null;
    const createAlert = () => {
        element = document.createElement("DIV");
        element.classList.add("alert-item");
        let alertHeader = document.createElement("DIV");
        alertHeader.classList.add("alert-header");
        let alertTitle = document.createElement("span");
        alertTitle.textContent = title;
        alertTitle.classList.add("alert-title");
        let alertCloseIcon = document.createElement("I");
        alertCloseIcon.classList.add("fas", "fa-times");
        let alertBody = document.createElement("span");
        alertBody.textContent = body;
        alertBody.classList.add("alert-body");

        alertHeader.appendChild(alertTitle);
        alertHeader.appendChild(alertCloseIcon);
        element.appendChild(alertHeader);
        element.appendChild(alertBody);
        root.appendChild(element);
    }
    const show = () => {
        element.classList.add("alert-active");
    }
    const hide = () => {
        element.classList.remove("alert-active");
    }
    const destroy = () => {
        element.classList.add("hidden");
    }
    createAlert();
    window.setTimeout(() => {
        show();
    }, 200);
    let life = 7200;

    element.querySelector(".alert-header > i").addEventListener("click", e => {
        hide();
        window.setTimeout(() => {
            destroy();
        }, 700);
    });

    window.setTimeout(() => {
        hide();
        window.setTimeout(() => {
            destroy();
        }, 700);
    }, life);
    
    return {
    };
}