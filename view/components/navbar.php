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
            <li class="dropdown" id="relative-n-dd-reference"><i class="fas fa-user-circle" tabindex="0"
                data-accesibility-trigger="user-list"></i>
                <div class="dropdown-content">
                    <p data-username="">Thanos</p>
                    <section id="user-list">
                        <a class="hidden" id="action-tologin" data-session-variant="2" href="?p=login" tabindex="1"><i class="fas fa-sign-in-alt"></i><?=$l_arr["welcome"]["txt_1"];?></a>
                        <a class="hidden" id="action-toregister" data-session-variant="2" href="?p=register" tabindex="1"><i class="fas fa-user-plus"></i><?=$l_arr["welcome"]["txt_2"];?></a>
                        <div class="separator hidden" data-session-variant="2"></div>
                        <a id="n_dd_notifications_tab" data-session-variant="1" href="?p=notificacions" tabindex="1"><i class="fas fa-bell"></i><?=$l_arr["global"]["txt_18"];?></a>
                        <div class="separator" data-session-variant="1"></div>
                        <a id="n_dd_language_tab" href="?p=language" tabindex="1"><i class="fas fa-globe"></i><?=$l_arr["global"]["txt_17"];?></a>
                        <a id="n_dd_theme_tab" href="?p=theme" tabindex="1"><i class="fas fa-adjust"></i><?=$l_arr["global"]["txt_16"];?></a>
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
            event_target.querySelector("a").focus();
        });
    });
</script>