<template>
    <div>
        <div v-if="signedIn" class="my-5">
                <vue-tribute :options="tributeOptions">
                    <textarea
                        class="bg-transparent border-2 border-neon placeholder-neon text-white mt-1 block w-full sm:text-sm rounded-md focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark"
                        required
                        rows="5"
                        v-model="body"
                        placeholder="Have something to say?"
                    ></textarea>
                </vue-tribute>

            <button
                type="button"
                class="button-neon inner-shadow-neon ground-shadow-neon inline-flex items-center px-3 py-2 mt-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark"
                @click="addReply"
            >Post</button>
        </div>
        <p v-else
           class="text-center text-white mt-2"
        >
            Please <a href="/login" class="text-neon">sign in</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
import eventHub from "../eventHub";
import VueTribute from 'vue-tribute';

export default {
    name: "NewReply",
    components: {
        VueTribute
    },
    data() {
        return {
            body: "",
            tributeOptions: {
                values: _.debounce(this.getUsers.bind(this), 750),
                lookup: 'name',
                fillAttr: 'name',
                noMatchTemplate: function () {
                    return '<span style:"visibility: hidden;"></span>';
                }
            }
        }
    },
    methods: {
        addReply() {
            axios.post(location.pathname + "/replies", {body: this.body})
                .catch(error => {
                    eventHub.$emit('flash', error.response.data, 'neonSecondary');
                })
                .then(response => {
                    if (!response) {
                        return;
                    }

                    this.body = "";
                    eventHub.$emit('flash', "Your reply has been posted!");
                    this.$emit('created', response.data);
                });
        },
        getUsers(name, callback) {
            axios
                .get(`/api/users?name=${name}`)
                .then(response => {
                    if (response) {
                        callback(response.data);
                    }
                })
                .catch(() => {
                    callback([]);
                });
        }
    }
}
</script>

<style scoped>

</style>
