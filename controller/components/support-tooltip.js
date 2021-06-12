const SupportTooltip = () => {
     const ActiveAll = () => {
        document.querySelectorAll("[data-support-tooltip-content]").forEach(parent => {
            let hide_element = null;
            let element = document.createElement("DIV");
            element.classList.add("support-tooltip", "hidden");
            const content = parent.getAttribute("data-support-tooltip-content");
            element.innerHTML = `
                <p>${content}</p>
            `;
            parent.appendChild(element);

            const on_click_event = () => {
                if (hide_element != null) {
                    clearTimeout(hide_element);
                    element.classList.add("hidden");
                    hide_element = null;
                } else {
                    element.classList.remove("hidden");
                    hide_element = window.setTimeout(() => {
                        element.classList.add("hidden");
                        hide_element = null;
                    }, 3000);
                }
            }

            parent.addEventListener("click", e => {
                on_click_event();
            });
            element.addEventListener("click", e => {
                e.preventDefault();
                e.stopPropagation();
                on_click_event();
            });
        });
    }
    return {
        ActiveAll: ActiveAll
    }
}

SupportTooltip().ActiveAll();