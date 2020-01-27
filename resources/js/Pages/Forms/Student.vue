<template>

    <div class="lg:w-1/2">
        <div class="p-3 rounded-lg shadow-lg dark:bg-gray-700 mb-6">
            <h1 class="font-bold text-xl md:text-3xl dark:text-white">Steckbrief Abizeitung</h1>
            <form @submit.prevent="submit">
                <TextInput
                    v-model="this.form.name"
                    label="Name"
                    class="w-full"
                    :errors="$page.errors.name">

                </TextInput>
                <TextInput
                        v-model="this.form.nickname"
                        label="a.k.a."
                        class="mt-2 w-full"
                        :errors="$page.errors.nickname">

                </TextInput>
                <TextInput
                    v-model="this.form.birthday"
                    label="Geburtsdatum (dd.MM.yyyy)"
                    class="mt-2 w-full"
                    :errors="$page.errors.birthday">

                </TextInput>
                <TextInput
                    v-model="this.form.slogan"
                    label="Meine Redewendung (100 Zeichen)"
                    class="mt-2 w-full"
                    :errors="$page.errors.slogan">

                </TextInput>
                <TextInput
                    v-model="this.form.motto"
                    label="Lebensmotto (100 Zeichen)"
                    class="mt-2 w-full"
                    :errors="$page.errors.motto">

                </TextInput>
                <TextInput
                        v-model="this.form.strengths"
                        label="Stärken (100 Zeichen)"
                        class="mt-2 w-full"
                        :errors="$page.errors.strengths">

                </TextInput>
                <TextInput
                        v-model="this.form.weaknesses"
                        label="Schwächen (100 Zeichen)"
                        class="mt-2 w-full"
                        :errors="$page.errors.weaknesses">

                </TextInput>
                <TextInput
                    v-model="this.form.lkA"
                    label="LK A (Fach + Nachname Lehrer)"
                    class="mt-2 w-full"
                    :errors="$page.errors.lkA">

                </TextInput>
                <TextInput
                    v-model="this.form.lkB"
                    class="mt-2 w-full"
                    label="LK B (Fach + Nachname Lehrer)"
                    :errors="$page.errors.lkB">

                </TextInput>
                <TextareaInput
                    v-model="this.form.highlight"
                    class="mt-2 w-full"
                    label="Mein Schulhighlight (400 Zeichen)"
                    :errors="$page.errors.highlight">

                </TextareaInput>
                <TextInput
                        v-model="this.form.soundtrack"
                        class="mt-2 w-full"
                        label="Soundtrack des Lebens"
                        :errors="$page.errors.soundtrack">

                </TextInput>
                <TextInput
                        v-model="this.form.miss_least"
                        class="mt-2 w-full"
                        label="Was werde ich am wenigsten vermissen"
                        :errors="$page.errors.miss_least">

                </TextInput>
                <TextInput
                        v-model="this.form.miss_most"
                        class="mt-2 w-full"
                        label="Was werde ich am meisten vermissen"
                        :errors="$page.errors.miss_most">

                </TextInput>
                <FileInput
                        v-model="form.photo_old"
                        label="Bild (Kindheit)"
                        :errors="$page.errors.photo_old"
                        class="mt-2 w-full"
                        type="file"
                        accept="image/*">

                </FileInput>
                <FileInput
                        v-model="form.photo_new"
                        label="Bild (Jetzt)"
                        :errors="$page.errors.photo_new"
                        class="mt-2 w-full"
                        type="file"
                        accept="image/*">

                </FileInput>
                <div class="py-3 bg-gray-700 flex items-center rounded-b-lg dark:border-gray-600">
                    <LoadingButton
                            class="px-3 py-2 rounded-lg font-semibold text-base dark:bg-green-600 dark:text-white"
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

                this.$inertia.post(this.route('forms.student.save'), data)
                    .then(() => this.sending = false)
            }
        }
    }
</script>

<style scoped>

</style>