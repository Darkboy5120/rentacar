(function () {
    const pageName = l_arr.newdriver.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });

    let form = {
        global: {
            button: {
            }
        },
        driver_info: {
            element: document.querySelector("#form-car-info"),
            input: {
                firstname: new FieldControl("#input-firstname", {
                    regex : "[^A-Za-z]+( [^A-Za-z])*$", min : 1, max : 25
                }),
                lastname: new FieldControl("#input-lastname", {
                    regex : "[^A-Za-z]+( [^A-Za-z])*$", min : 1, max : 25
                }),
                phone: new FieldControl("#input-phone", {
                    regex : "[^0-9]+", min : 10, max : 10
                }),
                email : new FieldControl("#input-email", {
                    regex: "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$",
                    min: 1, max: 50, not: true
                }),
                pass: new FieldControl("#input-pass", {
                    regex : "[^A-Za-z0-9]+", min : 1, max : 25
                }),
                profile_image: new FileControl("#input-profile-image", {
                    min: 1, max: 1
                })
            },
            button: {
                create_driver: {
                    submit : true,
                    element: document.querySelector("#create-driver"),
                    onclick: () => {
                        if (!form.driver_info.validation()) return;
                        let button = form.driver_info.button;
                        const default_text_button = button.create_driver.element.innerHTML;
                        button.create_driver.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.driver_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "create_driver",
                            nombre: input.firstname.element.value,
                            apellido: input.lastname.element.value,
                            telefono: input.phone.element.value,
                            correo: input.email.element.value,
                            contraseña: input.pass.element.value,
                            conductor_imagen: input.profile_image.val()[0],
                        }).then(response => {
                            button.create_driver.element.innerHTML = default_text_button;
                            console.log(response);
                            switch (response.code) {
                                case 0:
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.global.mdal_suc_b_7);
                                    window.setTimeout(() => {
                                        location = "?p=drivers";
                                    }, 4000);
                                    break;
                                case -3:
                                    input.email.printLog(l_arr.global.log_10, false);
                                    break;
                                case -4:
                                    input.email.printLog(l_arr.global.log_18, false);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.driver_info.input;
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
    };

    for (const fname in form) {
        let button = form[fname].button;
        for (const bname in button) {
            button[bname].element.addEventListener("click", button[bname].onclick);
            if (button[bname].submit) {
                let input = form[fname].input;
                for (const iname in input) {
                    if (input[iname].element) {
                        input[iname].element.addEventListener("keydown", e => {
                            if (e.which == 13) {
                                button[bname].onclick();
                            }
                        });
                    }
                }
            }
        }

    }

    hideLoadingScreen();
})();