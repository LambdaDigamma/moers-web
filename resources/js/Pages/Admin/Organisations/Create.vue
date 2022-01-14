<template>
    <div>
        <header>
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-bold leading-tight text-gray-900">
                    Organisation erstellen
                </h2>
            </div>
        </header>

        <div class="mt-4">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Allgemeine Informationen
                        </h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500">
                            Diese Informationen werden auf der Platform
                            angezeigt.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <label
                                            for="organisation_name"
                                            class="block text-sm font-medium leading-5 text-gray-700"
                                        >
                                            Name
                                        </label>
                                        <div
                                            class="flex mt-1 rounded-md shadow-sm"
                                        >
                                            <span
                                                class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50"
                                            >
                                                http://
                                            </span>
                                            <input
                                                id="organisation_name"
                                                class="flex-1 block w-full transition duration-150 ease-in-out rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
                                                placeholder="www.example.com"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label
                                        for="about"
                                        class="block text-sm font-medium leading-5 text-gray-700"
                                    >
                                        About
                                    </label>
                                    <div class="rounded-md shadow-sm">
                                        <textarea
                                            id="about"
                                            rows="3"
                                            class="block w-full mt-1 transition duration-150 ease-in-out form-textarea sm:text-sm sm:leading-5"
                                            placeholder="you@example.com"
                                        ></textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for your profile. URLs
                                        are hyperlinked.
                                    </p>
                                </div>

                                <div class="mt-6">
                                    <label
                                        for="photo"
                                        class="block text-sm font-medium leading-5 text-gray-700"
                                    >
                                        Photo
                                    </label>
                                    <div class="flex items-center mt-2">
                                        <span
                                            class="inline-block w-12 h-12 overflow-hidden bg-gray-100 rounded-full"
                                        >
                                            <svg
                                                class="w-full h-full text-gray-300"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
                                                />
                                            </svg>
                                        </span>
                                        <span class="ml-5 rounded-md shadow-sm">
                                            <button
                                                type="button"
                                                class="px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800"
                                            >
                                                Change
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label
                                        for="cover_photo"
                                        class="block text-sm font-medium leading-5 text-gray-700"
                                    >
                                        Cover photo
                                    </label>
                                    <div
                                        class="flex justify-center px-6 pt-5 pb-6 mt-2 border-2 border-gray-300 border-dashed rounded-md"
                                    >
                                        <div class="text-center">
                                            <svg
                                                class="w-12 h-12 mx-auto text-gray-400"
                                                stroke="currentColor"
                                                fill="none"
                                                viewBox="0 0 48 48"
                                            >
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />
                                            </svg>
                                            <p
                                                class="mt-1 text-sm text-gray-600"
                                            >
                                                <button
                                                    class="font-medium text-indigo-600 transition duration-150 ease-in-out hover:text-indigo-500 focus:outline-none focus:underline"
                                                >
                                                    Upload a file
                                                </button>
                                                or drag and drop
                                            </p>
                                            <p
                                                class="mt-1 text-xs text-gray-500"
                                            >
                                                PNG, JPG, GIF up to 10MB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-4 py-3 text-right bg-gray-50 sm:px-6"
                            >
                                <span class="inline-flex rounded-md shadow-sm">
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700"
                                    >
                                        Save
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
import LayoutAdmin from "@/Shared/LayoutAdmin.vue";

export default {
    name: "Create",
    layout: LayoutAdmin,
};
</script>

<style scoped></style>
