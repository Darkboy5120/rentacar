const SwitchControl = function (switchSelector, options) {
    if (!options.hasOwnProperty("value")) {
        options.value = false;
    }
    let element = document.querySelector(switchSelector);
    let label = element.parentNode.querySelector("label");
    let toggleOffElement = element.querySelector(".switch-off");
    let toggleOnElement = element.querySelector(".switch-on");
    let status = false;
    let onFalseEvent = () => {};
    let onTrueEvent = () => {};
    let onUpdateEvent = () => {};
    let setOnFalseEvent = (f) => {
        onFalseEvent = f;
    }
    let setOnTrueEvent = (f) => {
        onTrueEvent = f;
    }
    let setOnUpdateEvent = (f) => {
        onUpdateEvent = f;
    }
    const update = () => {
        if (status) {
            toggleOffElement.classList.add("hidden");
            toggleOnElement.classList.remove("hidden");
            onTrueEvent();
        } else {
            toggleOffElement.classList.remove("hidden");
            toggleOnElement.classList.add("hidden");
            onFalseEvent();
        }
        onUpdateEvent();
    }
    const toggleStatus = (value) => {
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
    if (options.value == true) {
        toggleStatus();
    }
    element.addEventListener("click", toggleStatus);
    label.addEventListener("click", toggleStatus);
    return {
        val: val,
        toggleStatus: toggleStatus,
        setOnFalseEvent: setOnFalseEvent,
        setOnTrueEvent: setOnTrueEvent,
        setOnUpdateEvent: setOnUpdateEvent
    };
}