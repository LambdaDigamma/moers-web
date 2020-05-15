<template>

    <div class="pb-20">
        <header>
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Livestream - moers festival
                </h2>
            </div>
        </header>

        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Konfiguration</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Gib hier ein, wann der Livestream starten soll und hinterlege den Link.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="submit">
                        <div class="rounded-md shadow bg-white">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-3">
                                        <div class="grid grid-cols-6 gap-6">
                                            <DatePicker
                                                    class="col-span-6 sm:col-span-3"
                                                    id="startDate"
                                                    label="Start-Datum des Streams"
                                                    placeholder="Datum"
                                                    v-model="form.startDate"
                                                    :date="form.startDate">

                                            </DatePicker>

                                            <TimePicker
                                                    class="col-span-6 sm:col-span-3"
                                                    id="startTime"
                                                    label="Start-Zeit des Streams"
                                                    placeholder="Zeit"
                                                    v-model="form.startTime"
                                                    :time="form.startTime">

                                            </TimePicker>

                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-6 mt-6">
                                    <div class="col-span-3 sm:col-span-3">
                                        <TextInput label="Stream-URL" placeholder="Stream-URL" v-model="form.url" :errors="$page.errors.url"
                                                   hint="Gib hier die aktuelle Livestream URL ein." />
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6 rounded-b-lg">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                                        Speichern
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden sm:block">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Pause-Ansicht</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Wenn gerade keine Veranstaltung gespielt wird, werden diese Informationen angezeigt.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="submit">
                        <div class="rounded-md shadow bg-white">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-3">
                                        <TextInput label="Titel" placeholder="Titel" v-model="form.failure_title" :errors="$page.errors.failure_title" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-6 mt-6">
                                    <div class="col-span-3 sm:col-span-3">
                                        <TextInput label="Beschreibung" placeholder="Beschreibung" v-model="form.failure_description" :errors="$page.errors.failure_description" />
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6 rounded-b-lg">
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                                        Speichern
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import TextareaInput from "../../../Shared/TextareaInput";
    import TextInput from "../../../Shared/TextInput";
    import DatePicker from "../../../Shared/UI/DatePicker";
    import TimePicker from "../../../Shared/UI/TimePicker";
    import moment from "moment";

    export default {
        name: "Stream",
        layout: LayoutAdmin,
        components: {TimePicker, DatePicker, TextareaInput, TextInput},
        props: {
            stream: Object
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    url: this.stream.url,
                    startDate: this.stream.start_date !== null ? moment(this.stream.start_date).toDate() : null,
                    startTime: this.stream.start_date !== null ? moment(this.stream.start_date).format("HH:mm") : null,
                    failure_title: this.stream.failure_title,
                    failure_description: this.stream.failure_description,
                },
            }
        },
        computed: {
            startDate() {

                if (this.form.startDate && !this.form.noDate) {
                    let startDate = moment(this.form.startDate)
                    if (this.form.startTime) {
                        let timeComponents = this.form.startTime.split(":")
                        startDate.hours(parseInt(timeComponents[0]))
                        startDate.minutes(parseInt(timeComponents[1]))
                        startDate.seconds(0)
                    } else {
                        startDate.hours(0)
                        startDate.minutes(0)
                        startDate.seconds(0)
                    }
                    return startDate
                } else {
                    return null
                }

            },
            formData() {

                let data = new FormData()
                data.append('stream_url', this.form.url || '')
                data.append('failure_title', this.form.failure_title || '')
                data.append('failure_description', this.form.failure_description || '')

                if (this.startDate !== null) {
                    data.append('start_date', this.startDate.format('YYYY-MM-DD HH:mm:ss'))
                } else {
                    data.append('start_date', "")
                }

                return data
            },
        },
        methods: {
            submit() {
                let formData = this.formData
                formData.append('_method', 'put')
                this.$inertia
                    .post(this.route('admin.moers-festival.stream.update'), formData)
            },
        }
    }
</script>

<style scoped>

</style>