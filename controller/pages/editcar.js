(function () {
    const pageName = l_arr.editcar.page_name;
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
                aircond: new SwitchControl("#switch-aircond", {}),
                gps: new SwitchControl("#switch-gps", {}),
                darkglass: new SwitchControl("#switch-darkglass", {}),
                replacement: new SwitchControl("#switch-replacement", {}),
                toolbox: new SwitchControl("#switch-toolbox", {})
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
                        let button = form.car_info.button;
                        const default_text_button = button.create_car.element.innerHTML;
                        button.create_car.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                        let input = form.car_info.input;
                        let switch_ = form.car_info.switch;
                        let select = form.car_info.select;
                        let same_files = (!input.thumbnail_image.is_edited() && !input.others_images.is_edited())
                            ? 1 : 0;
                        new RequestMe().post("model/apis/", {
                            api: "edit_car",
                            car: carId,
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
                            aire_acondicionado: (switch_.aircond.val()) ? "1" : "0",
                            gps: (switch_.gps.val()) ? "1" : "0",
                            vidrios_polarizados: (switch_.darkglass.val()) ? "1" : "0",
                            repuesto: (switch_.replacement.val()) ? "1" : "0",
                            caja_herramientas: (switch_.toolbox.val()) ? "1" : "0",
                            modelo: select.model.element.value,
                            tipo: select.type.element.value,
                            color_pintura: select.color.element.value,
                            capacidad_cajuela: select.trunk.element.value,
                            transmicion: select.transmission.element.value,
                            seguro: select.insurance.element.value,
                            tipo_motor: select.engine.element.value,
                            same_files: same_files
                        }).then(response => {
                            button.create_car.element.innerHTML = default_text_button;
                            switch (response.code) {
                                case 0:
                                    new AlertMe(l_arr.global.mdal_suc_t_0, l_arr.global.mdal_suc_b_2);
                                    break;
                                default:
                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                            }
                        });
                    }
                }
            },
            validation: () => {
                let input = form.car_info.input;
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


    let request = {
        get_car_brands_models: new Promise((resolve, reject) => {
            new RequestMe().post("model/apis/", {
                api: "get_car_brands_models"
            }).catch(err => {
                reject();
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
                        let input_color = form.car_info.select.color.element;
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

    Promise.all([request.get_car_brands_models, request.get_car_colors]
    ).then(values => {
        if (values[0] == 0 && values[1] == 0) {
            new RequestMe().post("model/apis/", {
                api: "get_car_by_id",
                car: carId
            }).then(response => {
                switch (response.code) {
                    case 0:
                        const get_file = (value) => {
                            return fetch(value.slice(4))
                            .then(res => res.blob());
                        }
                        let car = response.data;
                        form.car_info.input.price.element.value = car["precio"];
                        form.car_info.input.doors.element.value = car["puertas"];
                        form.car_info.input.chairs.element.value = car["asientos"];
                        form.car_info.input.consunit.element.value = car["unidad_consumo"];
                        form.car_info.input.horsepower.element.value = car["caballos_fuerza"];
                        form.car_info.input.tankcap.element.value = car["capacidad_combustible"];
                        form.car_info.switch.aircond.toggleStatus(
                            (car["aire_acondicionado"] == "0") ? false : true
                        );
                        form.car_info.switch.gps.toggleStatus(
                            (car["gps"] == "0") ? false : true
                        );
                        form.car_info.switch.darkglass.toggleStatus(
                            (car["vidrios_polarizados"] == "0") ? false : true
                        );
                        form.car_info.switch.replacement.toggleStatus(
                            (car["repuesto"] == "0") ? false : true
                        );
                        form.car_info.switch.toolbox.toggleStatus(
                            (car["caja_herramientas"] == "0") ? false : true
                        );
                        for (let name in form.car_info.input) {
                            if (form.car_info.input[name].validate) {
                                form.car_info.input[name].validate();
                            }
                        }
                        let brand_opt = form.car_info.select.brand.element.options;
                        for (let i = 0; i < brand_opt.length; i++) {
                            if (brand_opt[i].value == car["pk_auto_marca"]) {
                                form.car_info.select.brand.element.selectedIndex = i;
                                form.car_info.select.brand.element.dispatchEvent(new Event("change"));
                                break;
                            }
                        }
                        let model_opt = form.car_info.select.model.element.options;
                        for (let i = 0; i < model_opt.length; i++) {
                            if (model_opt[i].value == car["pk_auto_modelo"]) {
                                form.car_info.select.model.element.selectedIndex = i;
                                break;
                            }
                        }
                        let color_opt = form.car_info.select.color.element.options;
                        for (let i = 0; i < color_opt.length; i++) {
                            if (color_opt[i].value == car["fk_auto_color_pintura"]) {
                                form.car_info.select.color.element.selectedIndex = i;
                                break;
                            }
                        }
                        form.car_info.select.type.element.options.selectedIndex = car["tipo"];
                        form.car_info.select.trunk.element.options.selectedIndex = car["capacidad_cajuela"];
                        form.car_info.select.engine.element.options.selectedIndex = car["tipo_motor"];
                        form.car_info.select.transmission.element.options.selectedIndex = car["transmicion"];
                        form.car_info.select.insurance.element.options.selectedIndex = car["seguro"];

                        let c_thumbnail_file = get_file(car["imagen_ruta"]).then(blob => {
                            const file = new File([blob], 'foo.png', blob);
                            form.car_info.input.thumbnail_image.handleFiles([file]);
                            form.car_info.input.thumbnail_image.reset_is_edited();
                        });

                        let others_images_file = [];
                        let i_forname = 0;
                        for (let image of car["otras_imagenes"]) {
                            others_images_file.push(
                                new Promise((resolve, reject) => {
                                    get_file(image["imagen_ruta"]).then(blob => {
                                        const file = new File([blob], ('foo.png' + i_forname++), blob);
                                        resolve(file);
                                    }).catch(err => {
                                        reject();
                                    });
                                })
                            );
                        }
                        Promise.all(others_images_file).then(values => {
                            form.car_info.input.others_images.handleFiles(values);
                            form.car_info.input.others_images.reset_is_edited();
                            hideLoadingScreen();
                        });
                        break;
                    default:
                        new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_2);
                }
            })
        }
    });
})();