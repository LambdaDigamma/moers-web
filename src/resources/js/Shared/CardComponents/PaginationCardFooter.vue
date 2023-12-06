<template>

<!--    <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-gray-200 sm:px-6">-->
<!--        &lt;!&ndash;-->
<!--            <div class="flex justify-between flex-1 hidden">-->
<!--              <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700">-->
<!--                Previous-->
<!--              </a>-->
<!--              <a href="#" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700">-->
<!--                Next-->
<!--              </a>-->
<!--            </div>-->
<!--         &ndash;&gt;-->
<!--        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">-->
<!--            <div>-->
<!--                <p class="text-sm leading-5 text-gray-700">-->
<!--                    Showing-->
<!--                    <span class="font-medium">{{ firstItem + 1 }}</span>-->
<!--                    to-->
<!--                    <span class="font-medium">{{ lastItem }}</span>-->
<!--                    of-->
<!--                    <span class="font-medium">{{ totalItems }}</span>-->
<!--                    results-->
<!--                </p>-->
<!--            </div>-->
<!--            <div>-->
<!--        <span class="relative z-0 inline-flex shadow-sm">-->

<!--            <template v-for="(link, key) in links">-->
<!--                <button v-if="link.url === null" :key="key" class="mb-2 mr-3 text-sm sm:text-base dark:text-gray-600" :class="{ link.label === 'Nächste' ? 'text-gray-400' :  }" :disabled="true">-->
<!--                    {{ link.label }}-->
<!--                </button>-->
<!--                <button v-else-->
<!--                    class="mb-2 mr-3 btn"-->
<!--                    :key="key"-->
<!--                    :class="{ 'dark:bg-yellow-500': link.active, 'dark:bg-gray-700 dark:text-gray-200' : !link.active, 'ml-auto': link.label === 'Nächste' }"-->
<!--                    @click="selectedButton(link.url)">-->
<!--                    {{ link.label }}-->
<!--                </button>-->
<!--            </template>-->





<!--          <button @click="firstPage" :disabled="prevDisabled" type="button" class="relative items-center hidden px-2 py-2 text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 sm:inline-flex rounded-l-md focus:z-10 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-100 active:text-gray-500" :class="{ 'text-gray-500 hover:text-gray-400': !prevDisabled, 'text-gray-400': prevDisabled }">-->
<!--            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">-->
<!--              <path fill-rule="evenodd" d="M13.707 5.293a1 1 0 010 1.414L10.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>-->
<!--              <path fill-rule="evenodd" d="M7 5a1 1 0 011 1v8a1 1 0 11-2 0V6a1 1 0 011-1z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->
<!--          <button @click="prevPage" :disabled="prevDisabled" type="button" class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 sm:-ml-px rounded-l-md sm:rounded-none focus:z-10 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-100 active:text-gray-500" :class="{ 'text-gray-500 hover:text-gray-400': !prevDisabled, 'text-gray-400': prevDisabled }">-->
<!--            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">-->
<!--              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->

<!--          <span v-for="page in pages">-->
<!--            <button @click="gotoPage(page - 1)" type="button"-->
<!--                    class="relative items-center hidden px-4 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out border border-gray-300 md:inline-flex focus:z-10 focus:outline-none focus:border-indigo-300 focus:ring-indigo active:bg-indigo-200 active:text-gray-700 hover:bg-indigo-50"-->
<!--                    :class="{ 'bg-indigo-100 text-indigo-700': tinted && page === currentPage + 1, 'bg-white text-gray-700': page !== currentPage + 1 }">-->
<!--              {{ page }}-->
<!--            </button>-->
<!--          </span>-->

<!--          <button @click="nextPage" :disabled="nextDisabled" type="button" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-r-md sm:rounded-none focus:z-10 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-100 active:text-gray-500" :class="{ 'text-gray-500 hover:text-gray-400': !nextDisabled, 'text-gray-400': nextDisabled }">-->
<!--            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">-->
<!--              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->
<!--          <button @click="lastPage" :disabled="nextDisabled" type="button" class="relative items-center hidden px-2 py-2 -ml-px text-sm font-medium leading-5 transition duration-150 ease-in-out bg-white border border-gray-300 sm:inline-flex rounded-r-md focus:z-10 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-100 active:text-gray-500" :class="{ 'text-gray-500 hover:text-gray-400': !nextDisabled, 'text-gray-400': nextDisabled }">-->
<!--            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">-->
<!--              <path fill-rule="evenodd" d="M6.293 5.293a1 1 0 000 1.414L9.586 10l-3.293 3.293a1 1 0 001.414 1.414l4-4a1 1 0 000-1.414l-4-4a1 1 0 00-1.414 0z" clip-rule="evenodd"/>-->
<!--              <path fill-rule="evenodd" d="M13 5a1 1 0 00-1 1v8a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->
<!--        </span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

</template>

<script>
    export default {
        name: "PaginationCardFooter",
        props: {
            links: Array,
            totalItems: {
                type: Number,
                required: true
            },
            itemsPerPage: {
                type: Number,
                required: false,
                default: 15
            },
            maxPages: {
                type: Number,
                required: false,
                default: 5
            },
            tinted: {
                type: Boolean,
                required: false,
                default: false
            }
        },
        methods: {
            selectedButton(url) {
                this.$inertia.visit(url)
            },
            isPage(page) {
                return page <= 3 || page >= this.totalPages - 2;
            },
            nextPage() {
                if(this.currentPage < this.totalPages - 1)
                    this.currentPage++;
                this.$emit('next-page');
            },
            prevPage() {
                if(this.currentPage > 0)
                    this.currentPage--;
                this.$emit('prev-page');
            },
            firstPage() {
                this.currentPage = 0;
                this.$emit('goto-index', this.currentPage);
            },
            lastPage() {
                this.currentPage = this.totalPages - 1;
                this.$emit('goto-index', this.currentPage);
            },
            gotoPage(page) {
                this.currentPage = page;
                this.$emit('goto-index', this.currentPage);
            }
        },
        data() {
            return {
                currentPage: 0
            }
        },
        computed: {
            nextDisabled() {
                return this.currentPage >= this.totalPages - 1;
            },
            prevDisabled() {
                return this.currentPage === 0;
            },
            lastItem() {
                return this.firstItem + this.itemsPerPage <= this.totalItems
                    ? this.firstItem + this.itemsPerPage
                    : this.totalItems;
            },
            firstItem() {
                return this.currentPage * this.itemsPerPage;
            },
            totalPages() {
                return Math.ceil(this.totalItems / this.itemsPerPage);
            },
            minPage() {
                return Math.floor(this.maxPages / 2);
            },
            maxPage() {
                return Math.ceil(this.maxPages / 2) - 1;
            },
            startPage() {
                if (this.totalPages <= this.maxPages || this.currentPage <= this.minPage)
                    return 1;
                else if (this.currentPage + this.maxPage >= this.totalPages)
                    return this.totalPages - this.maxPages + 1;
                return this.currentPage - this.minPage + 1;
            },
            endPage() {
                if (this.totalPages <= this.maxPages || this.currentPage + this.maxPage >= this.totalPages)
                    return this.totalPages;
                else if (this.currentPage <= this.minPage)
                    return this.maxPages;
                return this.currentPage + this.maxPage + 1;
            },
            pages() {
                return Array.from(Array((this.endPage + 1) - this.startPage).keys()).map(i => this.startPage + i);
            }
        }
    }
</script>

<style scoped>

</style>