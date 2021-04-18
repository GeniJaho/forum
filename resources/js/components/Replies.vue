<template>
    <div>
        <div v-for="(reply, index) in items"
             class="mt-2"
        >
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
</template>

<script>
import Reply from "./Reply";
import eventHub from "../eventHub";

export default {
    name: "Replies",
    components: {
        Reply
    },
    props: {
        data: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            items: this.data
        }
    },
    methods: {
        remove(index) {
            this.items.splice(index, 1);

            this.$emit('removed')

            eventHub.$emit('flash', 'Reply was deleted!')
        }
    }
}
</script>

<style scoped>

</style>
