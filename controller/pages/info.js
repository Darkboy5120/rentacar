(function () {
    const pageName = l_arr.info.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    if (activeSession == "1") {
        document.querySelectorAll("[data-session-variant='1']").forEach(e => {
            e.classList.remove("hidden");
        });
        document.querySelectorAll("[data-session-variant='2']").forEach(e => {
            e.classList.add("hidden");
        });
    } else {
        document.querySelectorAll("[data-session-variant='1']").forEach(e => {
            e.classList.add("hidden");
        });
        document.querySelectorAll("[data-session-variant='2']").forEach(e => {
            e.classList.remove("hidden");
        });
    }

    hideLoadingScreen();
})();