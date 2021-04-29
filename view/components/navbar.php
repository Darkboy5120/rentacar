<nav class="navbar">
    <div class="navbar-left">
        <ul>
            <li class="navbar-title">
                <a href="?p=home">
                    <img src="media/images/main_logo.png" alt="logo">
                </a>
            </li>
            <li class="navbar-location"><span data-location=""></span></li>
        </ul>
    </div>
    <div class="navbar-right">
        <ul>
            <li class="dropdown"><i class="fas fa-bell" tabindex="0"
                data-accesibility-trigger="notifications-list"></i>
                <div class="dropdown-content">
                    <p>Notificaciones</p>
                    <section id="notifications-list">
                        <a href="#" tabindex="1">foo foo foo foo foo foo foo.</a>
                        <a href="#" tabindex="1">foo foo foo foo foo foo foo.</a>
                        <a href="#" tabindex="1">foo foo foo foo foo foo foo.</a>
                    </section>
                </div>
            </li>
            <li class="dropdown"><i class="fas fa-user" tabindex="0"
                data-accesibility-trigger="sections-list"></i>
                <div class="dropdown-content">
                    <p data-username="">Thanos</p>
                    <section id="sections-list">
                        <a id="n_dd_home_tab" href="?p=home" tabindex="1"><?=$l_arr["global"]["txt_1"];?></a>
                        <a id="n_dd_drivers_tab" href="?p=drivers" tabindex="1"><?=$l_arr["global"]["txt_2"];?></a>
                        <a id="n_dd_sales_tab" href="?p=sales" tabindex="1"><?=$l_arr["global"]["txt_3"];?></a>
                        <a id="n_dd_profile_tab" href="?p=profile" tabindex="1"><?=$l_arr["global"]["txt_4"];?></a>
                        <a id="n_dd_exit_tab" href="?p=signout" tabindex="1"><?=$l_arr["global"]["txt_5"];?></a>
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