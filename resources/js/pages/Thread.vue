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
        initialRepliesCount: Number
    },
    data() {
        return {
            repliesCount: this.initialRepliesCount
        }
    },
    methods: {
        replyAdded() {
            this.repliesCount++;
        },
        replyRemoved() {
            this.repliesCount--;
        }
    }
}
</script>

<style scoped>

</style>
