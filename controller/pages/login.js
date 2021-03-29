(function () {
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
                        let input = form.login_info.input;
                        new RequestMe().post("model/apis/", {
                            api: "login_admin",
                            correo: input.email.element.value,
                            contraseña: input.pass.element.value
                        }).then(response => {
                            switch (response.code) {
                                case 0:
                                    location = "home.php";
                                    break;
                                case -3:
                                    new AlertMe("Error", "Correo y/o contraseña incorrecto");
                                    break;
                                case -4:
                                    new AlertMe("Error", "Correo y/o contraseña incorrecto");
                                    break;
                                default:
                                    new AlertMe("Error", "Algo ha salido mal, intentalo de nuevo");
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.login_info.input;
                for (const name in input) {
                    if (input[name].isEmpty()) return false;
                }
                return true;
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