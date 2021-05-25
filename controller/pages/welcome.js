(function () {
    const userName = l_arr.welcome.txt_0;
    const pageName = l_arr.welcome.page_name;
    document.querySelector("title").textContent = l_arr.global.app_name
        + l_arr.global.title_separator + pageName;
    document.querySelectorAll("[data-location]").forEach(element => {
        element.textContent = pageName;
    });
    document.querySelectorAll("[data-username]").forEach(e => {
        e.textContent = userName;
    });
    document.querySelectorAll("[data-session-variant='1']").forEach(e => {
        e.classList.add("hidden");
    });
    document.querySelectorAll("[data-session-variant='2']").forEach(e => {
        e.classList.remove("hidden");
    });
    
    let form = {
        global: {
            button: {
                action_tologin: {
                    element: document.querySelector("#action-tologin"),
                    onclick: () => {
                        location = "?p=login";
                    }
                },
                action_toregister: {
                    element: document.querySelector("#action-toregister"),
                    onclick: () => {
                        location = "?p=register";
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
                    input[iname].element.addEventListener("keydown", e => {
                        if (e.which == 13) {
                            button[bname].onclick();
                        }
                    });
                }
            }
        }
    }

    window.addEventListener("scroll", e => {
        document.querySelector("#w-header > .bg-text").style.top = (window.scrollY * .5) + "px";
        document.querySelector("#w-header > .bg-text").style.opacity = (1 / (window.scrollY * .01));
        document.querySelector("#w-header > .bg-text > h1").style.paddingLeft = ((window.scrollY * .5) + "px");
        document.querySelector("#w-header > .bg-text > p").style.paddingRight = ((window.scrollY * .5) + "px");
    });
})();