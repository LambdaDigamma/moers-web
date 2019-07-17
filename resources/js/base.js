import _ from 'lodash';
import moment from 'moment-timezone';

export default {
    computed: {
        MeinMoers() {
            return MeinMoers;
        }
    },


    methods: {
        /**
         * Show the time in local time.
         */
        localTime(time) {
            return moment(time + ' Z').utc().local().format('MMMM Do YYYY, h:mm:ss A');
        },


        /**
         * Truncate the given string.
         */
        truncate(string, length = 70) {
            return _.truncate(string, {
                'length': length,
                'separator': /,? +/
            });
        },


        /**
         * Creates a debounced function that delays invoking a callback.
         */
        debouncer: _.debounce(callback => callback(), 500),

    }
};