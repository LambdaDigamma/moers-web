<template>

<!--    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">-->
<!--        &lt;!&ndash;-->
<!--            <div class="flex-1 flex justify-between hidden">-->
<!--              <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">-->
<!--                Previous-->
<!--              </a>-->
<!--              <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">-->
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
<!--                <button v-if="link.url === null" :key="key" class="mr-3 mb-2 text-sm sm:text-base dark:text-gray-600" :class="{ link.label === 'Nächste' ? 'text-gray-400' :  }" :disabled="true">-->
<!--                    {{ link.label }}-->
<!--                </button>-->
<!--                <button v-else-->
<!--                    class="btn mr-3 mb-2"-->
<!--                    :key="key"-->
<!--                    :class="{ 'dark:bg-yellow-500': link.active, 'dark:bg-gray-700 dark:text-gray-200' : !link.active, 'ml-auto': link.label === 'Nächste' }"-->
<!--                    @click="selectedButton(link.url)">-->
<!--                    {{ link.label }}-->
<!--                </button>-->
<!--            </template>-->





<!--          <button @click="firstPage" :disabled="prevDisabled" type="button" class="hidden sm:inline-flex relative items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" :class="{ 'text-gray-500 hover:text-gray-400': !prevDisabled, 'text-gray-400': prevDisabled }">-->
<!--            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">-->
<!--              <path fill-rule="evenodd" d="M13.707 5.293a1 1 0 010 1.414L10.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>-->
<!--              <path fill-rule="evenodd" d="M7 5a1 1 0 011 1v8a1 1 0 11-2 0V6a1 1 0 011-1z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->
<!--          <button @click="prevPage" :disabled="prevDisabled" type="button" class="sm:-ml-px relative inline-flex items-center px-2 py-2 rounded-l-md sm:rounded-none border border-gray-300 bg-white text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" :class="{ 'text-gray-500 hover:text-gray-400': !prevDisabled, 'text-gray-400': prevDisabled }">-->
<!--            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">-->
<!--              <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->

<!--          <span v-for="page in pages">-->
<!--            <button @click="gotoPage(page - 1)" type="button"-->
<!--                    class="-ml-px relative hidden md:inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-indigo-200 active:text-gray-700 transition ease-in-out duration-150 hover:bg-indigo-50"-->
<!--                    :class="{ 'bg-indigo-100 text-indigo-700': tinted && page === currentPage + 1, 'bg-white text-gray-700': page !== currentPage + 1 }">-->
<!--              {{ page }}-->
<!--            </button>-->
<!--          </span>-->

<!--          <button @click="nextPage" :disabled="nextDisabled" type="button" class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md sm:rounded-none border border-gray-300 bg-white text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" :class="{ 'text-gray-500 hover:text-gray-400': !nextDisabled, 'text-gray-400': nextDisabled }">-->
<!--            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">-->
<!--              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>-->
<!--            </svg>-->
<!--          </button>-->
<!--          <button @click="lastPage" :disabled="nextDisabled" type="button" class="-ml-px relative hidden sm:inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" :class="{ 'text-gray-500 hover:text-gray-400': !nextDisabled, 'text-gray-400': nextDisabled }">-->
<!--            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">-->
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