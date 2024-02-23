<template>
    <div>
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Datensatz "{{ dataset.name }}"
                </h3>
                <p class="max-w-2xl mt-1 text-sm leading-5 text-gray-500">
                    Informationen über den Datensatz
                </p>
            </div>
            <div class="px-4 py-5 sm:p-0">
                <dl>
                    <div
                        class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Name
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ dataset.name }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Quelle
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ dataset.source_url }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Lizenz
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{ dataset.licence ?? "unbekannt" }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Aktualisiert am
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{
                                $filters.moment(
                                    dataset.updated_at,
                                    "cccc, do LLLL yyyy, HH:mm"
                                )
                            }}
                        </dd>
                    </div>
                    <div
                        class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"
                    >
                        <dt class="text-sm font-medium leading-5 text-gray-500">
                            Erstellt am
                        </dt>
                        <dd
                            class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"
                        >
                            {{
                                $filters.moment(
                                    dataset.created_at,
                                    "cccc, do LLLL yyyy, HH:mm"
                                )
                            }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="mt-6 overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                <div
                    class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap"
                >
                    <div class="mt-4 ml-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Zugehörige Resourcen
                        </h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Füge Datenquellen in verschiedenen Formaten zur
                            weiteren Verwendung hinzu.
                        </p>
                    </div>
                    <div class="flex-shrink-0 mt-4 ml-4">
                        <PrimaryButton
                            :href="
                                route(
                                    'admin.datasets.resources.create',
                                    dataset.id
                                )
                            "
                        >
                            Erstelle Resource
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <div
                    class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8"
                >
                    <div
                        class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg"
                    >
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                    >
                                        Format
                                    </th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-2 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                    >
                                        Auto-Import
                                    </th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                                    >
                                        Zuletzt aktualisiert
                                    </th>
                                    <th
                                        class="px-6 py-3 border-b border-gray-200 bg-gray-50"
                                    ></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr
                                    v-for="resource in dataset.resources"
                                    class="border-b border-gray-200 last:border-0"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="">
                                                <div
                                                    class="text-sm font-medium leading-5 text-gray-900"
                                                >
                                                    {{ resource.name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm leading-5 text-gray-500 uppercase whitespace-nowrap"
                                    >
                                        {{ resource.format }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            v-if="resource.error === null"
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-200 rounded-full"
                                        >
                                            Valide Daten
                                        </span>
                                        <span
                                            v-else
                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full"
                                        >
                                            Invalide Daten
                                        </span>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <div
                                            class="flex items-center text-sm font-medium leading-5 text-gray-900"
                                        >
                                            <svg
                                                v-if="
                                                    resource.auto_updating_interval !==
                                                    null
                                                "
                                                class="w-6 h-6 mt-1 text-green-300"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            <svg
                                                v-else
                                                class="w-6 h-6 mt-1 text-red-400"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="text-sm font-medium leading-5 text-gray-900"
                                        >
                                            {{
                                                $filters.moment(
                                                    resource.last_updated,
                                                    "from"
                                                )
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-nowrap"
                                    >
                                        <inertia-link
                                            :href="
                                                route(
                                                    'admin.datasets.resources.edit',
                                                    [dataset.id, resource.id]
                                                )
                                            "
                                            class="text-blue-600 hover:text-blue-900 focus:outline-none focus:underline"
                                        >
                                            Bearbeiten
                                        </inertia-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";
import PrimaryButton from "@/Shared/UI/PrimaryButton.vue";

export default {
    name: "Edit",
    components: { PrimaryButton },
    layout: LayoutAdmin,
    props: {
        dataset: {
            type: Object,
        },
    },
};
</script>

<style scoped></style>
