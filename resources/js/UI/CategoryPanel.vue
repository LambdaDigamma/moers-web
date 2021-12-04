<template>
    <div
        class="overflow-hidden bg-gray-200 divide-y divide-gray-200 rounded-lg shadow-lg sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px"
    >
        <CategoryPanelItem></CategoryPanelItem>

        <div
            class="relative p-6 bg-white sm:rounded-tr-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500"
        >
            <div>
                <span
                    class="inline-flex p-3 text-purple-700 rounded-lg bg-purple-50 ring-4 ring-white"
                >
                    <!-- Heroicon name: outline/badge-check -->
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </span>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-medium">
                    <a class="focus:outline-none" href="#">
                        <!-- Extend touch target to entire panel -->
                        <span
                            aria-hidden="true"
                            class="absolute inset-0"
                        ></span>
                        Orte
                    </a>
                </h3>
            </div>
            <span
                aria-hidden="true"
                class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
            >
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                    />
                </svg>
            </span>
        </div>

        <div
            class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500"
        >
            <div>
                <span
                    class="inline-flex p-3 rounded-lg bg-light-blue-50 text-light-blue-700 ring-4 ring-white"
                >
                    <!-- Heroicon name: outline/users -->
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </span>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-medium">
                    <a class="focus:outline-none" href="#">
                        <!-- Extend touch target to entire panel -->
                        <span
                            aria-hidden="true"
                            class="absolute inset-0"
                        ></span>
                        Abfallkalender
                    </a>
                </h3>
            </div>
            <span
                aria-hidden="true"
                class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
            >
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                    />
                </svg>
            </span>
        </div>

        <div
            class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500"
        >
            <div>
                <span
                    class="inline-flex p-3 text-yellow-700 rounded-lg bg-yellow-50 ring-4 ring-white"
                >
                    <!-- Heroicon name: outline/cash -->
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </span>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-medium">
                    <a class="focus:outline-none" href="#">
                        <!-- Extend touch target to entire panel -->
                        <span
                            aria-hidden="true"
                            class="absolute inset-0"
                        ></span>
                        Spritpreise
                    </a>
                </h3>
            </div>
            <span
                aria-hidden="true"
                class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
            >
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                    />
                </svg>
            </span>
        </div>

        <div
            class="relative p-6 bg-white sm:rounded-bl-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500"
        >
            <div>
                <span
                    class="inline-flex p-3 rounded-lg bg-rose-50 text-rose-700 ring-4 ring-white"
                >
                    <!-- Heroicon name: outline/receipt-refund -->
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </span>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-medium">
                    <a class="focus:outline-none" href="#">
                        <!-- Extend touch target to entire panel -->
                        <span
                            aria-hidden="true"
                            class="absolute inset-0"
                        ></span>
                        Submit an expense
                    </a>
                </h3>
            </div>
            <span
                aria-hidden="true"
                class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
            >
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                    />
                </svg>
            </span>
        </div>

        <div
            class="relative p-6 bg-white rounded-bl-lg rounded-br-lg sm:rounded-bl-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500"
        >
            <div>
                <span
                    class="inline-flex p-3 text-indigo-700 rounded-lg bg-indigo-50 ring-4 ring-white"
                >
                    <!-- Heroicon name: outline/academic-cap -->
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M12 14l9-5-9-5-9 5 9 5z" fill="#fff" />
                        <path
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"
                            fill="#fff"
                        />
                        <path
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                        />
                    </svg>
                </span>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-medium">
                    <a class="focus:outline-none" href="#">
                        <!-- Extend touch target to entire panel -->
                        <span
                            aria-hidden="true"
                            class="absolute inset-0"
                        ></span>
                        Training
                    </a>
                </h3>
            </div>
            <span
                aria-hidden="true"
                class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
            >
                <svg
                    class="w-6 h-6"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                    />
                </svg>
            </span>
        </div>
    </div>
</template>

<script>
import CategoryPanelItem from "@/UI/CategoryPanelItem.vue";

export default {
    name: "CategoryPanel",
    components: { CategoryPanelItem },
};
</script>
