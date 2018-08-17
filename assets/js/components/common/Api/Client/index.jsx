import UIkit from 'uikit';

function getMany(url, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(
            "http://127.0.0.1:8001/front/api/" + url + urlParameters,
            {credentials: 'same-origin'}
        )
        .then(response => {
            return new Promise((success) => {
                if (200 === response.status) {
                    success(response.json());
                } else if (204 === response.status) {
                    success([]);
                } else {
                    UIkit.notification('An error as occurred (code: ' + response.status + ')', 'danger');
                }
            });
        });
}

function post(url, parameters) {
    return fetch("http://127.0.0.1:8001/front/api/" + url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: urlEncodeParameters(parameters)
        })
        .then(response => {
            return new Promise((success, error) => {
                true === response.ok ? success(response.json()) : error(response.status, response.json());
            });
        });
}

function deleteOne (url, objectId) {
    return fetch("http://127.0.0.1:8001/front/api/" + url + "/" + objectId, {
            method: 'DELETE',
            credentials: 'same-origin'
        })
        .then(response => {
            return new Promise((success) => {
                if (200 === response.status) {
                    success(response.json());
                } else if (204 === response.status) {
                    success([]);
                } else {
                    UIkit.notification('An error as occurred (code: ' + response.status + ')', 'danger');
                }
            });
        });
}

function urlEncodeParameters(parametersBag) {
    if (null === parametersBag) {
        return "";
    }

    var parameters = [];
    Object.keys(parametersBag).map(function(key) {
        var parameter = null;
        if (Array.isArray(parametersBag[key])) {
            parameter = parametersBag[key].join();
        } else {
            parameter = parametersBag[key];
        }

        parameters.push(key + "=" + parameter);
    });

    return parameters.join('&')
}

const Client = {
    getMany, post, deleteOne
};

export default Client;