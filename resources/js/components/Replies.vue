<template>
    <div>
        <div v-for="(reply, index) in items"
             v-bind:key="reply.id"
             class="mt-2"
        >
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
import Reply from "./Reply";
import eventHub from "../eventHub";
import NewReply from "./NewReply";

export default {
    name: "Replies",
    components: {
        Reply, NewReply
    },
    props: {
        data: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            items: this.data,
            endpoint: location.pathname + "/replies"
        }
    },
    methods: {
        add(reply) {
            this.items.push(reply);

            this.$emit('added')
        },
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
