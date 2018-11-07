import UIkit from 'uikit';
import NotificationsCount from '../../NotificationsCount';

function getMany(url, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(
            getRootUrl() + url + urlParameters,
            {credentials: 'same-origin'}
        )
        .then(response => {
            NotificationsCount.refreshDisplay(response);

            return new Promise((success) => {
                if (200 === response.status) {
                    response.json().then(data => {
                        success({
                            data: data,
                            count: response.headers.get('X-Total-Count')
                        });
                    });
                } else if (204 === response.status) {
                    success({
                        data: [],
                        count: 0
                    });
                } else {
                    UIkit.notification('An error as occurred (code: ' + response.status + ')', 'danger');
                }
            });
        });
}

function getOne(url, id, parameters = null) {
    let urlParameters = parameters ? "?" + urlEncodeParameters(parameters) : "";
    return fetch(
        getRootUrl() + url + "/" + id + urlParameters,
        {credentials: 'same-origin'}
    )
        .then(response => {
            NotificationsCount.refreshDisplay(response);

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
    return fetch(getRootUrl() + url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: urlEncodeParameters(parameters)
        })
        .then(response => {
            NotificationsCount.refreshDisplay(response);
            return new Promise((success, error) => {
                true === response.ok ? success(response.json()) : error(response.json());
            });
        });
}

function deleteOne (url, id) {
    return fetch(getRootUrl() + url + "/" + id, {
            method: 'DELETE',
            credentials: 'same-origin'
        })
        .then(response => {
            NotificationsCount.refreshDisplay(response);

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
    return fetch(getRootUrl() + url + "/" + action + urlParameters, {
                method: 'PATCH',
                credentials: 'same-origin',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(response => {
                NotificationsCount.refreshDisplay(response);

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
        let parameter = null;
        let value     = parametersBag[key];

        if (Array.isArray(parametersBag[key])) {
            parameter = value.join();
        } else {
            parameter = value;
        }

        if (undefined !== value && '' !== value) {
            parameters.push(key + "=" + parameter);
        }
    });

    return parameters.join('&')
}

function getRootUrl() {
    if (typeof window !== 'undefined') {
        return location.protocol + '//' + location.host + '/';
    }

    UIkit.notification('Could not determine server address', 'danger');
}

const Client = {
    getMany, getOne, post, deleteOne, patch
};

export default Client;