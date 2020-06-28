import { apiUrl } from '../_helpers';
import { authHeader } from '../_helpers';

export const itemService = {
    listItem,
    detailItem,
    listBidItem,
    listItemAwarded,
    bid
};


function listItemAwarded() {
    const requestOptions = {
        method: 'GET',
        headers: { ...authHeader(), 'Content-Type': 'application/json' },
    };

    return fetch(apiUrl() + '/items-awarded', requestOptions)
        .then(handleResponse);
}

function listBidItem() {
    const requestOptions = {
        method: 'GET',
        headers: { ...authHeader(), 'Content-Type': 'application/json' },
    };

    return fetch(apiUrl() + '/items-bid', requestOptions)
        .then(handleResponse);
}

function bid(price, item_id) {
    const requestOptions = {
        method: 'POST',
        headers: { ...authHeader(), 'Content-Type': 'application/json' },
        body: JSON.stringify({ price, item_id })
    };
    return fetch(apiUrl() + '/bid', requestOptions)
        .then(handleResponse)
        .then(message => {
            return message;
        });
}

function listItem() {
    const requestOptions = {
        method: 'GET',
        headers: { ...authHeader(), 'Content-Type': 'application/json' },
    };

    return fetch(apiUrl() + '/items', requestOptions)
        .then(handleResponse);
}

function detailItem(item_id) {
    const requestOptions = {
        method: 'GET',
        headers: { ...authHeader(), 'Content-Type': 'application/json' },
    };
    if(item_id.item_id != undefined)
        item_id = item_id.item_id;
    return fetch(apiUrl() + '/item?item_id=' + item_id, requestOptions)
        .then(handleResponse);
}

function handleResponse(response) {
    return response.text().then(text => {
        const data = text && JSON.parse(text);
        if (!response.ok) {
            if (response.status === 401) {
                // auto logout if 401 response returned from api
                logout();
                location.reload(true);
            }
            const error = (data && data["error"][0]) || response.statusText;
            return Promise.reject(error);
        }

        return data;
    });
}