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
                                      @fileChanged="fileChanged" />


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
            <form action="#" method="POST">
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
                                        :disabled="form.noDate">

                                </DatePicker>

                                <Checkbox
                                        class="col-span-6 sm:col-span-2"
                                        id="start-whole-day"
                                        label="Ganztägig?"
                                        hint="Startet diese Veranstaltung zu einer bestimmten Uhrzeit?"
                                        v-model="form.startWholeDay"
                                        :disabled="form.noDate">

                                </Checkbox>

                                <TimePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="startTime"
                                        label="Anfangszeit"
                                        placeholder="Anfangszeit"
                                        v-model="form.startTime"
                                        :disabled="form.noDate || form.startWholeDay">

                                </TimePicker>

                                <DatePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="endDate"
                                        label="Enddatum"
                                        placeholder="Enddatum"
                                        :disabled="form.noDate">

                                </DatePicker>

                                <Checkbox
                                        class="col-span-6 sm:col-span-2"
                                        id="end-whole-day"
                                        label="Ganztägig?"
                                        hint="Endet diese Veranstaltung zu einer bestimmten Uhrzeit?"
                                        v-model="form.endWholeDay"
                                        :disabled="form.noDate">

                                </Checkbox>

                                <TimePicker
                                        class="col-span-6 sm:col-span-2"
                                        id="endTime"
                                        label="Endzeit"
                                        placeholder="Endzeit"
                                        v-model="form.endTime"
                                        :disabled="form.noDate || form.endWholeDay">

                                </TimePicker>

                            </div>

                            <Checkbox
                                    class="mt-4"
                                    id="no-date"
                                    label="Datum unbekannt"
                                    hint="Das Datum ist noch nicht bekannt und wird erst später veröffentlicht."
                                    v-model="form.noDate">

                            </Checkbox>


                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 rounded-b-lg">
                    <PrimaryButton>
                        Speichern
                    </PrimaryButton>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
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
            organisation: Object,
            entries: Array,
            event: {
                type: Object,
                default: {}
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
        },
        computed: {
            formData() {
                let data = new FormData()
                data.append('name', this.form.name || '')
                data.append('header_image', this.form.header_image || '')


                if (this.form.noDate) {

                }




                return data
            },
            startWholeDay() {
                return this.form.startWholeDay;
            }
        },
        watch: {
            startWholeDay(startWholeDay) {
                console.log(startWholeDay)
                if (startWholeDay) {
                    this.form.startTime = null
                }
            }
        },
        data() {
            return {
                de: de,
                form: {
                    name: this.event.name,
                    header_image: null,
                    startDate: null,
                    startTime: null,
                    startWholeDay: true,
                    endDate: null,
                    endTime: null,
                    endWholeDay: true,
                    useTempLocation: false,
                    noDate: false
                },
            }
        }
    }
</script>

<style scoped>

</style>