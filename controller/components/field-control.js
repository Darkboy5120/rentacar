const FieldControl = function (inputSelector, options) {
    if (!options.hasOwnProperty("not")) {
        options.not = false;
    }
    const plural = " caracteres";
    const singular = " caracter";
    const logMessage = {
        empty : "Completa este campo",
        invalidFormat : "El formato es incorrecto",
        minLength : "No debe tener menos de " + options.min + ((options.min > 1)
            ? plural : singular),
        maxLength : "No debe ser más de " + options.max + ((options.max > 1)
        ? plural : singular),
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
            //hideLog();
            //done = false;
            printLog(logMessage.empty, false);
            //label.classList.remove("make-visible");
        } else if (valueLength < options.min) {
            printLog(logMessage.minLength, false);
        } else if (valueLength > options.max) {
            printLog(logMessage.maxLength, false);
        } else if (testRegex()) {
            printLog(logMessage.invalidFormat, false);
        } else {
            if (options.hasOwnProperty("regex")) {
                printLog(logMessage.success, true);
            } else if (log != null) {
                hideLog();
            }
        }
        if (valueLength > 0 && input.tagName != "SELECT") {
            label.classList.remove("opaque");
        }
    }
    const focus = () => {
        input.focus();
    }

    input.addEventListener("keyup", e => {
        if (e.which != 13) validate();
    });

    if (input.tagName != "SELECT") {
        label.classList.add("opaque");
    }
    input.addEventListener("focus", e => {
        label.classList.remove("opaque");
        input.classList.add("hide-placeholder");
    });
    input.addEventListener("blur", e => {
        label.classList.add("opaque");
        input.classList.remove("hide-placeholder");
    });

    validate();
    
    return {
        isDone : function () {
            return done;
        },
        printLog : printLog,
        element : input,
        isEmpty : isEmpty,
        focus: focus
    };
}