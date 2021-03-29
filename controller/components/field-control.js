const FieldControl = function (inputSelector, options) {
    if (!options.hasOwnProperty("not")) {
        options.not = false;
    }
    const logMessage = {
        invalidFormat : "El formato es incorrecto",
        minLength : "No debe ser menor que ",
        maxLength : "No debe ser mayor que ",
        success : "El valor es correcto"
    }
    let input = document.querySelector(inputSelector);
    let label = input.parentNode.parentNode.querySelector("label");
    let log = input.parentNode.parentNode.querySelector(".input-log");
    let done = false;

    const printLog = function (message, doneValue) {
        done = doneValue;
        log.textContent = message;
        log.classList.remove("hidden");
    }
    const hideLog = function () {
        log.classList.add("hidden");
    }
    const testRegex = function () {
        if (!options.hasOwnProperty("regex")) return false;
        let r = (new RegExp(options.regex).exec(input.value) != null)
            ? true : false;
        if (options.not) {
            r = !r;
        }
        return r;
    }
    const isEmpty = function () {
        return (input.value.length == 0) ? true : false;
    }
    const validate = function () {
        let valueLength = input.value.length;
        if (valueLength == 0) {
            hideLog();
            done = false;
            label.classList.remove("make-visible");
        } else if (valueLength < options.min) {
            printLog(logMessage.minLength + options.min, false);
        } else if (valueLength > options.max) {
            printLog(logMessage.maxLength + options.max, false);
        } else if (testRegex()) {
            printLog(logMessage.invalidFormat, false);
        } else {
            if (options.hasOwnProperty("regex")) {
                printLog(logMessage.success, true);
            }
        }
        if (valueLength > 0) {
            label.classList.add("make-visible");
        }
    }

    window.addEventListener("keyup", e => {
        if (e.which != 13) validate();
    });

    validate();
    
    return {
        isDone : function () {
            return done;
        },
        printLog : printLog,
        element : input,
        isEmpty : isEmpty
    };
}
document.querySelectorAll(".input-layout input").forEach(element => {
    element.onclick = function (event) {
        let input = event.target;
        let label = input.parentNode.classList.contains("input-field")
            ? input.parentNode.parentNode.querySelector("label")
            : input.parentNode.querySelector("label");
        label.classList.add("fade-transition");
        input.classList.add("hide-placeholder");
    }
    element.onblur = function (event) {
        let input = event.target;
        let label = input.parentNode.classList.contains("input-field")
            ? input.parentNode.parentNode.querySelector("label")
            : input.parentNode.querySelector("label");
        label.classList.remove("fade-transition");
        input.classList.remove("hide-placeholder");
    }
});