<nav class="navbar">
    <div class="navbar-left">
        <ul>
            <li class="dropdown"><i class="fas fa-bars" tabindex="0"
                data-accesibility-trigger="sections-list"></i>
                <div class="dropdown-content left">
                <p><?=$l_arr["global"]["txt_20"];?></p>
                    <section id="sections-list">
                        <a id="n_dd_home_tab" href="?p=home" tabindex="1"><?=$l_arr["global"]["txt_1"];?></a>
                        <a id="n_dd_drivers_tab" href="?p=drivers" tabindex="1"><?=$l_arr["global"]["txt_2"];?></a>
                        <a id="n_dd_sales_tab" href="?p=sales" tabindex="1"><?=$l_arr["global"]["txt_3"];?></a>
                    </section>
                </div>
            </li>
            <li class="navbar-title">
                <a href="?p=welcome">
                    <img src="media/images/main_logo.png" alt="logo">
                </a>
            </li>
            <li class="navbar-location"><span data-location=""></span></li>
        </ul>
    </div>
    <div class="navbar-right">
        <ul>
            <li class="dropdown" id="relative-n-dd-notifications"><i class="fas fa-bell" tabindex="0"
                data-accesibility-trigger="notifications-list">
                <span class="badge hidden" id="n_dd_notifications_title_badge"></span></i>
                <div class="dropdown-content">
                    <p><?=$l_arr["global"]["txt_18"];?></p>
                    <section id="notifications-list">
                    </section>
                </div>
            </li>
            <li class="dropdown" id="relative-n-dd-reference"><i class="fas fa-user-circle" tabindex="0"
                data-accesibility-trigger="user-list"></i>
                <div class="dropdown-content">
                    <p data-username="">Thanos</p>
                    <section id="user-list">
                        <a class="hidden" id="action-tologin" data-session-variant="2" href="?p=login" tabindex="1"><i class="fas fa-sign-in-alt"></i><?=$l_arr["welcome"]["txt_1"];?></a>
                        <a class="hidden" id="action-toregister" data-session-variant="2" href="?p=register" tabindex="1"><i class="fas fa-user-plus"></i><?=$l_arr["welcome"]["txt_2"];?></a>
                        <div class="separator hidden" data-session-variant="2"></div>
                        <span id="n_dd_language_tab" data-collapse="0" tabindex="1"><i class="fas fa-chevron-up"></i><?=$l_arr["global"]["txt_17"];?>
                            <div class="collapse">    
                                <button id="language-set-spanish"><?=$l_arr["global"]["txt_23"];?></button>
                                <button id="language-set-english"><?=$l_arr["global"]["txt_24"];?></button>
                            </div>
                        </span>
                        <span id="n_dd_theme_tab" data-collapse="0" tabindex="1"><i class="fas fa-chevron-up"></i><?=$l_arr["global"]["txt_16"];?>
                            <div class="collapse">    
                                <button id="theme-set-light"><?=$l_arr["global"]["txt_21"];?></button>
                                <button id="theme-set-dark"><?=$l_arr["global"]["txt_22"];?></button>
                            </div>
                        </span>
                        <div class="separator" data-session-variant="1"></div>
                        <a id="n_dd_profile_tab" data-session-variant="1" href="?p=profile" tabindex="1"><i class="fas fa-cog"></i><?=$l_arr["global"]["txt_4"];?></a>
                        <a id="n_dd_exit_tab" data-session-variant="1" href="?p=signout" tabindex="1"><i class="fas fa-sign-out-alt"></i><?=$l_arr["global"]["txt_5"];?></a>
                    </section>
                </div>
            </li>
        </ul>
    </div>
</nav>
<script>
    document.querySelectorAll("[data-accesibility-trigger]").forEach(e => {
        e.addEventListener("keyup", event => {
            if (event.which != 13) return;
            let event_target = document.querySelector("#"+event.target.getAttribute("data-accesibility-trigger"));
            let current_tab = event_target.querySelector("#user-list > a, #user-list > span");
            let final_tab = null;
            while (1) {
                if (current_tab.hasAttribute("data-session-variant")
                    && !current_tab.classList.contains("hidden")
                    ) {
                    final_tab = current_tab;
                    break;
                }
                current_tab = current_tab.nextElementSibling;
            }
            final_tab.focus();
        });
    });
    document.querySelectorAll("[data-collapse]").forEach(element => {
        element.addEventListener("click", event => {
            let collapse_status = event.target.getAttribute("data-collapse");
            if (collapse_status == "0") {
                element.querySelector(".collapse").classList.add("collapse-deploy");
                element.setAttribute("data-collapse", "1");
            } else {
                element.querySelector(".collapse").classList.remove("collapse-deploy");
                element.setAttribute("data-collapse", "0");
            }
        });
    });
    document.querySelector("#language-set-spanish").addEventListener("click", e => {
        document.cookie = "l=spanish";
        location = location;
    });
    document.querySelector("#language-set-english").addEventListener("click", e => {
        document.cookie = "l=english";
        location = location;
    });
    document.querySelector("#theme-set-light").addEventListener("click", e => {
        document.querySelector("body").classList.add("theme-light");
        document.querySelector("body").classList.remove("theme-dark");
        document.cookie = "t=light";
    });
    document.querySelector("#theme-set-dark").addEventListener("click", e => {
        document.querySelector("body").classList.add("theme-dark");
        document.querySelector("body").classList.remove("theme-light");
        document.cookie = "t=dark";
    });
    theme = "<?=$_COOKIE["t"];?>";
    switch (theme) {
        case "dark":
            document.querySelector("body").classList.add("theme-dark");
            break;
        case "light":
            document.querySelector("body").classList.add("theme-light");
            break;
    }

    const check_notification = (pk_notificacion, fk_renta) => {
        new RequestMe().post("model/apis/", {
            api: "check_notification",
            pk_notificacion: pk_notificacion
        }).catch(err => console.error(err)
        ).then(response => {
            switch (response.code) {
                case 0:
                    location = `?p=sales&sale=${fk_renta}`
                    break;
            }
        });
    }

    const get_time_before = (fecha_hora) => {
        const time_milli = (new Date().getTime() - new Date(fecha_hora).getTime());
        const time_seconds = Math.floor(time_milli / 1000);
        const time_minutes = Math.floor(time_milli / (1000*60));
        const time_hours = Math.floor(time_milli / (1000*60*60));
        const time_days = Math.floor(time_milli / (1000*60*60*24));
        let time_arr = [time_seconds, time_minutes, time_hours, time_days];
        let time_strings_arr = [
            ["<?=$l_arr["global"]["txt_28"];?>", "<?=$l_arr["global"]["txt_29"];?>"], 
            ["<?=$l_arr["global"]["txt_30"];?>", "<?=$l_arr["global"]["txt_31"];?>"], 
            ["<?=$l_arr["global"]["txt_32"];?>", "<?=$l_arr["global"]["txt_33"];?>"], 
            ["<?=$l_arr["global"]["txt_34"];?>", "<?=$l_arr["global"]["txt_35"];?>"]
        ];
        let usable_time = 0;
        for (let i = 0; i < time_arr.length; i++) {
            if (time_arr[i] < 1) {
                break;
            }
            usable_time = i;
        }
        const usable_string = (time_arr[usable_time] == 1) ? 0 : 1;
        return time_arr[usable_time] + " " + time_strings_arr[usable_time][usable_string];
    }

    const load_notifications = () => {
        if (session_is_active == 0) {
            new RequestMe().post("model/apis/", {
                api: "get_notifications"
            }).catch(err => console.error(err)
            ).then(response => {
                let badge = document.querySelector("#n_dd_notifications_title_badge");
                let notifications_layout = document.querySelector("#notifications-list");
                switch (response.code) {
                    case 0:
                        badge.classList.remove("hidden");
                        badge.textContent = response.data.length;

                        notifications_layout.querySelectorAll("span").forEach(e => {
                            notifications_layout.removeChild(e);
                        });

                        for (let notification of response.data) {
                            const n_pk_notificacion = notification.pk_notificacion;
                            const n_fk_renta = notification.fk_renta;
                            const n_message = (notification.todo_bien == "0")
                                ? "<?=$l_arr["global"]["txt_26"];?>"
                                : "<?=$l_arr["global"]["txt_27"];?>";
                            let time_before = get_time_before(notification.fecha_hora);
                            let n_element = document.createElement("span");
                            n_element.setAttribute("tabindex", "1");
                            n_element.innerHTML = `
                                <i class="fas fa-circle"></i>
                                    ${n_message}
                                    <p>Hace ${time_before}</p>
                            `;

                            n_element.addEventListener("click", () => {
                                check_notification(n_pk_notificacion, n_fk_renta);
                            });

                            notifications_layout.appendChild(n_element);
                        }
                        break;
                    case -2:
                        badge.classList.add("hidden");

                        notifications_layout.querySelectorAll("span").forEach(e => {
                            notifications_layout.removeChild(e);
                        });
                        let empty_element = document.createElement("span");
                        empty_element.setAttribute("tabindex", "1");
                        empty_element.textContent = "<?=$l_arr["global"]["txt_25"];?>";
                        document.querySelector("#notifications-list").appendChild(empty_element);
                        break;
                    default:
                        console.log(response.code);
                }
            });
        }
    }

    let session_is_active = "<?php echo $ci0->existSession("user_data") ? "0" : "1";?>";
    if (session_is_active != 0) {
        document.querySelector("#relative-n-dd-notifications").classList.add("hidden");;
    }
    
    window.setInterval(() => {
        load_notifications();
    }, 10000);
    load_notifications();
</script>