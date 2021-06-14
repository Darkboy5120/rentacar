(function () {
    const pageName = l_arr.info.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.classList.add("hidden");
    });
    document.querySelectorAll("[data-session-variant='1']").forEach(e => {
        e.classList.add("hidden");
    });

    hideLoadingScreen();
})();