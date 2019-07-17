<template>
    <div>
        <b-card class="event-card mb-3">
            <b-media vertical-align="center">
                <b-img slot="aside" blank blank-color="#abc" width="64" rounded alt="placeholder"></b-img>
                <h5 class="mt-0 mb-0">{{ this.event.name }}</h5>
                <p class="text-muted mt-0 mb-0">{{ organizer }}</p>
                <p class="mt-0 mb-0">{{ this.event.start_date | moment('dddd, DD.MM. hh:mm') }} - {{ this.event.end_date | moment('DD.MM. hh:mm') }}</p>
            </b-media>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "EventItem",
    props: {
        event: {
            type: Object,
            required: true
        },
        organisation: {
            type: Object,
            required: false
        }
    },
    computed: {
        organizer: function() {
            if (this.event.hasOwnProperty("extras")) {
                if (this.event.extras !== null && this.event.extras.hasOwnProperty("organizer")) {
                    return this.event.extras.organizer
                }
            }
            if (this.organisation !== undefined && this.organisation !== null) {
                return this.organisation.name
            }
            return "Organisator nicht bekannt"
        },
        date: function() {
            if (this.event.start_date !== null && this.event.end_date !== null) {
                
            }


        }
    }
}
</script>

