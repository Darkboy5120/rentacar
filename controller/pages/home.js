(function () {
    const pageName = "Home";
    document.querySelector("title").textContent = "Rentacar | " + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });

    ScrollReveal().reveal('.card-car', {
        delay: 175,
        duration: 500,
        reset: true,
        scale: 0.85
    });

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
        }
    }

    let form = {
        global: {
            button: {
                a_create_car: {
                    element: document.querySelector("#action-create-car"),
                    onclick: () => {
                        location = "?p=newcar";
                    }
                },
                n_dd_drivers_tab: {
                    element: document.querySelector("#n_dd_drivers_tab"),
                    onclick: () => {
                        location = "?p=drivers";
                    }
                },
                n_dd_sales_tab: {
                    element: document.querySelector("#n_dd_sales_tab"),
                    onclick: () => {
                        location = "?p=sales";
                    }
                },
                n_dd_profile_tab: {
                    element: document.querySelector("#n_dd_profile_tab"),
                    onclick: () => {
                        location = "?p=profile";
                    }
                },
                n_dd_exit_tab: {
                    element: document.querySelector("#n_dd_exit_tab"),
                    onclick: () => {
                        new RequestMe().post("model/apis/", {
                            api: "signout"
                        }).then(response => {
                            switch (response.code) {
                                case 0:
                                    location = "?p=login";
                                    break;
                                default:
                                    new AlertMe("Error", "Algo ha salido mal, intentalo de nuevo");
                            }
                        });
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
                    input[iname].element.addEventListener("keyup", e => {
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

    const load_more_cars = (offset) => {
        let limit = 15;
        new RequestMe().post("model/apis/", {
            api: "get_cars",
            offset: offset,
            limit: limit
        }).then(response => {
            switch (response.code) {
                case 0:
                    let cars_layout = document.querySelector("#cars-layout");
                    for (let car_layout of response.data.cars) {
                        const c_layout_id = car_layout.pk_auto;
                        const c_model_name = car_layout.modelo_nombre;
                        const c_image_path = car_layout.imagen_ruta.slice(4);
                        let car_html = `
                            <article class="card-car">
                                <h2>${c_model_name}</h2>
                                <img src="${c_image_path}" loading="lazy" alt="imagen">
                                <i class="fas fa-ellipsis-v"></i>
                            </article>
                        `;
                        let car_node = document.createElement("article");
                        car_node.innerHTML = car_html;

                        car_node.querySelector("i").addEventListener("click", e => {
                            modal.car_options.button.edit.onclick = () => {
                                location = "?p=editcar&car=" + c_layout_id;
                            }
                            modal.car_delete_confirm.button.yes.onclick = () => {

                                new RequestMe().post("model/apis/", {
                                    api: "delete_car",
                                    car: c_layout_id
                                }).then(response => {
                                    switch (response.code) {
                                        case 0:
                                            car_node.remove();
                                            modal.car_delete_confirm.object.hide();
                                            new AlertMe("Aviso", "El auto se ha eliminado correctamente");
                                            break;
                                        default:
                                            new AlertMe("Error", "Algo ha salido mal, intentalo de nuevo");
                                    }
                                });
                            }
                            modal.car_options.object.show();
                        });

                        cars_layout.appendChild(car_node);
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
                            load_more_cars(offset);
                        }
                    } else {
                        load_more_button.classList.add("hidden");
                        load_more_button.onclick = null;
                    }
                    break;
                case -3:
                    let cards_empty = document.querySelector("#cars-layout > .cards-empty");
                    cards_empty.classList.remove("hidden");
                    break;
                default:
                    new AlertMe("Error", "Algo ha salido mal, recarga la pagina por favor");
            }
        });
    }
    load_more_cars(0);
})();