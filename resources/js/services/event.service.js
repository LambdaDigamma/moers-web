import axios from 'axios';

export const eventService = {
    storeEvent,
    deleteEvent
};

function storeEvent(event) {

    return axios({
        method: 'POST',
        url: '/api/v2/moers-festival/events',
        data: event,
    })

}

function deleteEvent(eventID) {

    return axios({
        method: 'DELETE',
        url: 'api/v2/moers-festival/event/' + eventID,
    })

}