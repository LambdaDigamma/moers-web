<template>
    <div>
        <div class="md:mb-4">
            <inertia-link class="py-2 flex items-center group hover:no-underline" :href="route('admin.dashboard')">
                <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('admin/dashboard') ? 'fill-white' : 'fill-gray-700 md:fill-gray-600 group-hover:fill-white'" />
                <div :class="isUrl('admin/dashboard') ? 'text-white' : 'text-gray-700 md:text-gray-600 group-hover:text-white'">Dashboard</div>
            </inertia-link>
        </div>
        <div class="md:mb-4">
            <inertia-link class="py-2 flex items-center group hover:no-underline" :href="route('admin.organisations.index')">
                <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('admin/organisations') ? 'fill-white' : 'fill-gray-700 md:fill-gray-600 group-hover:fill-white'" />
                <div :class="isUrl('admin/organisations') ? 'text-white' : 'text-gray-700 md:text-gray-600 group-hover:text-white'">Organisationen</div>
            </inertia-link>
        </div>
        <div class="md:mb-4">
            <inertia-link class="py-2 flex items-center group hover:no-underline" :href="route('admin.polls.index')">
                <icon name="pie-chart" class="w-4 h-4 mr-2" :class="isUrl('admin/polls') ? 'fill-white' : 'fill-gray-700 md:fill-gray-600 group-hover:fill-white'" />
                <div :class="isUrl('admin/polls') ? 'text-white' : 'text-gray-700 md:text-gray-600 group-hover:text-white'">Abstimmungen</div>
            </inertia-link>
        </div>
        <div class="md:mb-4">
            <inertia-link class="py-2 flex items-center group hover:no-underline" :href="route('admin.pages.index')">
                <icon name="document" class="w-4 h-4 mr-2" :class="isUrl('admin/pages') ? 'fill-white' : 'fill-gray-700 md:fill-gray-600 group-hover:fill-white'" />
                <div :class="isUrl('admin/pages') ? 'text-white' : 'text-gray-700 md:text-gray-600 group-hover:text-white'">Seiten</div>
            </inertia-link>
        </div>
    </div>
</template>

<script>
    import Icon from '@/Shared/Icon'

    export default {
        components: {
            Icon,
        },
        props: {
            url: String,
        },
        methods: {
            isUrl(...urls) {
                if (urls[0] === '') {
                    return this.url === ''
                }

                return urls.filter(url => this.url.startsWith(url)).length
            },
        },
    }
</script>
