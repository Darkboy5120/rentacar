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

    const modalSaleInfo = new Modal("#saleInfo");

    document.querySelectorAll(".card-sale").forEach(element => {
        element.addEventListener("click", event => {
            modalSaleInfo.show();
        });
    });
})();