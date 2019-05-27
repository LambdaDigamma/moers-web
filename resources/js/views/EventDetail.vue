<template>

    <div style="margin-top: 2em">

        <b-card header="Details">
            <div slot="header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>Details</h5>
                    <div class="d-flex align-items-end w-25">
                        <button class="btn btn-primary text-white mr-3 w-50" title="Edit Organisation" @click="toggleEditModeEvent()">
                            <b class="text-white">{{ isEditingEvents ? 'Cancel' : 'Edit' }}</b>
                        </button>
                        <button class="btn btn-success text-white w-50" title="Save" :disabled="!isEditingEvents">
                            <b class="text-white">Save</b>
                        </button>
                    </div>
                </div>
            </div>

            <event-form></event-form>

        </b-card>

    </div>

</template>

<script>
    import EventForm from './../components/EventForm.vue'
    import { mapActions, mapState } from 'vuex'
    export default {
        name: "EventDetail",
        components: { EventForm },
        computed: {
            ...mapState(['events', 'entries', 'isEditingEvents']),
        },
        methods: {
            ...mapActions(['toggleEditModeEvent'])
        },
    }
</script>

<style scoped>
</style>