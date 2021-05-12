(function () {
    const pageName = l_arr.drivers.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    document.querySelector("#n_dd_drivers_tab").classList.add("dropdown-active");
    
    hideLoadingScreen();

    document.querySelector("#searchAction").addEventListener("click", e => {
        document.querySelector("#searchAction").querySelector("input").focus();
    });

    let modal = {
        driver_options: {
            object: new Modal("#driver-options"),
            button: {
                fire: {
                    element: document.querySelector("#driver-options #driver-options-fire"),
                    onclick: () => {
                        modal.driver_options.object.hide();
                        modal.driver_fire_confirm.object.show();
                    }
                }
            }
        },
        driver_fire_confirm: {
            object: new Modal("#driver-fire-confirm"),
            button: {
                yes: {
                    element: document.querySelector("#driver-fire-confirm #driver-fire-yes"),
                    onclick: null
                },
                no: {
                    element: document.querySelector("#driver-fire-confirm #driver-fire-no"),
                    onclick: () => {
                        modal.driver_fire_confirm.object.hide();
                    }
                }
            }
        }
    }

    let form = {
        global: {
            button: {
                action_create_driver: {
                    element: document.querySelector("#action-create-driver"),
                    onclick: () => {
                        location = "?p=newdriver";
                    }
                }
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

    modal.driver_fire_confirm.button.yes.element.onclick = () => {
        modal.driver_fire_confirm.button.yes.onclick();
    }
    modal.driver_options.button.fire.element.onclick = () => {
        modal.driver_options.button.fire.onclick();
    }

    let drivers_count = 0;
    const load_more_drivers = (offset) => {
        let limit = 10;
        new RequestMe().post("model/apis/", {
            api: "get_drivers",
            offset: offset,
            limit: limit
        }).then(response => {
            console.log(response);
            switch (response.code) {
                case 0:
                    drivers_count += response.data.drivers.length;
                    let drivers_layout = document.querySelector("#cards-sales");
                    for (let driver_layout of response.data.drivers) {
                        const d_layout_id = driver_layout.pk_usuario;
                        const d_firstname = driver_layout.nombre;
                        const d_lastname = driver_layout.apellido;
                        const d_email = driver_layout.correo;
                        const d_phone = driver_layout.telefono;
                        const d_image_path = driver_layout.imagen_ruta.slice(4);
                        let driver_html = `
                            <span>${d_layout_id}</span>
                            <span>${d_firstname}</span>
                            <span>${d_lastname}</span>
                        `;
                        let driver_node = document.createElement("button");
                        driver_node.classList.add("card-sale");
                        driver_node.innerHTML = driver_html;

                        driver_node.addEventListener("click", e => {
                            modal.driver_options.object.show();

                            modal.driver_options.object.element.querySelector("#driver-options-image")
                                .setAttribute("src", d_image_path);
                            modal.driver_options.object.element.querySelector("#driver-options-fullname")
                                .textContent = d_firstname + " " + d_lastname;
                            modal.driver_options.object.element.querySelector("#driver-options-email")
                                .textContent = d_email;
                            modal.driver_options.object.element.querySelector("#driver-options-phone")
                                .textContent = d_phone;

                            modal.driver_fire_confirm.button.yes.onclick = () => {

                                let button = modal.driver_fire_confirm.button;
                                const default_text_button = button.yes.element.innerHTML;
                                button.yes.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                                new RequestMe().post("model/apis/", {
                                    api: "set_fire_driver",
                                    driver: d_layout_id,
                                    new_fired: "1"
                                }).then(response => {
                                    button.yes.element.innerHTML = default_text_button;
                                    switch (response.code) {
                                        case 0:
                                            drivers_count -= 1;
                                            if (drivers_count == 0) {
                                                document.querySelector(".cards-empty").classList.remove("hidden");
                                            }
                                            driver_node.remove();
                                            modal.driver_fire_confirm.object.hide();
                                            new AlertMe(l_arr.global.mdal_suc_t_1, l_arr.global.mdal_suc_b_8);
                                            break;
                                        default:
                                            new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                                    }
                                });
                            }
                            modal.driver_options.object.show();
                        });

                        drivers_layout.appendChild(driver_node);
                    }
                    let load_more_layout = document.querySelector("#load-more-layout");
                    let load_more_button = load_more_layout.querySelector("button");

                    if (offset == 0) {
                        hideLoadingScreen();
                    }

                    if (!response.data.are_they_all) {
                        load_more_layout.classList.remove("hidden");
                        load_more_button.onclick = () => {
                            offset += limit;
                            load_more_drivers(offset);
                        }
                    } else {
                        load_more_button.classList.add("hidden");
                        load_more_button.onclick = null;
                    }
                    break;
                case -3:
                    let cards_empty = document.querySelector("#cards-sales > .cards-empty");
                    cards_empty.classList.remove("hidden");
                    hideLoadingScreen();
                    break;
                default:
                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
            }
        });
    }
    load_more_drivers(0);
})();