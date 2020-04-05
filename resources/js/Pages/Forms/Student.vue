<template>

    <div class="lg:w-1/2">
        <div class="p-3 mb-6 rounded-lg shadow-lg dark:bg-gray-700">
            <h1 class="text-xl font-bold md:text-3xl dark:text-white">Steckbrief Abizeitung</h1>
            <form @submit.prevent="submit">
                <TextInput
                    v-model="form.name"
                    label="Name"
                    class="w-full"
                    :errors="$page.errors.name">

                </TextInput>
                <TextInput
                        v-model="form.nickname"
                        label="a.k.a."
                        class="w-full mt-2"
                        :errors="$page.errors.nickname">

                </TextInput>
                <TextInput
                    v-model="form.birthday"
                    label="Geburtsdatum (dd.MM.yyyy)"
                    class="w-full mt-2"
                    :errors="$page.errors.birthday">

                </TextInput>
                <TextInput
                    v-model="form.slogan"
                    label="Meine Redewendung (100 Zeichen)"
                    class="w-full mt-2"
                    :errors="$page.errors.slogan">

                </TextInput>
                <TextInput
                    v-model="form.motto"
                    label="Lebensmotto (100 Zeichen)"
                    class="w-full mt-2"
                    :errors="$page.errors.motto">

                </TextInput>
                <TextInput
                        v-model="form.strengths"
                        label="Stärken (100 Zeichen)"
                        class="w-full mt-2"
                        :errors="$page.errors.strengths">

                </TextInput>
                <TextInput
                        v-model="form.weaknesses"
                        label="Schwächen (100 Zeichen)"
                        class="w-full mt-2"
                        :errors="$page.errors.weaknesses">

                </TextInput>
                <TextInput
                    v-model="form.lkA"
                    label="LK A (Fach + Nachname Lehrer)"
                    class="w-full mt-2"
                    :errors="$page.errors.lkA">

                </TextInput>
                <TextInput
                    v-model="form.lkB"
                    class="w-full mt-2"
                    label="LK B (Fach + Nachname Lehrer)"
                    :errors="$page.errors.lkB">

                </TextInput>
                <TextareaInput
                    v-model="form.highlight"
                    class="w-full mt-2"
                    label="Mein Schulhighlight (400 Zeichen)"
                    :errors="$page.errors.highlight">

                </TextareaInput>
                <TextInput
                        v-model="form.soundtrack"
                        class="w-full mt-2"
                        label="Soundtrack des Lebens"
                        :errors="$page.errors.soundtrack">

                </TextInput>
                <TextInput
                        v-model="form.miss_least"
                        class="w-full mt-2"
                        label="Was werde ich am wenigsten vermissen"
                        :errors="$page.errors.miss_least">

                </TextInput>
                <TextInput
                        v-model="form.miss_most"
                        class="w-full mt-2"
                        label="Was werde ich am meisten vermissen"
                        :errors="$page.errors.miss_most">

                </TextInput>
                <FileInput
                        v-model="form.photo_old"
                        label="Bild (Kindheit)"
                        :errors="$page.errors.photo_old"
                        class="w-full mt-2"
                        type="file"
                        accept="image/*">

                </FileInput>
                <FileInput
                        v-model="form.photo_new"
                        label="Bild (Jetzt)"
                        :errors="$page.errors.photo_new"
                        class="w-full mt-2"
                        type="file"
                        accept="image/*">

                </FileInput>
                <div class="flex items-center py-3 bg-gray-700 rounded-b-lg dark:border-gray-600">
                    <LoadingButton
                            class="px-3 py-2 text-base font-semibold rounded-lg dark:bg-green-600 dark:text-white"
                            type="submit"
                            :loading="sending">
                        Abschicken
                    </LoadingButton>
                </div>
            </form>
        </div>
    </div>


</template>

<script>
    import LayoutGeneral from "../../Shared/Layouts/LayoutGeneral";
    import TextInput from "../../Shared/TextInput";
    import TextareaInput from "../../Shared/TextareaInput";
    import FileInput from "../../Shared/FileInput";

    export default {
        name: "Student",
        components: {FileInput, TextareaInput, TextInput},
        layout: LayoutGeneral,
        data() {
            return {
                sending: false,
                form: {
                    name: null,
                    nickname: null,
                    birthday: null,
                    slogan: null,
                    motto: null,
                    strengths: null,
                    weaknesses: null,
                    lkA: null,
                    lkB: null,
                    highlight: null,
                    soundtrack: null,
                    miss_least: null,
                    miss_most: null,
                    photo_old: null,
                    photo_new: null,
                }
            }
        },
        methods: {
            submit() {
                this.sending = true

                var data = new FormData()
                data.append('name', this.form.name || '')
                data.append('nickname', this.form.nickname || '')
                data.append('birthday', this.form.birthday || '')
                data.append('slogan', this.form.slogan || '')
                data.append('motto', this.form.motto || '')
                data.append('strengths', this.form.strengths || '')
                data.append('weaknesses', this.form.weaknesses || '')
                data.append('lkA', this.form.lkA || '')
                data.append('lkB', this.form.lkB || '')
                data.append('highlight', this.form.highlight || '')
                data.append('soundtrack', this.form.soundtrack || '')
                data.append('miss_least', this.form.miss_least || '')
                data.append('miss_most', this.form.miss_most || '')
                data.append('photo_old', this.form.photo_old || '')
                data.append('photo_new', this.form.photo_new || '')

                this.$inertia.post(this.route('forms.student.save').url(), data)
                    .then(() => this.sending = false)
            }
        }
    }
</script>

<style scoped>

</style>