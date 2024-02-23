<template>
    <div class="relative">
        <div class="px-4 mx-auto max-w-7xl sm:px-6">
            <div
                class="flex items-center justify-between py-6 border-b-2 border-gray-400 border-opacity-20 md:justify-start md:space-x-10"
            >
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a class="text-xl font-bold text-white" href="#">
                        <!--																								<span class="sr-only">Workflow</span>-->
                        <!--																								<img class="w-auto h-8 sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="">-->
                    </a>
                </div>
                <div class="-my-2 -mr-2 md:hidden">
                    <button
                        :aria-expanded="showMobileNavigation"
                        class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        type="button"
                        @click="showMobileNavigation = true"
                    >
                        <span class="sr-only">Open menu</span>
                        <!-- Heroicon name: outline/menu -->
                        <svg
                            aria-hidden="true"
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M4 6h16M4 12h16M4 18h16"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />
                        </svg>
                    </button>
                </div>
                <nav class="hidden space-x-10 md:flex">
                    <div class="relative">
                        <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                        <button
                            :aria-expanded="showSolutionsFlyout"
                            class="inline-flex items-center text-base font-medium text-gray-500 bg-white rounded-md group hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            type="button"
                            @click="showSolutionsFlyout = !showSolutionsFlyout"
                        >
                            <span>Solutions</span>
                            <!--
                                    Heroicon name: solid/chevron-down

                                    Item active: "text-gray-600", Item inactive: "text-gray-400"
                            -->
                            <svg
                                aria-hidden="true"
                                class="w-5 h-5 ml-2 text-gray-400 group-hover:text-gray-500"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </button>

                        <!--
                                'Solutions' flyout menu, show/hide based on flyout menu state.
                        -->
                        <transition
                            enter-active-class="transition duration-200 ease-out"
                            enter-class="translate-y-1 opacity-0"
                            enter-to-class="translate-y-0 opacity-100"
                            leave-active-class="transition duration-150 ease-in"
                            leave-class="translate-y-0 opacity-100"
                            leave-to-class="translate-y-1 opacity-0"
                        >
                            <div
                                v-show="showSolutionsFlyout"
                                class="absolute z-10 w-screen max-w-md px-2 mt-3 -ml-4 transform sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2"
                            >
                                <div
                                    class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                >
                                    <div
                                        class="relative grid gap-6 px-5 py-6 bg-white sm:gap-8 sm:p-8"
                                    >
                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/chart-bar -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Analytics
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Get a better understanding
                                                    of where your traffic is
                                                    coming from.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/cursor-click -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Engagement
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Speak directly to your
                                                    customers in a more
                                                    meaningful way.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/shield-check -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Security
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Your customers&#039; data
                                                    will be safe and secure.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/view-grid -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Integrations
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Connect with third-party
                                                    tools that you&#039;re
                                                    already using.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/refresh -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Automations
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Build strategic funnels that
                                                    will drive your customers to
                                                    convert
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    <div
                                        class="px-5 py-5 space-y-6 bg-gray-50 sm:flex sm:space-y-0 sm:space-x-10 sm:px-8"
                                    >
                                        <div class="flow-root">
                                            <a
                                                class="flex items-center p-3 -m-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100"
                                                href="#"
                                            >
                                                <!-- Heroicon name: outline/play -->
                                                <svg
                                                    aria-hidden="true"
                                                    class="flex-shrink-0 w-6 h-6 text-gray-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                    />
                                                    <path
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                    />
                                                </svg>
                                                <span class="ml-3"
                                                    >Watch Demo</span
                                                >
                                            </a>
                                        </div>

                                        <div class="flow-root">
                                            <a
                                                class="flex items-center p-3 -m-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100"
                                                href="#"
                                            >
                                                <!-- Heroicon name: outline/phone -->
                                                <svg
                                                    aria-hidden="true"
                                                    class="flex-shrink-0 w-6 h-6 text-gray-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                    />
                                                </svg>
                                                <span class="ml-3"
                                                    >Contact Sales</span
                                                >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <a
                        class="text-base font-medium text-gray-500 hover:text-gray-900"
                        href="#"
                    >
                        Pricing
                    </a>
                    <a
                        class="text-base font-medium text-gray-500 hover:text-gray-900"
                        href="#"
                    >
                        Docs
                    </a>

                    <div class="relative">
                        <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                        <button
                            aria-expanded="false"
                            class="inline-flex items-center text-base font-medium text-gray-500 bg-white rounded-md group hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            type="button"
                        >
                            <span>More</span>
                            <!--
                                    Heroicon name: solid/chevron-down

                                    Item active: "text-gray-600", Item inactive: "text-gray-400"
                            -->
                            <svg
                                aria-hidden="true"
                                class="w-5 h-5 ml-2 text-gray-400 group-hover:text-gray-500"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </button>

                        <!--
                                'More' flyout menu, show/hide based on flyout menu state.
                        -->
                        <transition
                            enter-active-class="transition duration-200 ease-out"
                            enter-class="translate-y-1 opacity-0"
                            enter-to-class="translate-y-0 opacity-100"
                            leave-active-class="transition duration-150 ease-in"
                            leave-class="translate-y-0 opacity-100"
                            leave-to-class="translate-y-1 opacity-0"
                        >
                            <div
                                v-show="showMoreFlyout"
                                class="absolute z-10 w-screen max-w-md px-2 mt-3 transform -translate-x-1/2 left-1/2 sm:px-0"
                            >
                                <div
                                    class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
                                >
                                    <div
                                        class="relative grid gap-6 px-5 py-6 bg-white sm:gap-8 sm:p-8"
                                    >
                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/support -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Help Center
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Get all of your questions
                                                    answered in our forums or
                                                    contact support.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/bookmark-alt -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Guides
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Learn how to maximize our
                                                    platform to get the most out
                                                    of it.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/calendar -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Events
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    See what meet-ups and other
                                                    events we might be planning
                                                    near you.
                                                </p>
                                            </div>
                                        </a>

                                        <a
                                            class="flex items-start p-3 -m-3 rounded-lg hover:bg-gray-50"
                                            href="#"
                                        >
                                            <!-- Heroicon name: outline/shield-check -->
                                            <svg
                                                aria-hidden="true"
                                                class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                />
                                            </svg>
                                            <div class="ml-4">
                                                <p
                                                    class="text-base font-medium text-gray-900"
                                                >
                                                    Security
                                                </p>
                                                <p
                                                    class="mt-1 text-sm text-gray-500"
                                                >
                                                    Understand how we take your
                                                    privacy seriously.
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    <div
                                        class="px-5 py-5 bg-gray-50 sm:px-8 sm:py-8"
                                    >
                                        <div>
                                            <h3
                                                class="text-sm font-medium tracking-wide text-gray-500 uppercase"
                                            >
                                                Recent Posts
                                            </h3>
                                            <ul class="mt-4 space-y-4">
                                                <li class="text-base truncate">
                                                    <a
                                                        class="font-medium text-gray-900 hover:text-gray-700"
                                                        href="#"
                                                    >
                                                        Boost your conversion
                                                        rate
                                                    </a>
                                                </li>

                                                <li class="text-base truncate">
                                                    <a
                                                        class="font-medium text-gray-900 hover:text-gray-700"
                                                        href="#"
                                                    >
                                                        How to use search engine
                                                        optimization to drive
                                                        traffic to your site
                                                    </a>
                                                </li>

                                                <li class="text-base truncate">
                                                    <a
                                                        class="font-medium text-gray-900 hover:text-gray-700"
                                                        href="#"
                                                    >
                                                        Improve your customer
                                                        experience
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mt-5 text-sm">
                                            <a
                                                class="font-medium text-indigo-600 hover:text-indigo-500"
                                                href="#"
                                            >
                                                View all posts
                                                <span aria-hidden="true"
                                                    >&rarr;</span
                                                ></a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </nav>
                <div
                    class="items-center justify-end hidden md:flex md:flex-1 lg:w-0"
                >
                    <a
                        class="text-base font-medium text-gray-500 whitespace-nowrap hover:text-gray-900"
                        href="#"
                    >
                        Sign in
                    </a>
                    <a
                        class="inline-flex items-center justify-center px-4 py-2 ml-8 text-base font-medium text-gray-900 bg-yellow-400 border border-transparent rounded-md shadow-sm whitespace-nowrap hover:bg-yellow-500"
                        href="#"
                    >
                        Sign up
                    </a>
                </div>
            </div>
        </div>

        <!--
                Mobile menu, show/hide based on mobile menu state.

                Entering: "duration-200 ease-out"
                        From: "opacity-0 scale-95"
                        To: "opacity-100 scale-100"
                Leaving: "duration-100 ease-in"
                        From: "opacity-100 scale-100"
                        To: "opacity-0 scale-95"
        -->
        <transition
            enter-active-class="duration-200 ease-out"
            enter-class="scale-95 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="duration-100 ease-in"
            leave-class="scale-100 opacity-100"
            leave-to-class="scale-95 opacity-0"
        >
            <div
                :show="showMobileNavigation"
                class="absolute inset-x-0 top-0 p-2 transition origin-top-right transform md:hidden"
            >
                <div
                    class="bg-white divide-y-2 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 divide-gray-50"
                >
                    <div class="px-5 pt-5 pb-6">
                        <div class="flex items-center justify-between">
                            <div class="-ml-2">
                                <button
                                    class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                    type="button"
                                    @click="showMobileNavigation = false"
                                >
                                    <span class="sr-only">Close menu</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg
                                        aria-hidden="true"
                                        class="w-6 h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M6 18L18 6M6 6l12 12"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <img
                                    alt="Workflow"
                                    class="w-auto h-8"
                                    src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                                />
                            </div>
                        </div>
                        <div class="mt-6">
                            <nav class="grid gap-y-8">
                                <a
                                    class="flex items-center p-3 -m-3 rounded-md hover:bg-gray-50"
                                    href="#"
                                >
                                    <!-- Heroicon name: outline/chart-bar -->
                                    <svg
                                        aria-hidden="true"
                                        class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                    <span
                                        class="ml-3 text-base font-medium text-gray-900"
                                        >Analytics</span
                                    >
                                </a>

                                <a
                                    class="flex items-center p-3 -m-3 rounded-md hover:bg-gray-50"
                                    href="#"
                                >
                                    <!-- Heroicon name: outline/cursor-click -->
                                    <svg
                                        aria-hidden="true"
                                        class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                    <span
                                        class="ml-3 text-base font-medium text-gray-900"
                                        >Engagement</span
                                    >
                                </a>

                                <a
                                    class="flex items-center p-3 -m-3 rounded-md hover:bg-gray-50"
                                    href="#"
                                >
                                    <!-- Heroicon name: outline/shield-check -->
                                    <svg
                                        aria-hidden="true"
                                        class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                    <span
                                        class="ml-3 text-base font-medium text-gray-900"
                                        >Security</span
                                    >
                                </a>

                                <a
                                    class="flex items-center p-3 -m-3 rounded-md hover:bg-gray-50"
                                    href="#"
                                >
                                    <!-- Heroicon name: outline/view-grid -->
                                    <svg
                                        aria-hidden="true"
                                        class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                    <span
                                        class="ml-3 text-base font-medium text-gray-900"
                                        >Integrations</span
                                    >
                                </a>

                                <a
                                    class="flex items-center p-3 -m-3 rounded-md hover:bg-gray-50"
                                    href="#"
                                >
                                    <!-- Heroicon name: outline/refresh -->
                                    <svg
                                        aria-hidden="true"
                                        class="flex-shrink-0 w-6 h-6 text-indigo-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </svg>
                                    <span
                                        class="ml-3 text-base font-medium text-gray-900"
                                        >Automations</span
                                    >
                                </a>
                            </nav>
                        </div>
                    </div>
                    <div class="px-5 py-6 space-y-6">
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Pricing
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Docs
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Enterprise
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Blog
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Help Center
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Guides
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Security
                            </a>

                            <a
                                class="text-base font-medium text-gray-900 hover:text-gray-700"
                                href="#"
                            >
                                Events
                            </a>
                        </div>
                        <div>
                            <a
                                class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700"
                                href="#"
                            >
                                Sign up
                            </a>
                            <p
                                class="mt-6 text-base font-medium text-center text-gray-500"
                            >
                                Existing customer?
                                <a
                                    class="text-indigo-600 hover:text-indigo-500"
                                    href="#"
                                >
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    name: "Navigation",
    data() {
        return {
            showMobileNavigation: false,
            showMoreFlyout: false,
            showSolutionsFlyout: false,
        };
    },
};
</script>

<style scoped></style>
