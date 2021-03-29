const RequestMe = function () {
    const post = (url, data) => {
        return fetch(url, {
            method : 'POST',
            body : new URLSearchParams(data),
            headers : {
                'Content-Type' : 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .catch(error => console.error(error));
    }
    return {
        post : post
    };
}