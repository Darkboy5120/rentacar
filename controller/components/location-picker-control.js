const LocationPickerControl = function (inputSelector, modalId, modalMapId, modalSubmitId) {
    const logMessage = {
        empty : l_arr.global.log_0,
        invalidFormat : l_arr.global.log_1,
        success : l_arr.global.log_4
    }

    let input = document.querySelector(inputSelector);
    let label = input.parentNode.parentNode.querySelector("label");
    let log = input.parentNode.parentNode.querySelector(".input-log");
    let done = false;
    let latitude = null;
    let longitude = null;

    const printLog = function (message, doneValue) {
        done = doneValue;
        log.textContent = message;
        log.classList.remove("hidden");
    }
    const hideLog = function () {
        log.classList.add("hidden");
    }
    const validate = function () {
        if (!latitude || !longitude) {
            printLog(logMessage.empty, false);
        } else {
            printLog(logMessage.success, true);
        }
    }
    const focus = () => {
        input.focus();
    }

    const getLatitude = () => {
        return latitude;
    }

    const getLongitude = () => {
        return longitude;
    }

    label.classList.add("opaque");

    let modal = {
        b_location_p: {
            object: new Modal(modalId),
            button: {
                confirm: {
                    element: document.querySelector(modalSubmitId),
                    onclick: null
                }
            }
        }
    }

    input.addEventListener("focus", e => {
        modal.b_location_p.object.show();
    });

      // Get element references
    var confirmBtn = document.querySelector(modalSubmitId);
    //var onClickPositionView = document.getElementById('onClickPositionView');
    //var onIdlePositionView = document.getElementById('onIdlePositionView');

    // Initialize locationPicker plugin
    var lp = new locationPicker(modalMapId, {
        setCurrentPosition: true, // You can omit this, defaults to true
    }, {
        zoom: 15 // You can set any google map options here, zoom defaults to 15
    });

    // Listen to button onclick event
    confirmBtn.onclick = function () {
        // Get current location and show it in HTML
        var location = lp.getMarkerPosition();
        modal.b_location_p.object.hide();
        label.classList.remove("opaque");
        latitude = location.lat;
        longitude = location.lng;
        printLog(logMessage.success, true);
        input.value = location.lat + ', ' + location.lng;
        //onClickPositionView.innerHTML = 'The chosen location is ' + location.lat + ',' + location.lng;
    };

    // Listen to map idle event, listening to idle event more accurate than listening to ondrag event
    google.maps.event.addListener(lp.map, 'idle', function (event) {
        // Get current location and show it in HTML
        var location = lp.getMarkerPosition();
        //onIdlePositionView.innerHTML = 'The chosen location is ' + location.lat + ',' + location.lng;
    });
    
    return {
        isDone : function () {
            return done;
        },
        printLog : printLog,
        element : input,
        focus: focus,
        validate: validate,
        getLatitude : getLatitude,
        getLongitude : getLongitude
    };
}