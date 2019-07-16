<template>
    
    <div>

        <p>Events</p>

    </div>

</template>

<script>

import { mapGetters } from "vuex"

export default {
    name: 'OrganisationEvents',
    computed: {
        ...mapGetters(["currentUser", "isAuthenticated", "organisation"])
    },
}
</script>
