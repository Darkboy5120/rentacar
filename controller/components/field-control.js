const FieldControl = function (inputSelector, options) {
    if (!options.hasOwnProperty("not")) {
        options.not = false;
    }
    if (!options.hasOwnProperty("disabled")) {
        options.disabled = false;
    }
    if (!options.hasOwnProperty("optional")) {
        options.disabled = false;
    }
    const plural = l_arr.global.log_16;
    const singular = l_arr.global.log_17;
    const logMessage = {
        empty : l_arr.global.log_0,
        invalidFormat : l_arr.global.log_1,
        minLength : l_arr.global.log_2 + options.min + ((options.min > 1)
            ? plural : singular),
        maxLength : l_arr.global.log_3 + options.max + ((options.max > 1)
        ? plural : singular),
        success : l_arr.global.log_4
    }

    let input = document.querySelector(inputSelector);
    let label = input.parentNode.parentNode.querySelector("label");
    let log = input.parentNode.parentNode.querySelector(".input-log");
    let done = false;
    let input_type = input.getAttribute("type") || null;

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
        if (input_type == "password") {
            let input_icon_visibility = (valueLength > 0) ? "remove" : "add";
            input.parentNode.querySelectorAll("[data-toggle-pass]").forEach(e => {
                e.classList[input_icon_visibility]("invisible");
            });
        }
        if (valueLength == 0 && !options.optional) {
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
    const toggleDisabled = () => {
        if (options.disabled) {
            input.removeAttribute("disabled");
        } else {
            input.setAttribute("disabled", "foo");
        }
        options.disabled = !options.disabled;
    }
    const getValue = () => {
        return (options.disabled) ? "" : input.value
    }

    input.addEventListener("keyup", e => {
        //this should detect only simbols characters not space or shortcuts keys
        if (e.which != 13 && e.which != 9) validate();
    });

    if (options.disabled) {
        input.setAttribute("disabled", "foo");
    }

    if (input.tagName != "SELECT") {
        label.classList.add("opaque");
        input.addEventListener("focus", e => {
            label.classList.remove("opaque");
            input.classList.add("hide-placeholder");
        });
        input.addEventListener("blur", e => {
            if (isEmpty()) {
                label.classList.add("opaque");
            }
            input.classList.remove("hide-placeholder");
        });
    }

    if (input_type == "password") {
        input.parentNode.querySelectorAll("[data-toggle-pass]").forEach(e => {
            e.addEventListener("click", event => {
                let data_att = event.target.getAttribute("data-toggle-pass");
                if (data_att == "0") {
                    event.target.classList.add("hidden");
                    event.target.nextElementSibling.classList.remove("hidden");
                    event.target.parentNode.querySelector("input").setAttribute("type", "text");
                } else {
                    event.target.classList.add("hidden");
                    event.target.previousElementSibling.classList.remove("hidden");
                    event.target.parentNode.querySelector("input").setAttribute("type", "password");
                }
            });
        });
    }

    //validate();
    
    return {
        isDone : function () {
            if (isEmpty() && options.optional) {
                return true;
            };
            return done;
        },
        printLog : printLog,
        element : input,
        isEmpty : isEmpty,
        focus : focus,
        validate : validate,
        toggleDisabled : toggleDisabled,
        getValue : getValue
    };
}