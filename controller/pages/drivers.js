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
    document.querySelector("#n_dd_profile_tab").classList.add("dropdown-active");
    
    hideLoadingScreen();

    const modalNewDriverConfirm = new Modal("#newDriverConfirm");
    const modalDriverCode = new Modal("#newDriverCode");
    const modalDriverOptions = new Modal("#driverOptions");
    document.querySelector("#newDriver").addEventListener("click", e => {
        modalNewDriverConfirm.show();
    });
    document.querySelector("#newDriverGen").addEventListener("click", e => {
        modalNewDriverConfirm.hide();
        modalDriverCode.show();
    });
    document.querySelectorAll(".card-sale").forEach(element => {
        element.addEventListener("click", event => {
            modalDriverOptions.show();
        });
    });
    document.querySelector("#searchAction").addEventListener("click", e => {
        document.querySelector("#searchAction").querySelector("input").focus();
    });
})();