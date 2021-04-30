<template>
    <div>
        <div v-if="signedIn" class="my-5">
            <div class="form-group">
                <textarea
                    class="form-control"
                    required
                    rows="5"
                    v-model="body"
                    placeholder="Have something to say?"
                ></textarea>
            </div>
            <button
                type="button"
                class="btn btn-primary"
                @click="addReply"
            >Post
            </button>
        </div>
        <p v-else
           class="text-center mt-2"
        >
            Please <a href="/login">sign in</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
import eventHub from "../eventHub";

export default {
    name: "NewReply",
    data() {
        return {
            body: "",
        }
    },
    computed: {
        signedIn() {
            return this.$userId;
        },
    },
    methods: {
        addReply() {
            axios.post(location.pathname + "/replies", {body: this.body})
                .catch(error => {
                    eventHub.$emit('flash', error.response.data, 'danger');
                })
                .then(response => {
                    if (!response) {
                        return;
                    }

                    this.body = "";
                    eventHub.$emit('flash', "Your reply has been posted!");
                    this.$emit('created', response.data);
                });
        }
    }
}
</script>

<style scoped>

</style>
