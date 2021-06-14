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
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Year', 'Sales', 'Expenses'],
                            ['2013',  1000,      400],
                            ['2014',  1170,      460],
                            ['2015',  660,       1120],
                            ['2016',  1030,      540]
                            ]);

                            var options = {
                            title: 'Company Performance',
                            hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                            };

                            var chart = new google.visualization.AreaChart(document.querySelector("#sale-chart .modal-body"));
                            chart.draw(data, options);
                        }


                        modal.sale_chart.object.show();
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
    let request = {
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
                            sales_count += response.data.sales.length;
                            let sales_layout = document.querySelector("#cards-sales");
                            for (let sale_layout of response.data.sales) {
                                const s_layout_id = sale_layout.pk_renta;
                                const s_ganancia = sale_layout.costo;
                                const s_fecha_hora = sale_layout.fecha_hora.slice(0, 10).replace(/-/g, "/");
                                const s_car_id = sale_layout.fk_auto;
                                const s_driver_id = sale_layout.fk_conductor;
                                let sale_html = `
                                    <span>${s_layout_id}</span>
                                    <span>$${s_ganancia}</span>
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

                                        console.log("descargar el reporte de devolucion");
                                        /*let button = modal.driver_fire_confirm.button;
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
                                                    sales_count -= 1;
                                                    if (sales_count == 0) {
                                                        document.querySelector(".cards-empty").classList.remove("hidden");
                                                    }
                                                    sale_node.remove();
                                                    modal.driver_fire_confirm.object.hide();
                                                    new AlertMe(l_arr.global.mdal_suc_t_1, l_arr.global.mdal_suc_b_8);
                                                    break;
                                                default:
                                                    new AlertMe(l_arr.global.mdal_err_t_0, l_arr.global.mdal_err_b_1);
                                            }
                                        });*/
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

    Promise.all([request.load_more_sales(0)]
    ).then(values => {
        window.setTimeout(() => {
            hideLoadingScreen();
        }, 1000);
    });

})();