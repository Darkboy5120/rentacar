(function () {
    let form = {
        personal_info: {
            index: document.querySelector("#personal-info-index"),
            element: document.querySelector("#form-personal-info"),
            input: {
                firstname : new FieldControl("#input-firstname", {
                regex: "[^A-Za-z]+",
                min: 1,
                max: 50
                }),
                lastname: new FieldControl("#input-lastname", {
                    regex: "[^A-Za-z]+",
                    min: 1,
                    max: 50
                }),
                pass: new FieldControl("#input-pass", {
                    regex: "[^A-Za-z0-9]+",
                    min: 1,
                    max: 25
                }),
                confirm_pass: new FieldControl("#input-confirm-pass", {
                    regex: "[^A-Za-z0-9]+",
                    min: 1,
                    max: 25
                })
            },
            button: {
                create_car: {
                    submit : true,
                    index: document.querySelector("#bussiness-info-index"),
                    element: document.querySelector("#signup-step1"),
                    onclick: () => {
                        if (!form.personal_info.validation()) return;
                        form.personal_info.element.classList.add("hidden");
                        form.personal_info.index.classList.remove("index-active");
                        form.bussiness_info.element.classList.remove("hidden");
                        form.bussiness_info.index.classList.add("index-active");
                        form.bussiness_info.input.bussiness_name.element.focus();
                    }
                }
            },
            validation: () => {
                let input = form.personal_info.input;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        input[name].focus();
                        return false;
                    }
                }
                if (input.pass.element.value != input.confirm_pass.element.value) {
                    input.pass.printLog(l_arr.global.log_9, false);
                    return false;
                }
                return true;
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
                bussiness_email : new FieldControl("#input-bussiness-email", {
                    regex: "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$",
                    min: 1,
                    max: 50,
                    not: true
                })
            },
            button: {
                signup_step2: {
                    submit : true,
                    element: document.querySelector("#signup-step2"),
                    onclick: () => {
                        if (!form.bussiness_info.validation()) return;
                        let input_s1 = form.personal_info.input;
                        let input_s2 = form.bussiness_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "register_admin_step2",
                            nombre: input_s1.firstname.element.value,
                            apellido: input_s1.lastname.element.value,
                            telefono: input_s2.bussiness_phone.element.value,
                            correo: input_s2.bussiness_email.element.value,
                            contraseña: input_s1.pass.element.value,
                            nombre_empresa: input_s2.bussiness_name.element.value
                        }).then(response => {
                            switch (response.code) {
                                case 0:
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.register.mdal_suc_b_0);
                                    window.setTimeout(() => {
                                        location = "?p=home";
                                    }, 4000);
                                    break;
                                case -3:
                                    input_s2.bussiness_email.printLog(l_arr.global.log_10, false);
                                    break;
                                case -6:
                                    input_s2.bussiness_email.printLog(l_arr.global.log_11, false);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t0, l_arr.global.mdal_err.b_1);
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
                        form.personal_info.input.confirm_pass.element.focus();
                    }
                }
            },
            validation: () => {
                if (!form.personal_info.validation()) return false;
                let input = form.bussiness_info.input;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        input[name].focus();
                        return false;
                    }
                }
                return true;
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
                    input[iname].element.addEventListener("keyup", e => {
                        if (e.which == 13) {
                            button[bname].onclick();
                        }
                    });
                }
            }
        }

    }
})();
