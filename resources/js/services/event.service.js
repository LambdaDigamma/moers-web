import axios from 'axios';

export const eventService = {
    store,
};

function store(event) {

    return axios({
        method: 'POST',
        url: '/api/v2/moers-festival/events',
        data: event,
    })

}