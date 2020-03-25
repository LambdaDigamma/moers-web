<template>

    <div>
        <div class="mt-8 bg-white shadow rounded-lg">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Allgemeine Informationen</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Trage die allgemeinen Informationen ein.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">

                        <div class="sm:col-span-4">
                            <TextInput
                                    id="name"
                                    label="Titel"
                                    placeholder="Titel"
                                    v-model="form.name"
                                    :errors="$page.errors.name"
                                    @input="changed">

                            </TextInput>
                        </div>

                        <PictureInput class="mt-4"
                                      label="Titelbild"
                                      @fileChanged="fileChanged"
                                      :errors="$page.errors.header_image" />

                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                    <PrimaryButton type="submit">
                        Speichern
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Datum</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Wähle den Veranstaltungszeitpunkt aus.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">

                            <div class="grid grid-cols-6 gap-6">

                                <DatePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="startDate"
                                        label="Anfangsdatum"
                                        placeholder="Anfangsdatum"
                                        v-model="form.startDate"
                                        :date="form.startDate"
                                        :disabled="form.noDate || isTranslation"
                                        :errors="$page.errors.start_date">

                                </DatePicker>

                                <Checkbox
                                        class="col-span-6 sm:col-span-2"
                                        id="start-whole-day"
                                        label="Ganztägig?"
                                        hint="Startet diese Veranstaltung zu einer bestimmten Uhrzeit?"
                                        v-model="form.startWholeDay"
                                        :disabled="form.noDate  || isTranslation">

                                </Checkbox>

                                <TimePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="startTime"
                                        label="Anfangszeit"
                                        placeholder="Anfangszeit"
                                        v-model="form.startTime"
                                        :time="form.startTime"
                                        :disabled="form.noDate || form.startWholeDay  || isTranslation">

                                </TimePicker>

                                <DatePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="endDate"
                                        label="Enddatum"
                                        placeholder="Enddatum"
                                        v-model="form.endDate"
                                        :disabled="form.noDate || isTranslation"
                                        :errors="$page.errors.end_date">

                                </DatePicker>

                                <Checkbox
                                        class="col-span-6 sm:col-span-2"
                                        id="end-whole-day"
                                        label="Ganztägig?"
                                        hint="Endet diese Veranstaltung zu einer bestimmten Uhrzeit?"
                                        v-model="form.endWholeDay"
                                        :disabled="form.noDate || isTranslation">

                                </Checkbox>

                                <TimePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="endTime"
                                        label="Endzeit"
                                        placeholder="Endzeit"
                                        v-model="form.endTime"
                                        :time="form.endTime"
                                        :disabled="form.noDate || form.endWholeDay || isTranslation">

                                </TimePicker>

                            </div>

                            <Checkbox
                                    class="mt-4"
                                    id="no-date"
                                    label="Datum unbekannt"
                                    hint="Das Datum ist noch nicht bekannt und wird erst später veröffentlicht."
                                    v-model="form.noDate"
                                    :disabled="isTranslation">

                            </Checkbox>


                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                    <PrimaryButton type="submit" :disabled="isTranslation">
                        Speichern
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden opacity-50">
            <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Veranstaltungsort</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        Wähle den Veranstaltungsort aus der Liste aus oder trage die Adresse ein.
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">

                        <!-- Select: Entry -->
                        <div class="col-span-6 sm:col-span-3">
                            <SelectInput
                                    label="Veranstaltungsort"
                                    :disabled="form.useTempLocation">
                                <option :value="null">
                                    Ort noch nicht bekannt
                                </option>
                                <option v-for="entry in entries" :value="entry.id">
                                    {{ entry.name }}
                                </option>
                            </SelectInput>
                        </div>

                        <!-- Checkbox: Use Temp Location -->
                        <div class="flex">
                            <Checkbox
                                    class="mt-4"
                                    id="use-temp-location"
                                    label="Anderen Ort verwenden"
                                    hint="Wenn der Ort nicht in der Liste verfügbar ist, kannst du ihn hier temporär eintragen."
                                    v-model="form.useTempLocation">

                            </Checkbox>
                        </div>


                        <!-- Form: Temporary Location -->
                        <!--                        <transition>-->
                        <div class="mt-4 grid grid-cols-6 gap-6" v-if="form.useTempLocation">

                            <TextInput class="col-span-5"
                                       id="street_address"
                                       label="Straße"
                                       placeholder="Straße" />

                            <TextInput class="col-span-1"
                                       id="house_number"
                                       label="Hausnummer"
                                       placeholder="Nr" />


                            <TextInput class="col-span-6 sm:col-span-6 lg:col-span-3"
                                       id="city"
                                       label="Stadt"
                                       placeholder="Stadt" />

                            <TextInput class="col-span-6 sm:col-span-6 lg:col-span-3"
                                       id="postcode"
                                       label="PLZ"
                                       placeholder="PLZ" />

                        </div>
                        <!--                        </transition>-->

                    </form>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <PrimaryButton>
                    Speichern
                </PrimaryButton>
            </div>
        </div>

        <PageEditor
                v-if="showPageEditor"
                class="mt-6"
                :initial-blocks="page.blocks"
                @save="submitPage">

        </PageEditor>

        <div class="mt-6 bg-white shadow rounded-lg">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 sm:p-6 md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Veröffentlichungsstatus</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Wähle einen Zeitpunkt aus, an dem die Veranstaltung veröffentlicht werden soll.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                            <Checkbox id="publish_now"
                                      label="Veranstaltung veröffentlichen."
                                      hint="Stelle ein, ob die Veranstaltung schon veröffentlich sein soll."
                                      v-model="form.publishNow"
                                      :disabled="isTranslation">

                            </Checkbox>

                            <div class="mt-4 grid grid-cols-6 gap-6" v-if="!form.publishNow">

                                <DatePicker
                                        class="col-span-6 sm:col-span-3"
                                        id="startDate"
                                        label="Veröffentlichungsdatum"
                                        placeholder="Veröffentlichungsdatum"
                                        v-model="form.scheduledAt"
                                        :date="form.scheduledAt"
                                        :disabled="form.publishNow || isTranslation">

                                </DatePicker>

                                <TimePicker
                                        class="col-span-6 sm:col-span-3"
                                        id="startTime"
                                        label="Veröffentlichungszeit"
                                        placeholder="Zeit"
                                        v-model="form.scheduledTime"
                                        :time="form.scheduledTime"
                                        :disabled="form.publishNow || isTranslation">

                                </TimePicker>

                            </div>


                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                    <PrimaryButton type="submit" :disabled="isTranslation">
                        Speichern
                    </PrimaryButton>
                </div>
            </form>
        </div>

    </div>

</template>

<script>
    import Checkbox from "../../../Shared/UI/Checkbox";
    import TimePicker from "../../../Shared/UI/TimePicker";
    import DatePicker from "../../../Shared/UI/DatePicker";
    import PrimaryButton from "../../../Shared/UI/PrimaryButton";
    import SelectInput from "../../../Shared/UI/SelectInput";
    import vuejsDatepicker from "vuejs-datepicker";
    import ImagePreviewInput from "../../../Shared/UI/ImagePreviewInput";
    import PictureInput from "../../../Shared/UI/PictureInput";
    import LanguagePicker from "../../../Shared/UI/LanguagePicker";
    import PageEditor from "../../../Shared/PageEditor";
    import TextareaInput from "../../../Shared/TextareaInput";
    import TextInput from "../../../Shared/TextInput";
    import LoadingButton from "../../../Shared/LoadingButton";
    import CardContainer from "../../../Shared/UI/CardContainer";
    import {de} from "vuejs-datepicker/dist/locale";
    import moment from 'moment';

    export default {
        name: "EventForm",
        components: {
            Checkbox,
            TimePicker,
            DatePicker,
            PrimaryButton,
            SelectInput,
            vuejsDatepicker,
            ImagePreviewInput, PictureInput,
            LanguagePicker, PageEditor, TextareaInput, TextInput, LoadingButton, CardContainer
        },
        props: {
            languageCode: {
                type: String,
                default: 'de'
            },
            organisation: Object,
            entries: Array,
            event: {
                type: Object,
                default() {
                    return {
                        start_date: null,
                        end_date: null
                    }
                }
            },
            initialPage: {
                type: Object,
                default() {
                    return {
                        blocks: []
                    }
                }
            },
            showPageEditor: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            fileChanged(image) {
                if (image) {
                    console.log('Picture loaded.')
                    this.form.header_image = image
                } else {
                    console.log('FileReader API not supported: use the , Luke!')
                }
                this.changed()
            },
            submit() {
                this.$emit('submit', this.formData)
            },
            changed() {
                this.$emit('changed', this.formData)
            },
            submitPage(page) {
                this.$emit('page-change', page)
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
            endDate() {

                if (this.form.endDate && !this.form.noDate) {
                    let endDate = moment(this.form.endDate)
                    if (this.form.endTime) {
                        let timeComponents = this.form.endTime.split(":")
                        endDate.hours(parseInt(timeComponents[0]))
                        endDate.minutes(parseInt(timeComponents[1]))
                        endDate.seconds(0)
                    } else {
                        endDate.hours(0)
                        endDate.minutes(0)
                        endDate.seconds(0)
                    }
                    return endDate
                } else {
                    return null
                }

            },
            scheduledDate() {

                if (!this.form.publishNow) {
                    let scheduleDate = moment(this.form.scheduledAt)
                    if (this.form.scheduledTime) {
                        let timeComponents = this.form.scheduledTime.split(":")
                        scheduleDate.hours(parseInt(timeComponents[0]))
                        scheduleDate.minutes(parseInt(timeComponents[1]))
                        scheduleDate.seconds(0)
                    } else {
                        scheduleDate.hours(0)
                        scheduleDate.minutes(0)
                        scheduleDate.seconds(0)
                    }
                    return scheduleDate
                } else {
                    return null
                }

            },
            formData() {

                let data = new FormData()
                data.append('name', this.form.name || '')
                data.append('header_image', this.form.header_image || '')

                if (this.startDate !== null) {
                    data.append('start_date', this.startDate.format('YYYY-MM-DD HH:mm:ss'))
                } else {
                    data.append('start_date', "")
                }

                if (this.endDate !== null) {
                    data.append('end_date', this.endDate.format('YYYY-MM-DD HH:mm:ss'))
                } else {
                    data.append('end_date', "")
                }

                if (this.scheduledDate !== null) {
                    data.append('scheduled_at', this.scheduledDate.format('YYYY-MM-DD HH:mm:ss'))
                } else {
                    data.append('scheduled_at', "")
                }

                return data
            },
            startWholeDay() {
                return this.form.startWholeDay;
            },
            endWholeDay() {
                return this.form.endWholeDay;
            },
            isTranslation() {
                return this.languageCode !== this.standardCode
            }
        },
        watch: {
            startWholeDay(startWholeDay) {
                if (startWholeDay) {
                    this.form.startTime = null
                }
            },
            endWholeDay(endWholeDay) {
                if (endWholeDay) {
                    this.form.endTime = null
                }
            }
        },
        data() {
            return {
                de: de,
                standardCode: "de",
                form: {
                    name: this.event.name,
                    header_image: null,
                    startDate: this.event.start_date !== null ? moment(this.event.start_date).toDate() : null,
                    startTime: this.event.start_date !== null ? moment(this.event.start_date).format("HH:mm") : null,
                    startWholeDay: this.event.start_date !== null ? moment(this.event.start_date).format("HH:mm") === "00:00" : false,
                    endDate: this.event.end_date !== null ? moment(this.event.end_date).toDate() : null,
                    endTime: this.event.end_date !== null ? moment(this.event.end_date).format("HH:mm") : null,
                    endWholeDay: this.event.end_date !== null ? moment(this.event.end_date).format("HH:mm") === "00:00" : false,
                    useTempLocation: false,
                    noDate: false,
                    scheduledAt: this.event.scheduled_at !== null ? moment(this.event.scheduled_at).toDate() : null,
                    scheduledTime: this.event.scheduled_at !== null ? moment(this.event.scheduled_at).format("HH:mm") : null,
                    publishNow: this.event.scheduled_at !== null ? this.event.scheduledAt === null : true,
                },
                page: this.initialPage !== null ? this.initialPage : { blocks: [] }
            }
        },
    }
</script>

<style scoped>

</style>