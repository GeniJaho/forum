<template>

</template>

<script>
import Replies from "../components/Replies";

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
            locked: this.thread.locked
        }
    },
    methods: {
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
        }
    }
}
</script>

<style scoped>

</style>
