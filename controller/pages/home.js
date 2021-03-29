(function () {
    const pageName = "Home";
    document.querySelector("title").textContent = "Rentacar | " + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });

    ScrollReveal().reveal('.card-car', {
        delay: 175,
        duration: 500,
        reset: true,
        scale: 0.85
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

    const modalCarOptions = new Modal("#carOptions");
    document.querySelectorAll(".card-car > i").forEach(element => {
        element.addEventListener("click", event => {
            modalCarOptions.show();
        });
    });

    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });

    let form = {
        global: {
            button: {
                n_dd_drivers_tab: {
                    element: document.querySelector("#n_dd_drivers_tab"),
                    onclick: () => {
                        location = "drivers.php";
                    }
                },
                n_dd_sales_tab: {
                    element: document.querySelector("#n_dd_sales_tab"),
                    onclick: () => {
                        location = "sales.php";
                    }
                },
                n_dd_profile_tab: {
                    element: document.querySelector("#n_dd_profile_tab"),
                    onclick: () => {
                        location = "profile.php";
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
                                    location = "login.php";
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
})();