import { eventService } from '../services';
import router from '../router';

export const event = {
    namespaced: true,
    actions: {
        storeEvent({ dispatch, commit }, event) {

            eventService.storeEvent(event)
                .then(
                    data => {

                        // TODO: Fix this
                        // dispatch('/alert/success', 'Veranstaltung wurde erfolgreich hinzugefügt.', { root: true })

                        router.push('/events')
                    },
                    error => {
                        dispatch('alert/error', error, { root: true })
                    }
                )

        },
        deleteEvent({ dispatch, commit }, eventID) {

            eventService.deleteEvent(eventID)
                .then(
                    data => {

                    },
                    error => {
                        dispatch('alert/error', error, { root: true })
                    }
                )

        }

    },
    mutations: {
        storeEventSuccess(state, user) {

        },
        storeEventFailure(state) {

        },
    }

}