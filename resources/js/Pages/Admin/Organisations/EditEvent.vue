<template>

    <div class="pb-32">

        <div class="flex flex-col md:flex-row justify-between">
            <div>
                <h3 class="text-gray-900 text-3xl font-bold">Veranstaltung bearbeiten</h3>
                <p class="text-gray-600">Bearbeite die Veranstaltung für diese Organisation.</p>
            </div>
            <LanguagePicker :languageCode="lang" class="mt-4 md:mt-0" @change="languageChanged" />
        </div>

        <EventForm
                :languageCode="lang"
                :organisation="organisation"
                :entries="entries"
                :event="event"
                :initial-page="page"
                @changed="changed"
                @submit="submit"
                @page-change="submitPage">

        </EventForm>

    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import EventForm from "../../../Pages/Admin/Organisations/EventForm";

    export default {
        name: "EditEvent",
        components: {EventForm},
        layout: LayoutAdmin,
        props: {
            event: Object,
            organisation: Object,
            entries: Array,
            lang: String,
            page: {
                type: Object,
                default() {
                    return {
                        blocks: []
                    }
                }
            }
        },
        remember: 'form',
        data() {
            return {
                languageCode: this.lang,
                sending: false,
                form: null
            }
        },
        methods: {
            fileChanged(image) {
                console.log(image)
                console.log('New picture selected!')
                if (image) {
                    console.log('Picture loaded.')
                    this.form.header_image = image
                } else {
                    console.log('FileReader API not supported: use the , Luke!')
                }
            },
            changed(formData) {
                this.form = formData
            },
            submit(formData) {
                formData.append('_method', 'put')
                this.$inertia
                    .post(this.route('admin.organisations.events.update', [this.organisation.id, this.event.id, this.languageCode]), formData)
                    .then(() => this.sending = false)
            },
            languageChanged(languageCode) {
                this.languageCode = languageCode
                this.$inertia.visit(this.route('admin.organisations.events.edit',
                    [this.organisation.id, this.event.id, languageCode]), {
                    method: 'get',
                    data: {},
                    preserveState: false,
                    preserveScroll: true,
                    only: [],
                })
            },
            submitPage(blocks) {

                let data = {
                    blocks: blocks
                }

                if (this.page !== null) {
                    data = this.page
                    data.blocks = blocks
                }

                this.$inertia.put(this.route('admin.organisations.events.page.update', [this.organisation.id, this.event.id, this.lang]), data, {
                    replace: false,
                    preserveState: false,
                    preserveScroll: true,
                    only: [],
                })
            },
        }
    }
</script>

<style scoped>

</style>