(function () {
    const pageName = l_arr.home.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    document.querySelector("#n_dd_home_tab").classList.add("dropdown-active");
    
    //insert main actions manually
    let navbar_right_relative = document.querySelector("#relative-n-dd-reference");
    let navbar_right_list = document.querySelector("#relative-n-dd-reference").parentNode;
    let navbar_create_car = document.createElement("li");
    navbar_create_car.innerHTML = `
        <button id="action-create-car">
            <i class="fas fa-plus"></i>
        </button>
    `;
    let navbar_search = document.createElement("li");
    navbar_search.innerHTML = `
        <button id="action-search-car">
            <i class="fas fa-search"></i>
        </button>
    `;
    navbar_right_list.insertBefore(navbar_create_car, navbar_right_relative);
    navbar_right_list.insertBefore(navbar_search, navbar_right_relative);

    let modal = {
        car_options: {
            object: new Modal("#car-options"),
            button: {
                edit: {
                    element: document.querySelector("#car-options #car-options-edit"),
                    onclick: null
                },
                delete: {
                    element: document.querySelector("#car-options #car-options-delete"),
                    onclick: () => {
                        modal.car_options.object.hide();
                        modal.car_delete_confirm.object.show();
                    }
                }
            }
        },
        car_delete_confirm: {
            object: new Modal("#car-delete-confirm"),
            button: {
                yes: {
                    element: document.querySelector("#car-delete-confirm #car-delete-yes"),
                    onclick: null
                },
                no: {
                    element: document.querySelector("#car-delete-confirm #car-delete-no"),
                    onclick: () => {
                        modal.car_delete_confirm.object.hide();
                    }
                }
            }
        },
        car_search: {
            object: new Modal("#car-filter"),
            button: {
                search: {
                    element: document.querySelector("#car-filter-submit"),
                    onclick: null
                }
            }
        }
    }

    let form = {
        global: {
            button: {
                action_create_car: {
                    element: document.querySelector("#action-create-car"),
                    onclick: () => {
                        location = "?p=newcar";
                    }
                },
                action_search_car: {
                    element: document.querySelector("#action-search-car"),
                    onclick: () => {
                        modal.car_search.object.show();
                    }
                },
                language_set_spanish: {
                    element: document.querySelector("#language-set-spanish"),
                    onclick: () => {
                        document.cookie = "l=spanish";
                        location = location;
                    }
                },
                language_set_english: {
                    element: document.querySelector("#language-set-english"),
                    onclick: () => {
                        document.cookie = "l=english";
                        location = location;
                    }
                }
            }
        },
        search_car_info: {
            select: {
                model: new FieldControl("#input-model", {}),
                brand: new FieldControl("#input-brand", {}),
                color: new FieldControl("#input-color", {})
            },
            button: {
                search: {
                    submit : true,
                    element: document.querySelector("#car-filter-submit"),
                    onclick: null
                }
            },
            validation: () => {
                let input = form.search_car_info.input;
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
                    input[iname].element.addEventListener("keydown", e => {
                        if (e.which == 13) {
                            button[bname].onclick();
                        }
                    });
                }
            }
        }
    }

    modal.car_options.button.edit.element.onclick = () => {
        modal.car_options.button.edit.onclick();
    }
    modal.car_options.button.delete.element.onclick = () => {
        modal.car_options.button.delete.onclick();
    }
    modal.car_delete_confirm.button.yes.element.onclick = () => {
        modal.car_delete_confirm.button.yes.onclick();
    }
    modal.car_delete_confirm.button.no.element.onclick = () => {
        modal.car_delete_confirm.button.no.onclick();
    }

    
    let cars_count = 0;
    let empty_search = true;
    let request = {
        load_more_cars: (offset) => {
            new Promise((resolve, reject) => {
                let select = form.search_car_info.select;
                let modelo = select.model.element.value;
                let color_pintura = select.color.element.value;
                if (empty_search) {
                    modelo = "";
                    color_pintura = "";
                    empty_search = false;
                }

                let limit = 15;
                let button = form.search_car_info.button;
                const default_text_button = button.search.element.innerHTML;
                button.search.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                new RequestMe().post("model/apis/", {
                    api: "get_cars",
                    offset: offset,
                    limit: limit,
                    modelo: modelo,
                    color_pintura: color_pintura
                }).then(response => {
                    button.search.element.innerHTML = default_text_button;
                    switch (response.code) {
                        case 0:
                            cars_count += response.data.cars.length;
                            let cars_layout = document.querySelector("#cars-layout");
                            for (let car_layout of response.data.cars) {
                                const c_layout_id = car_layout.pk_auto;
                                const c_model_name = car_layout.modelo_nombre;
                                const c_image_path = car_layout.imagen_ruta.slice(4);
                                let car_html = `
                                    <article class="card-car">
                                        <h2>${c_model_name}</h2>
                                        <img src="${c_image_path}" loading="lazy" alt="imagen">
                                        <button type="button"><i class="fas fa-ellipsis-v"></i></button>
                                    </article>
                                `;
                                let car_node = document.createElement("article");
                                car_node.innerHTML = car_html;
                                
                                car_node.querySelector("button").addEventListener("click", e => {
                                    modal.car_options.button.edit.onclick = () => {
                                        location = "?p=editcar&car=" + c_layout_id;
                                    }
                                    modal.car_delete_confirm.button.yes.onclick = () => {
        
                                        let button = modal.car_delete_confirm.button;
                                        const default_text_button = button.yes.element.innerHTML;
                                        button.yes.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                                        new RequestMe().post("model/apis/", {
                                            api: "delete_car",
                                            car: c_layout_id
                                        }).then(response => {
                                            button.yes.element.innerHTML = default_text_button;
                                            switch (response.code) {
                                                case 0:
                                                    cars_count -= 1;
                                                    if (cars_count == 0) {
                                                        document.querySelector(".cards-empty").classList.remove("hidden");
                                                    }
                                                    car_node.remove();
                                                    modal.car_delete_confirm.object.hide();
                                                    new AlertMe(l_arr.global.mdal_suc_t_1, l_arr.global.mdal_suc_b_0);
                                                    break;
                                                default:
                                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                                            }
                                        });
                                    }
                                    modal.car_options.object.show();
                                });
        
                                cars_layout.appendChild(car_node);
                                ScrollReveal().reveal(car_node, {
                                    delay: 175,
                                    duration: 500,
                                    reset: true,
                                    scale: 0.85
                                });
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
                                    request.load_more_cars(offset);
                                }
                            } else {
                                load_more_button.classList.add("hidden");
                                load_more_button.onclick = null;
                            }
                            break;
                        case -3:
                            let cards_empty = document.querySelector("#cars-layout > .cards-empty");
                            cards_empty.classList.remove("hidden");
                            resolve(response.code);
                            break;
                        default:
                            new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
                            reject();
                    }
                })
            })
        },
        get_car_brands_models: new Promise((resolve, reject) => {
            new RequestMe().post("model/apis/", {
                api: "get_car_brands_models"
            }).catch(err => {
                reject();
            }).then(response => {
                switch (response.code) {
                    case 0:
                        const updateModels = () => {
                            let input_brand = form.search_car_info.select.brand.element;
                            let car_brand = response.data.filter(brand => brand.pk_auto_marca == input_brand.value)[0];
                            let brand_models_html = "";
                            for (let brand_models of car_brand.models) {
                                const b_model_id = brand_models.pk_auto_modelo;
                                const b_model_name = brand_models.nombre;
                                brand_models_html += `
                                    <option value="${b_model_id}">${b_model_name}</option>
                                `;
                                let input_model = form.search_car_info.select.model.element;
                                input_model.innerHTML = brand_models_html;
                            }
                        }
                        let car_brands_html = "";
                        let input_brand = form.search_car_info.select.brand.element;
                        for (let car_brand of response.data) {
                            const c_brand_id = car_brand.pk_auto_marca;
                            const c_brand_name = car_brand.nombre;
                            car_brands_html += `
                                <option value="${c_brand_id}">${c_brand_name}</option>
                            `;
                            input_brand.addEventListener("change", e => {
                                updateModels(car_brand);
                            });
                        }
                        input_brand.innerHTML = car_brands_html;
                        updateModels();
                        resolve(response.code);
                        break;
                    default:
                        new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
                        reject();
                }
            });
        }),
        get_car_colors: new Promise((resolve, reject) => {
            new RequestMe().post("model/apis/", {
                api: "get_car_colors"
            }).catch(err => {
                reject();
            }).then(response => {
                switch (response.code) {
                    case 0:
                        let car_colors_html = "";
                        let input_color = form.search_car_info.select.color.element;
                        for (let car_color of response.data) {
                            const c_color_id = car_color.pk_auto_color_pintura;
                            const c_color_name = car_color.nombre;
                            car_colors_html += `
                                <option value="${c_color_id}">${c_color_name}</option>
                            `;
                        }
                        input_color.innerHTML = car_colors_html;
                        resolve(response.code);
                        break;
                    default:
                        new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
                        reject();
                }
            });
        })
    }

    modal.car_search.button.search.element.onclick = () => {
        if (!form.search_car_info.validation()) return;

        cars_count = 0;
        let cards_empty = document.querySelector("#cars-layout > .cards-empty");
        document.querySelectorAll("#cars-layout > article").forEach(e => {
            e.remove();
        });
        cards_empty.innerHTML = l_arr["home"]["txt_6"];
        cards_empty.classList.add("hidden");
        let load_more_button = document.querySelector("#load-more-layout > button");
        load_more_button.classList.add("hidden");
        load_more_button.onclick = null;

        Promise.all([request.load_more_cars(0)]
        ).then(values => {
            modal.car_search.object.hide();
        });
    }

    Promise.all([request.get_car_brands_models, request.get_car_colors, request.load_more_cars(0)]
    ).then(values => {
        window.setTimeout(() => {
            hideLoadingScreen();
        }, 1000);
    });
})();