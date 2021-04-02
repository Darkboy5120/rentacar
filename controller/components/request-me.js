const RequestMe = function () {
    const post = (url, data) => {
        let formData = new FormData();
        for (let name in data) {
            formData.append(name, data[name]);
        }
        return fetch(url, {
            method : 'POST',
            /*body : new URLSearchParams(data),*/
            body : formData/*,
            headers : {
                'Content-Type' : 'application/x-www-form-urlencoded'
            }*/
        })
        .then(response => response.json())
        .catch(error => console.error(error));
    }
    return {
        post : post
    };
}