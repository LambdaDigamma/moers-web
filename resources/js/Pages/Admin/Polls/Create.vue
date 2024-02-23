<template>
    <div>
        <Header
            :href="route('admin.polls.index')"
            previousTitle="Abstimmungen"
            class="mb-8"
        >
            Erstellen
        </Header>
        <div class="max-w-4xl bg-white rounded shadow dark:bg-gray-700">
            <form @submit.prevent="submit">
                <div class="flex flex-wrap p-6">
                    <TextInput
                        v-model="form.question"
                        label="Frage"
                        class="w-full"
                        :errors="$page.errors.question"
                    />
                    <TextareaInput
                        v-model="form.description"
                        label="Beschreibung"
                        class="w-full mt-3"
                        :errors="$page.errors.description"
                    />
                    <SelectInput
                        v-model="form.group_id"
                        class="w-full mt-3"
                        label="Gruppe"
                        :errors="$page.errors.group_id"
                    >
                        <option
                            v-for="group in this.groups"
                            :value="group.id"
                            :key="group.id"
                        >
                            {{ group.organisation.name }} • {{ group.name }}
                        </option>
                    </SelectInput>
                    <NumberInput
                        v-model="form.max_check"
                        label="Anzahl der auswählbaren Antworten"
                        class="w-full mt-3"
                        :min="1"
                        :errors="$page.errors.max_check"
                    />
                    <div class="w-full mt-3">
                        <span class="font-semibold dark:text-white"
                            >Antwortmöglichkeiten:</span
                        >

                        <div
                            v-for="(option, index) in form.options"
                            :key="index"
                            class="flex items-stretch w-full p-2 mt-2 rounded dark:bg-gray-800"
                        >
                            <TextInput
                                placeholder="Titel der Antwortmöglichkeit eingeben."
                                v-model="form.options[index]"
                                class="flex-grow-1"
                            />

                            <button
                                v-if="canDelete"
                                class="flex-grow-0 px-2 py-1 ml-2 text-sm font-semibold rounded dark:bg-red-600 dark:text-white"
                                @click="deletePollOption(index)"
                            >
                                Löschen
                            </button>
                        </div>

                        <span
                            v-if="$page.errors.options"
                            class="font-medium dark:text-red-600"
                        >
                            {{ $page.errors.options[0] }}
                        </span>

                        <button
                            @click.prevent="addPollOption"
                            class="px-3 py-2 mt-3 ml-1 text-base font-semibold rounded flex-grow-1 flex-md-grow-0 md:ml-0 dark:bg-yellow-500 dark:text-gray-800"
                        >
                            Weitere Antwortmöglichkeit hinzufügen
                        </button>

                        <div class="mt-3">
                            <button
                                @click.prevent="addStudentOptions"
                                class="px-3 py-2 mt-3 ml-1 text-base font-semibold rounded md:ml-0 dark:bg-yellow-500 dark:text-gray-800"
                            >
                                Schüler einfügen
                            </button>

                            <button
                                @click.prevent="addTeacherOptions"
                                class="px-3 py-2 mt-3 ml-1 text-base font-semibold rounded md:ml-0 dark:bg-yellow-500 dark:text-gray-800"
                            >
                                Lehrer einfügen
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="flex items-center px-6 py-3 bg-gray-700 border-t rounded-b-lg border-grey-500 dark:border-gray-600"
                >
                    <LoadingButton
                        class="px-3 py-2 text-base font-semibold rounded-lg dark:bg-green-600 dark:text-white"
                        type="submit"
                        :disabled="!isSubmitEnabled || $page.errors === null"
                        :loading="sending"
                    >
                        Abstimmung erstellen
                    </LoadingButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import LoadingButton from "@/Shared/UI/LoadingButton.vue";
import SelectInput from "@/Shared/UI/SelectInput.vue";
import Header from "@/Shared/Admin/Header.vue";
import TextInput from "@/Shared/UI/TextInput.vue";
import NumberInput from "@/Shared/UI/NumberInput.vue";

export default {
    name: "Create",
    components: {
        Header,
        LoadingButton,
        SelectInput,
        TextInput,
        NumberInput,
    },
    props: {
        groups: Array,
    },
    layout: LayoutAdmin,
    remember: "form",
    data() {
        return {
            sending: false,
            form: {
                question: null,
                description: null,
                group_id: null,
                max_check: 1,
                options: ["", ""],
            },
            students: [
                "Erik Pösken",
                "Joud Kabbani",
                "Vivienne Essig",
                "Jele Thyen",
                "Tatiana Maniecki",
                "Marian Hauck",
                "Fabian Jendral",
                "Janik Berger",
                "Melina Stecher",
                "Nadia Nickel",
                "Cindy Agbor",
                "Philipp Lassig",
                "Konstantin Postel",
                "Laureen Ramburger",
                "Peter Völker",
                "Phillip Reis",
                "Noel Morawiec",
                "Suzan Abu Zanat",
                "Farina Adler",
                "Anastasia Balles",
                "Til Scholz",
                "Jasper Sitte",
                "Samet Terporten",
                "Julia Weber",
                "Lena Ziegenfuß",
                "Mert Aykan",
                "Emily Becker",
                "Steen Bütow",
                "Henrik Dawel",
                "Philipp Domagala",
                "Carlotta Genkel",
                "Özge Günes",
                "Mona Hamid",
                "Veit Bils",
                "Angelina Bramtchiyska",
                "Gregor Branscheid",
                "Natascha Brüggemann",
                "Celina Carboni",
                "Philipp Erbslöh",
                "Tim Erlacher",
                "Zoe Graumann",
                "Mert Halavurt",
                "Aaron Jordans",
                "Lilli Koch",
                "Danel Kolu",
                "Hannah Kambartel",
                "Baris Kaya",
                "Niklas Klag",
                "Ayleen Kohlmann",
                "Felix Krahl",
                "Amelie Löhndorf",
                "Simon Prill",
                "Yannik Prill",
                "Hannes Rentel",
                "Henning Rütten",
                "Minel Savas",
                "Liv Schwarzer",
                "Nikolai Sieglitz",
                "Ole Stifft",
                "Paula Weyen",
                "Ines Marten",
                "Franziska Milbrandt",
                "Miriam Victoria Richter",
                "Finn Spitzer",
                "Jarne Weiß",
                "Michel Söte",
                "Niklas Wuttke",
                "Leon Urbanowski",
                "Maite Kössl",
                "Sophia Lange",
                "Berit Warkall",
                "Frederik Reiff",
                "Jil Willemsen",
                "Marie Harraß",
                "Lucie Heße",
                "Mats Hüsing",
                "Simon Jäschke",
                "Jonathan Kaiser",
                "David Leonhards",
                "Tim Pesch",
                "Hannah Reichert",
                "Isis Rittinghaus",
                "Gideon Schmitz",
                "Paula Skorwider",
                "Hannah Ventzke",
                "Kendra Weyers",
                "Judith Wiegelmann",
                "Jennifer Buckesfeld",
                "Melek Chabchoul",
                "Alexander Eurich",
                "Anabel Falkenburg",
                "Christian Hellwig",
                "Tobias Indetzki",
                "Ubeyd Kilic",
                "Paul Klose",
                "Simon Krenz",
                "Elias Merten",
                "Johanna Münker",
                "Lea Noreiks",
                "Elisa Pickardt",
                "Tolga Mede",
                "Lea Mielchen",
                "René Ohm",
                "Nick Oppen",
                "Karim Sawalha",
                "Mathis Schoonhoven",
                "Lou Schulz",
                "Cenk Atalay",
                "Emilia Bozkurt",
                "Antonia Foit",
                "Tobias Großmann",
                "Timon Helmich",
                "Marie Winkelmann",
                "Nele Wolf",
                "Alexander Bürgel",
                "Niklas Engels",
                "Lennart Fischer",
                "Nathalie Fischer",
                "Matthias Giesen",
                "Paul Hagelgans",
                "David Hamm",
                "Daniel Heinbichner",
                "Lenia Hüsgen",
                "Johanna Jaschko",
                "Jenna Kellerhoff",
                "Sabrina Kragt",
                "Mats Lammert",
                "Jan Mattis Lipka",
            ],
            teachers: [
                "Katharina Adams",
                "Anna Benjamins",
                "Franziska Bietenbeck",
                "Alina Binder",
                "Lucas Bollhorst",
                "Marcel Buchmüller",
                "Lisa Busch",
                "Annika Chung",
                "Aylin Coskun",
                "Aileen Dawid",
                "Anna-Lena Demmer",
                "Matthias Dierks",
                "Alexandra Dietz",
                "Dr. Kai Dinkelmann",
                "Verena Ehlert",
                "Christina Evers",
                "Marita Fiedler",
                "Lina Fießer",
                "Nikolai Fischer",
                "Heinz-Joachim Franken",
                "Thomas Frings",
                "Charlene Gehlen",
                "Carolin Genneper",
                "Katharina Grade",
                "Dr. Babett Götz",
                "Julia Haustein",
                "Miriam Hecht",
                "Lars Heining",
                "Daniel Heisig-Pitzen",
                "Sandra Hennemann",
                "Tim Herrmann",
                "Jens Heße",
                "Lena Kahlert",
                "Johanna Kewitz",
                "Ernst Kisters",
                "Thorsten Klag",
                "Andrea Klein",
                "Dr. Evelyn Kleine",
                "Rolf Klümper",
                "Nils Koopmann",
                "Thomas Kozianka",
                "Ulrike Krakow",
                "Jörg Krauskopf",
                "Peter Kuster",
                "Udo Küppers",
                "Maren König",
                "Andreas Lind",
                "Dinah Lindemann",
                "Peter Löcher",
                "Stephanie Marciniak",
                "Dina Mecklenburg",
                "Sebastian Mecklenburg",
                "Tatjana Meier",
                "Jörg Meschendörfer",
                "Regine Meyering",
                "Miriam Milde-Sistig",
                "Denise Monreal",
                "Anna Müller",
                "Lisa Neumann",
                "Sven Neumann",
                "Michael Neunzig",
                "Alexander Niemeier",
                "Philipp Niersmans",
                "Fanny Ollivier",
                "Tobias Packenius",
                "Marco Petering",
                "Isabelle Petrovic",
                "Cordelia Rahrbach-Sander",
                "Eva-Maria Redeker",
                "Barbara Reiss",
                "Dr. André Remy",
                "Bastian Rennert",
                "Nicole Romberg",
                "Simone Ruppik",
                "Mareike Samp",
                "Martin Schattenberg",
                "Daniel Schirra",
                "Yihu Schlossarek",
                "Anja Schlüter",
                "Ursula Schrader",
                "Sandra Schröer",
                "Patrick Schubert",
                "Nicole Schüttauf",
                "Dr. Wolfgang Schäfer",
                "Nicole Skorwider",
                "Anika Sokolowski",
                "Annette Sommer",
                "Hans van Stephoudt",
                "Simon Stockamp",
                "Maja Stolte",
                "Anne Stührenberg",
                "Stephanie Tenbusch",
                "Sven Tenhaven",
                "Karsten Verhoeven",
                "Maria Vollendorf-Löcher",
                "Sarah Voß",
                "Ulrich Voß",
                "Peter Wans",
                "Christopher Lee Watkins",
                "Tom Weber",
                "Burcu Wiemers",
                "Elisabeth Willems",
            ],
        };
    },
    computed: {
        canDelete() {
            return this.form.options.length > 2;
        },
        isSubmitEnabled() {
            if (this.form.question === null || this.form.question === "") {
                return false;
            }
            if (
                this.form.description === null ||
                this.form.description === ""
            ) {
                return false;
            }
            if (this.form.group_id === null) {
                return false;
            }
            if (
                this.form.max_check < 1 ||
                this.form.max_check >= this.form.options.length
            ) {
                return false;
            }
            for (let i = 0; i < this.form.options.length; i++) {
                if (this.form.options[i] === "") {
                    return false;
                }
            }
            return true;
        },
    },
    methods: {
        submit() {
            this.sending = true;
            this.$inertia.post(this.route("admin.polls.store"), this.form, {
                onSuccess: () => {
                    this.sending = false;
                },
            });
        },
        addPollOption() {
            this.form.options.push("");
        },
        deletePollOption(index) {
            this.form.options.splice(index, 1);
        },
        addTeacherOptions() {
            this.form.options = this.teachers;
        },
        addStudentOptions() {
            this.form.options = this.students;
        },
    },
};
</script>

<style scoped></style>
