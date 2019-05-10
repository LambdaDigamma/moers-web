<template>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5>Organisationen</h5>

            <div class="d-flex align-items-end w-50">

                <button class="btn btn-success text-white mr-3 w-25" title="Add Organisation">
                    <b class="text-white">Add</b>
                </button>

                <div class="input-group w-75">
                    <input type="text" class="form-control" placeholder="Search Organisation" aria-label="Search term" v-model="searchTerm" @input.stop="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button">Search</button>
                    </div>
                </div>


            </div>
        </div>
        <div v-if="filteredOrganisations.length === 0" class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-5 bottom-radius">
            <span>We didn't find anything - just empty space.</span>
        </div>
        <table class="table table-hover table-sm mb-0 penultimate-column-right">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Entry</th>
                <th scope="col">Last Update</th>
                <th scope="col"></th>
            </tr>
            </thead>

            <transition-group tag="tbody" name="list">
                <router-link
                        tag="tr"
                        v-for="organisation in filteredOrganisations"
                        :key="organisation.id"
                        :to="{ name: 'organisation-detail', params: { id: organisation.id } }">
                    <td class="table-fit">{{ organisation.id }}</td>
                    <td class="table-fit">{{ organisation.name }}</td>
                    <td class="table-fit" v-if="organisation.entry && organisation.entry.name">{{ organisation.entry.name }}</td><td v-else>null</td>
                    <td class="table-fit" :data-timeago="organisation.updatedAt">{{ timeAgo(organisation.updatedAt) }}</td>
                    <td class="table-fit">
                        <router-link :to="{ name: 'organisation-detail', params: { id: organisation.id }}" class="control-action">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 16">
                                <path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path>
                            </svg>
                        </router-link>
                    </td>
                </router-link>
            </transition-group>

        </table>
    </div>

</template>

<script>
    export default {
        name: "OrganisationsList",
        data() {
            return {
                searchTerm: "",
                organisations: [],
            }
        },
        mounted() {
            axios.get('/api/v2/organisations', {
                headers: {
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                response.data.forEach((data) => {
                    this.organisations.push({
                        id: data.id,
                        name: data.name,
                        entry: data.entry,
                        updatedAt: data.updated_at
                    })
                })
            })
        },
        computed: {

            filteredOrganisations: function () {

                let filterOrganisations = this.organisations;
                let search = this.searchTerm;

                if (!search) {
                    return filterOrganisations;
                }

                search = search.trim().toLowerCase();

                filterOrganisations = filterOrganisations.filter(function(item) {
                    if (item.name.toLowerCase().indexOf(search) !== -1) {
                        return item;
                    }
                });

                // Return an array with the filtered data.
                return filterOrganisations;
            }
        }
    }
</script>

<style scoped>

</style>