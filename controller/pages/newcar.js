(function () {
    const pageName = "Nuevo auto";
    document.querySelector("title").textContent = "Rentacar | " + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });

    var slideRight = {
    delay: 500,
    distance: '100%',
    origin: 'left',
    opacity: null,
    afterReveal: el => {
        document.querySelector(".fixed-location").classList.add("slide-left-fl");
    }
    };

    ScrollReveal().reveal('.fixed-location', slideRight);

    /*const modalNewDriverConfirm = new Modal("#newDriverConfirm");
    document.querySelector("#newDriver").addEventListener("click", e => {
        modalNewDriverConfirm.show();
    });*/

    let form = {
        global: {
            button: {
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
        },
        car_info: {
            element: document.querySelector("#form-car-info"),
            input: {
                price: new FieldControl("#input-price", {
                    regex : "[^0-9]+", min : 1, max : 5
                }),
                doors: new FieldControl("#input-doors", {
                    regex : "[^0-9]+", min : 1, max : 1
                }),
                chairs: new FieldControl("#input-chairs", {
                    regex : "[^0-9]+", min : 1, max : 1
                }),
                consunit: new FieldControl("#input-consunit", {
                    regex : "[^0-9]+", min : 1, max : 3
                }),
                horsepower: new FieldControl("#input-horsepower", {
                    regex : "[^0-9]+", min : 1, max : 3
                }),
                tankcap: new FieldControl("#input-tankcap", {
                    regex : "[^0-9]+", min : 1, max : 3
                }),
                thumbnail_image: new FileControl("#input-thumbnail-image", {
                    min: 1, max: 1
                }),
                others_images: new FileControl("#input-other-images", {
                    min: 1, max: 5
                })
            },
            switch: {
                aircond: new SwitchControl("#switch-aircond"),
                gps: new SwitchControl("#switch-gps"),
                darkglass: new SwitchControl("#switch-darkglass"),
                replacement: new SwitchControl("#switch-replacement"),
                toolbox: new SwitchControl("#switch-toolbox")
            },
            select: {
                model: new FieldControl("#input-model", {}),
                brand: new FieldControl("#input-brand", {}),
                type: new FieldControl("#input-type", {}),
                color: new FieldControl("#input-color", {}),
                trunk: new FieldControl("#input-trunk", {}),
                transmission: new FieldControl("#input-transmission", {}),
                insurance: new FieldControl("#input-insurance", {}),
                engine: new FieldControl("#input-engine", {})
            },
            button: {
                create_car: {
                    submit : true,
                    element: document.querySelector("#create-car"),
                    onclick: () => {
                        if (!form.car_info.validation()) return;
                        let input = form.car_info.input;
                        let switch_ = form.car_info.switch;
                        let select = form.car_info.select;
                        new RequestMe().post("model/apis/", {
                            api: "create_car",
                            precio: input.price.element.value,
                            puertas: input.doors.element.value,
                            asientos: input.chairs.element.value,
                            unidad_consumo: input.consunit.element.value,
                            caballos_fuerza: input.horsepower.element.value,
                            capacidad_combustible: input.tankcap.element.value,
                            auto_imagen_portada: input.thumbnail_image.val()[0],
                            auto_imagen_0: input.others_images.val()[0],
                            auto_imagen_1: input.others_images.val()[1],
                            auto_imagen_2: input.others_images.val()[2],
                            auto_imagen_3: input.others_images.val()[3],
                            auto_imagen_4: input.others_images.val()[4],
                            aire_acondicionado: switch_.aircond.value,
                            gps: switch_.gps.value,
                            vidrios_polarizados: switch_.darkglass.value,
                            repuesto: switch_.replacement.value,
                            caja_herramientas: switch_.toolbox.value,
                            modelo: select.model.element.value,
                            tipo: select.type.element.value,
                            color_pintura: select.color.element.value,
                            capacidad_cajuela: select.trunk.element.value,
                            transmicion: select.transmission.element.value,
                            seguro: select.insurance.element.value,
                            tipo_motor: select.engine.element.value
                        }).then(response => {
                            switch (response.code) {
                                case 0:
                                    new AlertMe("Genial", "El auto se guardo correctamente");
                                    window.setTimeout(() => {
                                        location = "?p=home";
                                    }, 4000);
                                    break;
                                default:
                                    new AlertMe("Error", "Algo ha salido mal, intentalo de nuevo");
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.car_info.input;
                for (const name in input) {
                    if (!input[name].isDone()) {
                        input[name].focus();
                        return false;
                    }
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

    new RequestMe().post("model/apis/", {
        api: "get_car_brands_models"
    }).then(response => {
        switch (response.code) {
            case 0:
                const updateModels = () => {
                    let input_brand = form.car_info.select.brand.element;
                    let car_brand = response.data.filter(brand => brand.pk_auto_marca == input_brand.value)[0];
                    let brand_models_html = "";
                    for (let brand_models of car_brand.models) {
                        const b_model_id = brand_models.pk_auto_modelo;
                        const b_model_name = brand_models.nombre;
                        brand_models_html += `
                            <option value="${b_model_id}">${b_model_name}</option>
                        `;
                        let input_model = form.car_info.select.model.element;
                        input_model.innerHTML = brand_models_html;
                    }
                }
                let car_brands_html = "";
                let input_brand = form.car_info.select.brand.element;
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
                break;
            default:
                new AlertMe("Error", "Algo ha salido mal, recarga la pagina por favor");
        }
    });
    new RequestMe().post("model/apis/", {
        api: "get_car_colors"
    }).then(response => {
        switch (response.code) {
            case 0:
                let car_colors_html = "";
                let input_color = form.car_info.select.color.element;
                for (let car_color of response.data) {
                    const c_color_id = car_color.pk_auto_color_pintura;
                    const c_color_name = car_color.nombre;
                    car_colors_html += `
                        <option value="${c_color_id}">${c_color_name}</option>
                    `;
                }
                input_color.innerHTML = car_colors_html;
                break;
            default:
                new AlertMe("Error", "Algo ha salido mal, recarga la pagina por favor");
        }
    });
})();