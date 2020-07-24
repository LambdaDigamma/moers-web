<template>

    <div>
        <Header :title="organisation.name">
            <div slot="nav">
                <div class="mt-6">
                    <div class="sm:hidden">
                        <select aria-label="Selected tab" class="form-select block w-full">
                            <option selected>
                                Allgemeines
                            </option>
                            <option>
                                Benutzer
                            </option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-red-500">
                            <nav class="flex -mb-px space-x-8">
                                <TabItem title="Allgemeines"
                                         :href="route('admin.organisations.edit', [organisation.id])" :active="endPath === ''">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </TabItem>
<!--                                <TabItem title="Benutzer"-->
<!--                                         :href="route('admin.organisations.edit.users', [organisation.id])" :active="endPath === 'users'">-->
<!--                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />-->
<!--                                </TabItem>-->
<!--                                <TabItem title="Kalender-Vorlagen"-->
<!--                                         :href="route('admin.organisations.edit.templates', [organisation.id])" :active="endPath === 'templates'">-->
<!--                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />-->
<!--                                </TabItem>-->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </Header>
        <main>
            <slot></slot>
        </main>
    </div>

</template>

<script>
    import TabItem from "../Shared/UI/TabItem";
    export default {
        name: "LayoutEditOrganisation",
        components: {TabItem},
        props: {
            organisation: Object,
            endPath: String
        }
    }
</script>

<style scoped>

</style>
