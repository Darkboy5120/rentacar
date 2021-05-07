(function () {
    const pageName = l_arr.profile.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    document.querySelector("#n_dd_profile_tab").classList.add("dropdown-active");
    
    hideLoadingScreen();

    const form = {
        personal_info: {
            element: document.querySelector("#personal-info"),
            input: {
                firstname: new FieldControl("#input-firstname", {
                    regex : "[^A-Za-z]+( [^A-Za-z])*$", min : 1, max : 25
                }),
                lastname: new FieldControl("#input-lastname", {
                    regex : "[^A-Za-z]+( [^A-Za-z])*$", min : 1, max : 25
                })
            },
            button: {
                save_personal_info: {
                    element: document.querySelector("#save-personal-info"),
                    submit: true,
                    onclick: () => {
                        if (!form.personal_info.validation()) return;
                        let button = form.personal_info.button;
                        const default_text_button = button.save_personal_info.element.innerHTML;
                        button.save_personal_info.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.personal_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "edit_admin_personal_info",
                            firstname: input.firstname.element.value,
                            lastname: input.lastname.element.value
                        }).catch(err => {
                            new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                        }).then(response => {
                            button.save_personal_info.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    userName = input.firstname.element.value;
                                    document.querySelectorAll("[data-username]").forEach(e => {
                                        e.textContent = userName;
                                    });
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.global.mdal_suc_b_3);
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
                for (const name in input) {
                    if (!input[name].isDone()) {
                        input[name].focus();
                        return false;
                    }
                }
                return true;
            }
        },
        bussiness_info: {
            element: document.querySelector("#bussiness-info"),
            input: {
                name: new FieldControl("#input-bussinessname", {
                    regex : "[^A-Za-z]+", min : 1, max : 25
                }),
                phone: new FieldControl("#input-phone", {
                    regex : "[^0-9]+", min : 10, max : 10
                })
            },
            button: {
                save_bussiness_info: {
                    element: document.querySelector("#save-bussiness-info"),
                    submit: true,
                    onclick: () => {
                        if (!form.bussiness_info.validation()) return;
                        let button = form.bussiness_info.button;
                        const default_text_button = button.save_bussiness_info.element.innerHTML;
                        button.save_bussiness_info.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.bussiness_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "edit_admin_bussiness_info",
                            name: input.name.element.value,
                            phone: input.phone.element.value
                        }).catch(err => {
                            new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                        }).then(response => {
                            button.save_bussiness_info.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.global.mdal_suc_b_4);
                                    break;
                                case -4:
                                    form.bussiness_info.input.name.printLog(l_arr.global.log_11, false);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.bussiness_info.input;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        input[name].focus();
                        return false;
                    }
                }
                return true;
            }
        },
        preferences_info: {
            element: document.querySelector("#preferences_info"),
            input: {
            },
            select: {
                coin: new FieldControl("#input-coin", {}),
                language: new FieldControl("#input-language", {})
            },
            button: {
                save_preferences_info: {
                    element: document.querySelector("#save-preferences-info"),
                    submit: true,
                    onclick: () => {
                        if (!form.preferences_info.validation()) return;
                        let button = form.preferences_info.button;
                        const default_text_button = button.save_preferences_info.element.innerHTML;
                        button.save_preferences_info.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let select = form.preferences_info.select;
                        document.cookie = "l=" + select.language.element.value;
                        document.cookie = "c=" + select.coin.element.value;
                        button.save_preferences_info.element.innerHTML = default_text_button;
                        new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.global.mdal_suc_b_6);
                        window.setTimeout(() => {
                            location = location;
                        }, 4000);
                    }
                }
            },
            validation: () => {
                return true;
            }
        },
        password_info: {
            element: document.querySelector("#password-info"),
            input: {
                passold: new FieldControl("#input-passold", {
                    regex : "[^A-Za-z0-9]+", min : 1, max : 25
                }),
                pass: new FieldControl("#input-pass", {
                    regex : "[^A-Za-z0-9]+", min : 1, max : 25
                })
            },
            button: {
                save_password_info: {
                    element: document.querySelector("#save-password-info"),
                    submit: true,
                    onclick: () => {
                        if (!form.password_info.validation()) return;
                        let button = form.password_info.button;
                        const default_text_button = button.save_password_info.element.innerHTML;
                        button.save_password_info.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.password_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "edit_user_password",
                            passold: input.passold.element.value,
                            passnew: input.pass.element.value
                        }).catch(err => {
                            new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                        }).then(response => {
                            button.save_password_info.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    form.password_info.input.passold.element.value = "";
                                    form.password_info.input.pass.element.value = "";
                                    document.activeElement.blur();
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.global.mdal_suc_b_5);
                                    break;
                                case -3:
                                    input.passold.printLog(l_arr.global.log_12, false);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.password_info.input;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        input[name].focus();
                        return false;
                    }
                }
                if (input.passold.element.value == input.pass.element.value) {
                    input.pass.printLog(l_arr.global.log_14, false);
                    return false;
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
                    if (input[iname].element) {
                        input[iname].element.addEventListener("keyup", e => {
                            if (e.which == 13) {
                                button[bname].onclick();
                            }
                        });
                    }
                }
            }
        }

    }

    for (let opt of form.preferences_info.select.language.element.options) {
        if (opt.value == userLanguage) {
            form.preferences_info.select.language.element.selectedIndex = opt.index;
        }
    }
    for (let opt of form.preferences_info.select.coin.element.options) {
        if (opt.value == userCurrency) {
            form.preferences_info.select.coin.element.selectedIndex = opt.index;
        }
    }

    let request = {
        get_admin_info: new Promise((resolve, reject) => {
            new RequestMe().post("model/apis/", {
                api: "get_admin_info"
            }).catch(err => {
                reject();
            }).then(response => {
                switch (response.code) {
                    case 0:
                        let admin_info = response.data;
                        form.personal_info.input.firstname.element.value = admin_info.nombre;
                        form.personal_info.input.lastname.element.value = admin_info.apellido;
                        document.querySelector("#input-email").value = admin_info.correo;
                        form.bussiness_info.input.name.element.value = admin_info.nombre_empresa;
                        form.bussiness_info.input.phone.element.value = admin_info.telefono;

                        for (let fname in form) {
                            if (fname == "global") continue;
                            for (let iname in form[fname].input) {
                                form[fname].input[iname].validate();
                            }
                        }

                        resolve(response.code);
                        break;
                    default:
                        new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
                        reject();
                }
            });
        })
    }
})();