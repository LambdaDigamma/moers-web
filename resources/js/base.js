import _ from 'lodash';

export default {
    computed: {
        MeinMoers() {
            return MeinMoers;
        }
    },

    methods: {

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