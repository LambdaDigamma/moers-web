<template>
    <div>
        <h1 class="text-4xl font-bold">Seitenlayout</h1>

        <div class="grid grid-cols-2 gap-10 mt-6">
            <div v-for="user in users" :key="user.id">
                <inertia-link
                    class="block"
                    v-if="user.student_information"
                    :href="
                        route(
                            'admin.forms.students.show',
                            user.student_information.id
                        )
                    "
                >
                    <Panel class="transition duration-150 hover:bg-gray-50">
                        <h2 class="text-xl font-semibold">
                            {{ user.first_name }} {{ user.last_name }}
                        </h2>
                        <span
                            class="mt-2 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-green-100 text-green-800"
                        >
                            Steckbrief abgegeben
                        </span>
                    </Panel>
                </inertia-link>
                <Panel v-else>
                    <h2 class="text-xl font-semibold">
                        {{ user.first_name }} {{ user.last_name }}
                    </h2>
                    <span
                        class="mt-2 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-red-100 text-red-800"
                    >
                        Kein Steckbrief abgegeben
                    </span>
                </Panel>
            </div>
        </div>

        <div class="mt-6">
            <h1 class="text-4xl font-bold">Fehlende Steckbriefe:</h1>
            <ul class="mt-6">
                <li v-for="user in missing_information" :key="user.id">
                    {{ user.first_name }} {{ user.last_name }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import Panel from "@/Shared/UI/Panels/Panel.vue";

export default {
    name: "Students",
    components: { Panel },
    layout: LayoutAdmin,
    props: {
        users: Array,
        missing_information: Array,
    },
};
</script>

<style scoped></style>
