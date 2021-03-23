const FieldControl = function (inputSelector, options) {
    const invalidFormatLog = "El formato es incorrecto"
    const minLengthLog = "No debe ser menor que";
    const maxLengthLog = "No debe ser mayor que ";
    const successLog = "El valor es correcto";
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

    window.addEventListener("keyup", e => {
        let valueLength = input.value.length;
        if (valueLength == 0) {
            hideLog();
            done = false;
        } else if (valueLength < options.min) {
            printLog(minLengthLog + options.min, false);
        } else if (valueLength > options.max) {
            printLog(maxLengthLog + options.max, false);
        } else if (new RegExp(options.regex).exec(input.value)) {
            printLog(invalidFormatLog, false);
        } else {
            printLog(successLog, true);
        }
    });
    
    return {

    };
}