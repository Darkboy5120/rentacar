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

    //insert main actions manually
    let navbar_right_relative = document.querySelector("#relative-n-dd-reference");
    let navbar_right_list = document.querySelector("#relative-n-dd-reference").parentNode;
    let navbar_create_driver = document.createElement("li");
    navbar_create_driver.innerHTML = `
        <button id="action-create-driver">
            <i class="fas fa-plus"></i>
        </button>
    `;
    let navbar_search = document.createElement("li");
    navbar_search.innerHTML = `
        <button id="action-search-driver">
            <i class="fas fa-search"></i>
        </button>
    `;
    navbar_right_list.insertBefore(navbar_create_driver, navbar_right_relative);
    navbar_right_list.insertBefore(navbar_search, navbar_right_relative);

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
        },
        driver_search: {
            object: new Modal("#driver-filter"),
            button: {
                search: {
                    element: document.querySelector("#driver-filter-submit")
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
                },
                action_filter_driver: {
                    element: document.querySelector("#action-search-driver"),
                    onclick: () => {
                        modal.driver_search.object.show();
                    }
                }
            }
        },
        search_driver_info: {
            input: {
                firstname: new FieldControl("#input-firstname", {
                    regex: "[^A-Za-z]+", min : 1, max : 50, optional : true
                }),
                lastname: new FieldControl("#input-lastname", {
                    regex: "[^A-Za-z]+", min : 1, max : 50, optional : true
                })
            },
            switch: {
                firstname: {
                    object: new SwitchControl("#switch-firstname", {value: true}),
                    get_disable_obj: () => {return form.search_driver_info.input.firstname}
                },
                lastname: {
                    object: new SwitchControl("#switch-lastname", {value: true}),
                    get_disable_obj: () => {return form.search_driver_info.input.lastname}
                }
            },
            button: {
                search: {
                    submit : true,
                    element: document.querySelector("#driver-filter-submit"),
                    onclick: null
                }
            },
            validation: () => {
                let input = form.search_driver_info.input;
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
        let switch_ = form[fname].switch;
        for (const sname in switch_) {
            switch_[sname].object.setOnUpdateEvent(() => {
                switch_[sname].get_disable_obj().toggleDisabled();
            });
        }
        let button = form[fname].button;
        for (const bname in button) {
            button[bname].element.addEventListener("click", e => {
                button[bname].onclick();
            });
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
    modal.driver_fire_confirm.button.no.element.onclick = () => {
        modal.driver_fire_confirm.button.no.onclick();
    }
    modal.driver_options.button.fire.element.onclick = () => {
        modal.driver_options.button.fire.onclick();
    }

    let drivers_count = 0;
    let empty_search = true;
    let request = {
        load_more_drivers : (offset) => {
            new Promise((resolve, reject) => {
                let input = form.search_driver_info.input;
                let nombre = input.firstname.getValue();
                let apellido = input.lastname.getValue();
                if (empty_search) {
                    nombre = ""
                    apellido = "";
                    empty_search = false;
                }

                let limit = 10;
                let button = form.search_driver_info.button;
                const default_text_button = button.search.element.innerHTML;
                button.search.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                new RequestMe().post("model/apis/", {
                    api: "get_drivers",
                    offset: offset,
                    limit: limit,
                    nombre: nombre,
                    apellido, apellido
                }).then(response => {
                    button.search.element.innerHTML = default_text_button;
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
                                            hideLoadingScreen();
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
                                resolve(response.code);
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
                        case -2:
                            let cards_empty = document.querySelector("#cards-sales > .cards-empty");
                            cards_empty.classList.remove("hidden");
                            resolve(response.code);
                            break;
                        default:
                            new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
                            reject();
                    }
                });
            });
        }
    }

    form.search_driver_info.button.search.onclick = () => {
        if (!form.search_driver_info.validation()) return;

        drivers_count = 0;
        let cards_empty = document.querySelector("#cards-sales > .cards-empty");
        document.querySelectorAll("#cards-sales > .card-sale").forEach(e => {
            e.remove();
        });
        cards_empty.innerHTML = l_arr["drivers"]["txt_6"];
        cards_empty.classList.add("hidden");
        let load_more_button = document.querySelector("#load-more-layout > button");
        load_more_button.classList.add("hidden");
        load_more_button.onclick = null;

        Promise.all([request.load_more_drivers(0)]
        ).then(values => {
            modal.driver_search.object.hide();
        });
    }

    Promise.all([request.load_more_drivers(0)]
    ).then(values => {
        window.setTimeout(() => {
            hideLoadingScreen();
        }, 1000);
    });
})();