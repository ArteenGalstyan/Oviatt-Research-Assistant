/**
 * POST wrapper for DOM Ajax API
 * @param endpoint
 * @param params
 * @param success
 * @param error
 */
function post(endpoint, params, success, error, csrf = true) {

    const xhr = new XMLHttpRequest();
    let paramString = ''; let callback = '';

    /* Setup POST method XHR object */
    xhr.open("POST", endpoint);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (csrf) {
        xhr.setRequestHeader('X-CSRF-Token', document.getElementsByTagName('meta')["csrf-token"].content)
    }
    xhr.onreadystatechange = function() {

        /* Assign the callback function when the request returns based on HTTP status codes */
        if (this.readyState === XMLHttpRequest.DONE) {
            (callback = this.status === 200 ? success : error)(xhr.response);
        }
    }

    /* Build the parameter string for the XHR request body */
    for (let key in params) {
        if (params.hasOwnProperty(key)) {
            paramString += (key + "=" + params[key] + "&");
        }
    }
    /* Chop off the last '&' character */
    paramString = paramString.substr(0, paramString.length-1);

    /* Fire away */
    xhr.send(paramString);
}
