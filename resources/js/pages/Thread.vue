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
            body: this.thread.body
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

            axios[method]('/locked-threads/' + this.thread.slug);

            this.locked = !this.locked;
        },
        update() {
            // axios.patch('/replies/' + this.id, {
            //     body: this.body
            // })
            //     .then(response => {
            //         if (!response) {
            //             return;
            //         }
            //
            //         this.hideEdit();
            //         eventHub.$emit('flash', 'Updated!')
            //     })
            //     .catch(error => {
            //         eventHub.$emit('flash', error.response.data, 'danger');
            //     });
        }
    }
}
</script>

<style scoped>

</style>
