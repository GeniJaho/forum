<template>
    <div>
        <div v-for="(reply, index) in items"
             v-bind:key="reply.id"
             class="mt-2"
        >
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :data-set="dataSet" @changed="fetch"></paginator>

        <p
            v-if="$parent.locked"
            class="text-center mt-4"
        >
            This thread has been locked. No more replies are allowed.
        </p>

        <new-reply
            v-else
            @created="add"
        ></new-reply>
    </div>
</template>

<script>
import Reply from "./Reply";
import NewReply from "./NewReply";
import collection from "../mixins/collection";
import Paginator from "./Paginator";

export default {
    name: "Replies",
    components: {
        Reply, NewReply, Paginator
    },
    mixins: [collection],
    data() {
        return {
            dataSet: false
        }
    },
    methods: {
        fetch(page) {
            axios.get(this.url(page))
                .then(this.refresh)
        },
        url(page) {
            if (!page) {
                let query = location.search.match(/page=(\d+)/);
                page = query ? query[1] : 1;
            }
            return `${location.pathname}/replies?page=${page}`;
        },
        refresh({data}) {
            this.dataSet = data;
            this.items = data.data;

            window.scrollTo(0, 0);
        }
    },
    created() {
        this.fetch();
    }
}
</script>

<style scoped>

</style>
