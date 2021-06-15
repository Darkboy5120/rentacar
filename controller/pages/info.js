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
    
    new RequestMe().get("https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno/", {
        token: "4792c8af9e227ad9f40f3e9244897afa654fda1c26502b7da7fdb59b1fa1db67"
    }).then(response => {
        const dolar_en_peso = response.bmx.series[0].datos[0].dato;
        console.log(dolar_en_peso);
    });

    hideLoadingScreen();
})();