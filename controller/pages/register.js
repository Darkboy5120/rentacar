(function () {
    const userName = l_arr.welcome.txt_0;
    const pageName = l_arr.register.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    document.querySelectorAll("[data-session-variant='1']").forEach(e => {
        e.classList.add("hidden");
    });

    let form = {
        personal_info: {
            index: document.querySelector("#personal-info-index"),
            element: document.querySelector("#form-personal-info"),
            input: {
                firstname : new FieldControl("#input-firstname", {
                regex: "[^A-Za-z]+( [^A-Za-z])*$",
                min: 1,
                max: 50
                }),
                lastname: new FieldControl("#input-lastname", {
                    regex: "[^A-Za-z]+( [^A-Za-z])*$",
                    min: 1,
                    max: 50
                }),
                pass: new FieldControl("#input-pass", {
                    regex: "[^A-Za-z0-9]+",
                    min: 1,
                    max: 25
                }),
                email : new FieldControl("#input-email", {
                    regex: "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$",
                    min: 1,
                    max: 50,
                    not: true
                })
            },
            button: {
                create_car: {
                    submit : true,
                    index: document.querySelector("#bussiness-info-index"),
                    element: document.querySelector("#signup-step1"),
                    onclick: () => {
                        if (!form.personal_info.validation()) return;

                        let button = form.personal_info.button;
                        const default_text_button = button.create_car.element.innerHTML;
                        button.create_car.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.personal_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "register_admin_step1",
                            correo: input.email.element.value
                        }).then(response => {
                            button.create_car.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    form.personal_info.element.classList.add("hidden");
                                    form.personal_info.index.classList.remove("index-active");
                                    form.bussiness_info.element.classList.remove("hidden");
                                    form.bussiness_info.index.classList.add("index-active");
                                    form.bussiness_info.input.bussiness_name.element.focus();
                                    break;
                                case -3:
                                    input.email.printLog(l_arr.global.log_10, false);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.personal_info.input;
                let first_invalid_input = null;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        if (!first_invalid_input) {
                            first_invalid_input = input[name];
                        }
                        input[name].validate();
                    }
                }
                if (first_invalid_input) {
                    first_invalid_input.focus();
                }
                return (!first_invalid_input) ? true : false;
            }
        },
        bussiness_info: {
            index: document.querySelector("#bussiness-info-index"),
            element: document.querySelector("#form-bussiness-info"),
            input: {
                bussiness_name: new FieldControl("#input-bussiness-name", {
                    regex: "[^A-Za-z]+",
                    min: 1,
                    max: 50
                }),
                bussiness_phone: new FieldControl("#input-bussiness-phone", {
                    regex: "[^0-9]+",
                    min: 10,
                    max: 10
                }),
                bussiness_location: new LocationPickerControl("#input-bussiness-location",
                    "#b-location-p", "b-location-p-map", "#b-location-p-confirm")
            },
            button: {
                signup_step2: {
                    submit : true,
                    element: document.querySelector("#signup-step2"),
                    onclick: () => {
                        if (!form.bussiness_info.validation()) return;
                        let button = form.bussiness_info.button;
                        const default_text_button = button.signup_step2.element.innerHTML;
                        button.signup_step2.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input_s1 = form.personal_info.input;
                        let input_s2 = form.bussiness_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "register_admin_step2",
                            nombre: input_s1.firstname.element.value,
                            apellido: input_s1.lastname.element.value,
                            telefono: input_s2.bussiness_phone.element.value,
                            correo: input_s1.email.element.value,
                            contraseña: input_s1.pass.element.value,
                            nombre_empresa: input_s2.bussiness_name.element.value,
                            longitud_empresa: input_s2.bussiness_location.getLongitude(),
                            latitud_empresa: input_s2.bussiness_location.getLatitude()
                        }).then(response => {
                            console.log(response);
                            button.signup_step2.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.register.mdal_suc_b_0);
                                    window.setTimeout(() => {
                                        location = "?p=home";
                                    }, 4000);
                                    break;
                                case -3:
                                    input_s2.bussiness_phone.printLog(l_arr.global.log_18, false);
                                    break;
                                case -6:
                                    input_s2.bussiness_name.printLog(l_arr.global.log_11, false);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                },
                to_personal_info: {
                    element: document.querySelector("#to-personal-info"),
                    onclick: () => {
                        form.personal_info.element.classList.remove("hidden");
                        form.personal_info.index.classList.add("index-active");
                        form.bussiness_info.element.classList.add("hidden");
                        form.bussiness_info.index.classList.remove("index-active");
                        form.personal_info.input.pass.element.focus();
                    }
                }
            },
            validation: () => {
                if (!form.personal_info.validation()) return false;
                let input = form.bussiness_info.input;
                let first_invalid_input = null;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        if (!first_invalid_input) {
                            first_invalid_input = input[name];
                        }
                        input[name].validate();
                    }
                }
                if (first_invalid_input) {
                    first_invalid_input.focus();
                }
                return (!first_invalid_input) ? true : false;
            }
        }
    }

    for (const fname in form) {
        let button = form[fname].button;
        for (const bname in button) {
            button[bname].element.addEventListener("click", button[bname].onclick);
            if (button[bname].submit) {
                let input = form[fname].input;
                for (const iname in input) {
                    input[iname].element.addEventListener("keydown", e => {
                        if (e.which == 13) {
                            button[bname].onclick();
                        }
                    });
                }
            }
        }

    }

    hideLoadingScreen();
})();
