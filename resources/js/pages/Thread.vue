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
        dataRepliesCount: Number,
        dataLocked: Boolean,
    },
    data() {
        return {
            repliesCount: this.dataRepliesCount,
            locked: this.dataLocked
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
