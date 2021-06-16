(function () {
    const pageName = l_arr.sales.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    document.querySelector("#n_dd_sales_tab").classList.add("dropdown-active");
    
    //insert main actions manually
    let navbar_right_relative = document.querySelector("#relative-n-dd-reference");
    let navbar_right_list = document.querySelector("#relative-n-dd-reference").parentNode;
    let navbar_search = document.createElement("li");
    let navbar_chart = document.createElement("li");
    navbar_search.innerHTML = `
        <button id="action-search-sale">
            <i class="fas fa-search"></i>
        </button>
    `;
    navbar_chart.innerHTML = `
        <button id="action-chart-sale">
            <i class="fas fa-chart-pie"></i>
        </button>
    `;
    navbar_right_list.insertBefore(navbar_search, navbar_right_relative);
    navbar_right_list.insertBefore(navbar_chart, navbar_right_relative);

    //const modalSaleInfo = new Modal("#saleInfo");

    /*document.querySelectorAll(".card-sale").forEach(element => {
        element.addEventListener("click", event => {
            modalSaleInfo.show();
        });
    });*/

    const draw_graph = (data) => {
        let graph_empty = document.querySelector("#sale-chart .modal-body > .graph-empty");
        if (data == null) {
            graph_empty.classList.remove("hidden");
            return;
        }
        graph_empty.classList.add("hidden");

        let data_for_table = [
            ["Fecha", "Ventas"]
        ];
        for (let sale of data.sales) {
            const s_ganancia = (userCurrency == "mxn")
                ? sale.costo : (sale.costo / dolar_value).toFixed(2);
            const s_fecha_hora = sale.fecha_hora.slice(0, 10).replace(/-/g, "/");
            data_for_table.push([
                s_fecha_hora, parseInt(s_ganancia)
            ]);
        }

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(data_for_table);

            var options = {
            title: 'Ventas',
            hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.querySelector("#sale-chart .modal-body > .table"));
            chart.draw(data, options);
        }
    }

    let modal = {
        sale_info: {
            object: new Modal("#saleInfo"),
            button: {
                sale_info_return: {
                    element: document.querySelector("#sale-info-return")
                }
            }
        },
        sale_search: {
            object: new Modal("#sale-filter"),
            button: {
                search: {
                    element: document.querySelector("#sale-filter-submit")
                }
            }
        },
        sale_chart: {
            object: new Modal("#sale-chart"),
            button: {
            }
        }
    }

    let form = {
        global: {
            button: {
                action_filter_sale: {
                    element: document.querySelector("#action-search-sale"),
                    onclick: () => {
                        modal.sale_search.object.show();
                    }
                },
                action_chart_sale: {
                    element: document.querySelector("#action-chart-sale"),
                    onclick: () => {
                    }
                }
            }
        },
        search_sale_info: {
            input: {
                sale: new FieldControl("#input-sale", {
                    regex: "[^A-Za-z]+", min : 1, max : 50, optional : true
                }),
                mingain: new FieldControl("#input-mingain", {
                    regex: "[^A-Za-z]+", min : 1, max : 50, optional : true
                }),
                maxgain: new FieldControl("#input-maxgain", {
                    regex: "[^A-Za-z]+", min : 1, max : 50, optional : true
                })
            },
            switch: {
                sale: {
                    object: new SwitchControl("#switch-sale", {value: true}),
                    get_disable_obj: () => {return form.search_sale_info.input.sale}
                },
                mingain: {
                    object: new SwitchControl("#switch-mingain", {value: true}),
                    get_disable_obj: () => {return form.search_sale_info.input.mingain}
                },
                maxgain: {
                    object: new SwitchControl("#switch-maxgain", {value: true}),
                    get_disable_obj: () => {return form.search_sale_info.input.maxgain}
                }
            },
            button: {
                search: {
                    submit : true,
                    element: document.querySelector("#sale-filter-submit"),
                    onclick: null
                }
            },
            validation: () => {
                let input = form.search_sale_info.input;
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

    modal.sale_info.button.sale_info_return.element.onclick = () => {
        modal.sale_info.button.sale_info_return.onclick();
    }
    form.search_sale_info.input.sale.element = saleId;
    form.search_sale_info.input.sale.validate();

    let sales_count = 0;
    let empty_search = false;
    let dolar_value = null;
    let request = {
        get_dolar : () => {
            return new Promise((resolve, reject) => {
                new RequestMe().get("https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno/", {
                    token: "4792c8af9e227ad9f40f3e9244897afa654fda1c26502b7da7fdb59b1fa1db67"
                }).then(response => {
                    const dolar_en_peso = response.bmx.series[0].datos[0].dato;
                    dolar_value = parseFloat(dolar_en_peso);
                    resolve(0);
                });
            });
        },
        load_more_sales : (offset) => {
            new Promise((resolve, reject) => {
                let input = form.search_sale_info.input;
                let sale = input.sale.getValue();
                let mingain = input.mingain.getValue();
                let maxgain = input.maxgain.getValue();
                if (empty_search) {
                    sale = "";
                    mingain = "";
                    maxgain = "";
                    empty_search = false;
                }

                let limit = 10;
                let button = form.search_sale_info.button;
                const default_text_button = button.search.element.innerHTML;
                button.search.element.innerHTML = "<i class='fas fa-sync-alt fa-spin'></i>" + l_arr.global.log_15;
                new RequestMe().post("model/apis/", {
                    api: "get_sales",
                    offset: offset,
                    limit: limit,
                    sale: sale,
                    mingain: mingain,
                    maxgain, maxgain
                }).then(response => {
                    button.search.element.innerHTML = default_text_button;
                    switch (response.code) {
                        case 0:
                            form.global.button.action_chart_sale.onclick = () => {
                                draw_graph(response.data);
                                modal.sale_chart.object.show();
                            }

                            sales_count += response.data.sales.length;
                            let sales_layout = document.querySelector("#cards-sales");
                            for (let sale_layout of response.data.sales) {
                                const s_layout_id = sale_layout.pk_renta;
                                const s_ganancia = (userCurrency == "mxn")
                                    ? sale_layout.costo : (sale_layout.costo / dolar_value);
                                const s_currency = (userCurrency == "mxn") ? "MXN" : "USD";
                                const s_fecha_hora = sale_layout.fecha_hora.slice(0, 10).replace(/-/g, "/");
                                const s_car_id = sale_layout.fk_auto;
                                const s_driver_id = sale_layout.fk_conductor;
                                const s_car_name =  sale_layout.marca_nombre + " " + sale_layout.modelo_nombre;
                                const s_start_date = sale_layout.fechahora_entrega;
                                const s_end_date = sale_layout.fechahora_devolucion;
                                const s_price_per_day = (userCurrency == "mxn")
                                    ? sale_layout.precio : (sale_layout.precio / dolar_value);
                                const s_total_price = (userCurrency == "mxn")
                                    ? sale_layout.costo : (sale_layout.costo / dolar_value);
                                const s_description = sale_layout.descripcion;
                                const currency_unit = (userCurrency == "mxn") ? "MXN" : "USD";
                                let problems_data = (sale_layout.incidencias)
                                    ? sale_layout.incidencias : null;

                                for (let foo of problems_data) {
                                    foo.cost = (userCurrency == "mxn")
                                        ? foo.cost : (foo.cost / dolar_value)
                                }

                                let sale_html = `
                                    <span>${s_layout_id}</span>
                                    <span>$${s_ganancia.toFixed(2)} ${s_currency}</span>
                                    <span>${s_fecha_hora}</span>
                                `;
                                let sale_node = document.createElement("button");
                                sale_node.classList.add("card-sale");
                                sale_node.innerHTML = sale_html;

                                sale_node.addEventListener("click", e => {
                                    modal.sale_info.object.show();

                                    modal.sale_info.object.element.querySelector("#sale-info-auto")
                                        .setAttribute("href", `?p=editcar&car=${s_car_id}`);
                                    modal.sale_info.object.element.querySelector("#sale-info-driver")
                                        .setAttribute("href", `?p=drivers&driver=${s_driver_id}`);

                                    modal.sale_info.button.sale_info_return.onclick = () => {

                                        download_report(s_car_name, s_start_date, s_end_date, s_price_per_day,
                                            s_total_price, currency_unit, s_description, problems_data);
                                    }
                                    modal.sale_info.object.show();
                                });

                                sales_layout.appendChild(sale_node);
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
                                    load_more_sales(offset);
                                }
                            } else {
                                load_more_button.classList.add("hidden");
                                load_more_button.onclick = null;
                            }
                            break;
                        case -2:
                            form.global.button.action_chart_sale.onclick = () => {
                                draw_graph(response.data);
                                modal.sale_chart.object.show();
                            }

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

    form.search_sale_info.button.search.onclick = () => {
        if (!form.search_sale_info.validation()) return;

        sales_count = 0;
        let cards_empty = document.querySelector("#cards-sales > .cards-empty");
        document.querySelectorAll("#cards-sales > .card-sale").forEach(e => {
            e.remove();
        });
        cards_empty.innerHTML = l_arr["sales"]["txt_10"];
        cards_empty.classList.add("hidden");
        let load_more_button = document.querySelector("#load-more-layout > button");
        load_more_button.classList.add("hidden");
        load_more_button.onclick = null;

        Promise.all([request.load_more_sales(0)]
        ).then(values => {
            modal.sale_search.object.hide();
        });
    }

    request.get_dolar().then(r => {
        Promise.all([request.load_more_sales(0)]
        ).then(values => {
            window.setTimeout(() => {
                hideLoadingScreen();
            }, 1000);
        });
    });

    const download_report = (car_name, start_date, end_date,
        price_per_day, total_price, currency_unit, description, problems_data) => {
    var jsPDF = window.jspdf.jsPDF;
    // Default export is a4 paper, portrait, using millimeters for units
    const doc = new jsPDF();

    const total_days = total_price / price_per_day;

    const body = `
${l_arr["sales"]["txt_14"]} ${car_name} ${l_arr["sales"]["txt_15"]}
${l_arr["sales"]["txt_16"]} ${start_date} ${l_arr["sales"]["txt_17"]} ${end_date}${l_arr["sales"]["txt_18"]}
${l_arr["sales"]["txt_19"]} ${total_days} ${l_arr["sales"]["txt_20"]} $${price_per_day} ${currency_unit} ${l_arr["sales"]["txt_21"]}
${l_arr["sales"]["txt_22"]} $${total_price} ${currency_unit} ${l_arr["sales"]["txt_23"]}
    `;

    const success = `
${l_arr["sales"]["txt_24"]}
${l_arr["sales"]["txt_25"]}
    `;

    const err = `
${l_arr["sales"]["txt_26"]}
    `;

    let date = new Date();
    const month = (date.getMonth() < 10) ? ("0" + (date.getMonth()+1)) : date.getMonth()
    const day = date.getDate();
    const year = date.getFullYear();
    let full_date = `${month}/${day}/${year}`;

    const variable_content = (problems_data == null)
            ? success : err;

    doc.text(full_date, 10, 10);
    doc.text(l_arr["sales"]["txt_27"], 80, 20);
    doc.text(body, 10, 30);
    doc.text(variable_content, 10, 70);

    let title_y = 80;
    let cost_y = 90;
    let image_y = 105;
    let problem_y_increment = 130;
    let problems_total = 0;

    if (problems_data != null) {
        for (let i = 0; i < problems_data.length; i++) {
            problems_total += problems_data[i].cost;
            const err_t = `
        ${i+1} - ${problems_data[i].title}
            `;
            const err_desc = `
        ${description}
            `;
            const err_c = `
    ${l_arr["sales"]["txt_28"]} $${problems_data[i].cost} ${currency_unit}
            `;
            doc.text(err_t, 10, (title_y + (i*problem_y_increment)));
            doc.text(err_c, 10, (cost_y + (i*problem_y_increment)));
            doc.text(err_desc, 120, (cost_y + (i*problem_y_increment)));
            /*for (let j = 0; j < err_desc.length; j+=10) {
                let start_index = j * 50;
                let desc_content = "";
                if (err_desc.slice(j).length == 0) {
                    break;
                } else if (err_desc.slice(j).length < 50) {
                    desc_content = err_desc.slice(j);
                } else {
                    desc_content = err_desc.slice(j, (j+10));
                }
                doc.text(desc_content, 120, (cost_y + ((i)*problem_y_increment) + j) );
            }*/
            var img = new Image();
            img.src = problems_data[i].image.slice(4);
            const image_type = problems_data[i].image.slice(problems_data[i].image.indexOf(".")+1);
            doc.addImage(img, image_type, 25, (image_y + (i*problem_y_increment)), 100, 100);

            if (i == (problems_total.length-1)) {
                const err_fc = `
    ${l_arr["sales"]["txt_29"]} $${problems_total} ${currency_unit}
            `;
            }
        }
    }

    doc.save(`${l_arr["sales"]["txt_30"]}.pdf`);
    }
    /*download_report("Tsuru", "06/01/2021", "06/10/2021", "14", "70", "MXN",
        [{image : "./image.png", title : "Llanta ponchada", cost : "100"},
        {image : "./image.png", title : "Llanta ponchada", cost : "200"}]
    );*/
})();