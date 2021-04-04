const SwitchControl = function (switchSelector) {
    let element = document.querySelector(switchSelector);
    let label = element.parentNode.querySelector("label");
    let toggleOffElement = element.querySelector(".switch-off");
    let toggleOnElement = element.querySelector(".switch-on");
    let status = false;
    const update = () => {
        if (status) {
            toggleOffElement.classList.add("hidden");
            toggleOnElement.classList.remove("hidden");
        } else {
            toggleOffElement.classList.remove("hidden");
            toggleOnElement.classList.add("hidden");
        }
    }
    const toogleStatus = (value) => {
        if (value == undefined || typeof value != "boolean") {
            status = !status;
        } else {
            status = value;
        }
        update();
    }
    const val = () => {
        return status;
    }
    update();
    element.addEventListener("click", toogleStatus);
    label.addEventListener("click", toogleStatus);
    return {
        val: val,
        toogleStatus: toogleStatus
    };
}