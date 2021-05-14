<template>

</template>

<script>
import Replies from "../components/Replies";
import eventHub from "../eventHub";

export default {
    name: "Thread",
    components: {
        Replies
    },
    props: {
        thread: Object,
    },
    data() {
        return {
            repliesCount: this.thread.replies_cont,
            locked: this.thread.locked,
            editing: false,
            title: this.thread.title,
            body: this.thread.body,
            form: {}
        }
    },
    methods: {
        showEdit() {
            this.editing = true;
        },
        hideEdit() {
            this.editing = false;
        },
        replyAdded() {
            this.repliesCount++;
        },
        replyRemoved() {
            this.repliesCount--;
        },
        toggleLock() {
            let method = this.locked ? 'delete' : 'post';

            let uri = '/locked-threads/' + this.thread.slug;

            axios[method](uri);

            this.locked = !this.locked;
        },
        update() {
            let uri = '/threads/' + this.thread.channel.slug + '/' + this.thread.slug;
            axios.patch(uri, this.form)
                .then(response => {
                    if (!response) {
                        return;
                    }

                    this.title = this.form.title;
                    this.body = this.form.body;

                    this.hideEdit();

                    eventHub.$emit('flash', 'Your thread has been updated!')
                })
                .catch(error => {
                    eventHub.$emit('flash', error.response.data, 'danger');
                });
        },
        resetForm() {
            this.form = {
                title: this.thread.title,
                body: this.thread.body
            }

            this.hideEdit();
        }
    },
    created() {
        this.resetForm();
    }
}
</script>

<style scoped>

</style>
