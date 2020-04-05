<template>


    <div class="pb-32">

        <div class="flex flex-col justify-between md:flex-row">
            <div>
                <h3 class="text-3xl font-bold text-gray-900">Neue Veranstaltung erstellen</h3>
                <p class="text-gray-600">Erstelle eine neue Veranstaltung für diese Organisation.</p>
            </div>
<!--            <LanguagePicker class="mt-4 md:mt-0" />-->
        </div>

        <EventForm
                :show-page-editor="false"
                :organisation="organisation"
                :entries="entries"
                @changed="changed"
                @submit="submit">

        </EventForm>

    </div>

</template>

<script>
    import CardContainer from "../../../Shared/UI/CardContainer";
    import LayoutAdmin from "../../../Shared/LayoutAdmin";
    import LoadingButton from "../../../Shared/LoadingButton";
    import TextInput from "../../../Shared/TextInput";
    import TextareaInput from "../../../Shared/TextareaInput";
    import PageEditor from "../../../Shared/PageEditor";
    import LanguagePicker from "../../../Shared/UI/LanguagePicker";
    import ImagePreviewInput from "../../../Shared/UI/ImagePreviewInput";
    import PictureInput from "../../../Shared/UI/PictureInput";
    import SelectInput from "../../../Shared/UI/SelectInput";
    import PrimaryButton from "../../../Shared/UI/PrimaryButton";
    import vuejsDatepicker from 'vuejs-datepicker';
    import {de} from 'vuejs-datepicker/dist/locale'
    import DatePicker from "../../../Shared/UI/DatePicker";
    import TimePicker from "../../../Shared/UI/TimePicker";
    import Checkbox from "../../../Shared/UI/Checkbox";
    import EventForm from "../../../Pages/Admin/Organisations/EventForm";

    export default {
        name: "CreateEvent",
        components: {
            EventForm,
            Checkbox,
            TimePicker,
            DatePicker,
            PrimaryButton,
            SelectInput,
            vuejsDatepicker,
            ImagePreviewInput, PictureInput,
            LanguagePicker, PageEditor, TextareaInput, TextInput, LoadingButton, CardContainer},
        layout: LayoutAdmin,
        props: {
            organisation: Object,
            entries: Array
        },
        remember: 'form',
        data() {
            return {
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
                this.$inertia
                    .post(this.route('admin.organisations.events.store', this.organisation.id), formData)
                    .then(() => this.sending = false)
            },
        }
    }
</script>

<style scoped>

</style>