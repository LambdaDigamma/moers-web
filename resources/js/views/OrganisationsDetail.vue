<template>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5>Details</h5>
            <div class="d-flex align-items-end w-25">
                <button class="btn btn-primary text-white mr-3 w-50" title="Edit Organisation" @click="isEditing = !isEditing">
                    <b class="text-white">{{ isEditing ? 'Cancel' : 'Edit' }}</b>
                </button>
                <button class="btn btn-success text-white w-50" title="Save Organisation" @click="save()">
                    <b class="text-white">Save</b>
                </button>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center card-bg-secondary p-3 bottom-radius">
            <span></span>
        </div>
        <div class="m-4 bottom-radius">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" v-bind:disabled="!isEditing" v-model="organisation.name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" v-bind:disabled="!isEditing" v-model="organisation.description" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="card-header d-flex">
            <h5>Users</h5>
        </div>
        <table class="table table-hover table-sm mb-0">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Role</th>
            </tr>
            </thead>

            <transition-group tag="tbody" name="users" v-if="organisation && organisation.users">
                <!--<router-link-->
                        <!--tag="tr"-->
                        <!--v-for="user in organisation.users"-->
                        <!--:key="user.id">-->
                <tr v-for="user in organisation.users"
                    :key="user.id">
                    <td class="table-fit">{{ user.id }}</td>
                    <td class="table-fit">{{ user.name }}</td>
                    <td class="table-fit">{{ user.pivot.role }}</td>
                    </tr>
                <!--</router-link>-->
            </transition-group>

        </table>
    </div>
</template>

<script>
    import OrganisationOverview from "../components/OrganisationOverview";
    import OrganisationEdit from "../components/OrganisationEdit";
    export default {
        name: "OrganisationsDetail",
        components: { OrganisationEdit, OrganisationOverview },
        data() {
            return {
                isEditing: false,
                organisation: null
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;

            axios.get('/api/v2/organisations/' + id, {
                headers: {
                    'Content-Type': 'application/json',
                }
            }).then(response => {
                this.organisation = response.data;
            }).catch(function () {
                alert("Could not load your organisation")
            });
        },
        methods: {
            save() {
                event.preventDefault();
                var app = this;
                var organisation = this.organisation;
                console.log(organisation);
                axios.put('/api/v2/organisations/' + organisation.id, organisation)
                    .then(function (resp) {
                        app.$router.push({ path: '/organsations' });
                    })
                    .catch(function (resp) {
                        console.log(resp.data);
                        alert("Could not create your organisation");
                    });
            }
        }
    }
</script>

<style scoped>

</style>