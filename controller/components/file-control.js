const FileControl = function (inputSelector, options) {
    let files = [];
    let input = {
        element: document.querySelector(inputSelector)
    };
    const itsAllRight = () => {
        if (files.length == 0) {
            log.print(log.message.empty);
            return false;
        } else if (files.length < options.min) {
            log.print(log.message.minLength);
            return false;
        } else if (files.length > options.max) {
            log.print(log.message.maxLength);
            return false;
        }
        log.print(log.message.success);
        return true;
    }
    const plural = " imagenes";
    const singular = " imagen";
    let log = {
        element: input.element.parentNode.parentNode.querySelector(".input-log"),
        message: {
            minLength: "No debe tener menos de " + options.min + ((options.min > 1)
                ? plural : singular),
            maxLength: "No debe tener más de " + options.max + ((options.max > 1)
            ? plural : singular),
            empty: "Completa este campo",
            success : "El valor es correcto"
        },
        print: (message) => {
            log.element.textContent = message;
            log.element.classList.remove("hidden");
        },
        hide: () => {
            log.element.classList.add("hidden");
        }
    };
    let images = {
        status: 0,
        element : input.element.parentNode.querySelector(".file-container > .file-images"),
        show: () => {
            images.element.classList.remove("hidden");
        },
        hide: () => {
            images.element.classList.add("hidden");
        },
        update: () => {
            let r = itsAllRight();
            if (files.length > 0) {
                images.show();
                empty.hide();
                button.edit.show();
            } else {
                images.hide();
                empty.show();
                button.edit.hide();
            }
        },
        handleFiles: function (f) {
            if (f.length) this.files = f;
            for (let i = 0; i < this.files.length; i++) {
                let file = this.files[i];
                let imageType = /image.*/;
            
                const isDuplicated = files.filter(f => file.name == f.name).length > 0;
                if (!file.type.match(imageType)) {
                  continue;
                } else if (isDuplicated) {
                    continue;
                }

                files.push(file);
            
                let div = document.createElement("div");
                let remove_icon = document.createElement("i");
                remove_icon.classList.add("file-remove", "fas", "fa-trash-alt");
                remove_icon.addEventListener("click", e => {
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].name == file.name) {
                            delete files[i];
                            files.splice(i, 1);
                            div.remove();
                            images.update();
                            let r = itsAllRight();
                        }
                    }
                });
                let img = document.createElement("img");
                div.classList.add("file-image");
                div.appendChild(img);
                div.appendChild(remove_icon);
                img.file = file;
                images.element.appendChild(div);
            
                let reader = new FileReader();
                reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
                reader.readAsDataURL(file);
            }
            images.update();
        },
        dragenter: function (e) {
            images.element.classList.add("file-dragover");
            empty.element.classList.add("file-dragover");
            e.stopPropagation();
            e.preventDefault();
        },
        dragover: function (e) {
            e.stopPropagation();
            e.preventDefault();
        },
        dragleave: function (e) {
            images.element.classList.remove("file-dragover");
            empty.element.classList.remove("file-dragover");
            e.stopPropagation();
            e.preventDefault();
        },
        drop: function (e) {
            images.element.classList.remove("file-dragover");
            empty.element.classList.remove("file-dragover");
            e.stopPropagation();
            e.preventDefault();

            let dt = e.dataTransfer;
            let files = dt.files;
            images.handleFiles(files);
        }
    };
    let label = {
        element: input.element.parentNode.parentNode.querySelector("label")
    }
    let empty = {
        element: input.element.parentNode.querySelector(".file-container > .file-empty"),
        show: () => {
            empty.element.classList.remove("hidden");
        },
        hide: () => {
            empty.element.classList.add("hidden");
        }
    };
    let button = {
        add: {
            element: input.element.parentNode.querySelector(".file-container > .file-actions > .file-add"),
            onclick: () => {
                input.element.click();
            },
            show: () => {
                button.add.element.classList.remove("hidden");
            },
            hide: () => {
                button.add.element.classList.add("hidden");
            }
        },
        edit: {
            element: input.element.parentNode.querySelector(".file-container > .file-actions > .file-edit"),
            onclick: () => {
                images.element.classList.add("editing");
                images.status = 1;
            },
            show: () => {
                button.edit.element.classList.remove("hidden");
            },
            hide: () => {
                button.edit.element.classList.add("hidden");
            }
        }
    };
    const focus = () => {
        console.log(label.element);
        label.element.scrollIntoView();
    }
    images.hide();
    button.edit.hide();
    let r = itsAllRight();
    if (!input.element.classList.contains("hidden")) {
        input.element.classList.add("hidden");
    }
    window.addEventListener("click", e => {
        switch (images.status) {
            case 0:
                break;
            case 1:
                if (!e.target.classList.contains("file-edit")) {
                    images.element.classList.remove("editing");
                    images.status = 0;
                }
                break;
            case 2:
                break;
        }
    });
    button.add.element.addEventListener("click", button.add.onclick);
    button.edit.element.addEventListener("click", button.edit.onclick);
    input.element.addEventListener("change", images.handleFiles, false);
    images.element.addEventListener("dragenter", images.dragenter, false);
    images.element.addEventListener("dragleave", images.dragleave, false);
    images.element.addEventListener("dragover", images.dragover, false);
    images.element.addEventListener("drop", images.drop, false);
    empty.element.addEventListener("dragenter", images.dragenter, false);
    empty.element.addEventListener("dragleave", images.dragleave, false);
    empty.element.addEventListener("dragover", images.dragover, false);
    empty.element.addEventListener("drop", images.drop, false);

    return {
        isDone : function () {
            return (itsAllRight()) ? true : false;
        },
        printLog : log.print,
        val: () => {
            return files;
        },
        files: files,
        isEmpty : files.length == 0,
        focus: focus
    };
}