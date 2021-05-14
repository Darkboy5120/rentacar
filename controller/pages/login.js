(function () {
    const userName = l_arr.welcome.txt_0;
    const pageName = l_arr.login.page_name;
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
        login_info: {
            element: document.querySelector("#login-info"),
            input: {
                email : new FieldControl("#input-email", {}),
                pass : new FieldControl("#input-pass", {})
            },
            button: {
                signin: {
                    submit : true,
                    element: document.querySelector("#signin"),
                    onclick: () => {
                        if (!form.login_info.validation()) return;
                        let button = form.login_info.button;
                        const default_text_button = button.signin.element.innerHTML;
                        button.signin.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.login_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "login_admin",
                            correo: input.email.element.value,
                            contraseña: input.pass.element.value
                        }).then(response => {
                            button.signin.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    location = "?p=home";
                                    break;
                                case -3:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_0);
                                    break;
                                case -4:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_0);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.login_info.input;
                let first_invalid_input = null;
                for (const name in input) {
                    if (input[name].isEmpty()) {
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