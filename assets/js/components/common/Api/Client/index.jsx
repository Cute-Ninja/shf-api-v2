import UIkit from 'uikit';

function getMany(url, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(
            getFrontUrl() + url + urlParameters,
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

function getOne(url, id, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(
        getFrontUrl() + url + "/" + id + urlParameters,
        {credentials: 'same-origin'}
    )
        .then(response => {
            return new Promise((success) => {
                if (200 === response.status) {
                    success(response.json());
                } else if (404 === response.status) {
                    success(null);
                } else {
                    UIkit.notification('An error as occurred (code: ' + response.status + ')', 'danger');
                }
            });
        });
}

function post(url, parameters) {
    return fetch(getFrontUrl() + url, {
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

function deleteOne (url, id) {
    return fetch(getFrontUrl() + url + "/" + id, {
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

function patch(url, action,parameters) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(getFrontUrl() + url + "/" + action + urlParameters, {
                method: 'PATCH',
                credentials: 'same-origin',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
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

function getFrontUrl() {
    return getRootUrl() + '/front/api/';
}

function getAdminUrl() {
    return getRootUrl() + '/admin/api/';
}

function getRootUrl() {
    if (typeof window !== 'undefined') {
        return location.protocol + '//' + location.host;
    }

    UIkit.notification('Could not determine server address', 'danger');
}

const Client = {
    getMany, getOne, post, deleteOne, patch
};

export default Client;