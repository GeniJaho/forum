<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl" class="page-item">
            <a class="page-link"
               :href="prevUrl"
               rel="prev"
               @click.prevent="page--"
            >&laquo; Prev</a>
        </li>

        <li v-show="nextUrl" class="page-item">
            <a class="page-link"
               :href="nextUrl"
               rel="next"
               @click.prevent="page++"
            >Next &raquo;</a>
        </li>

    </ul>
</template>

<script>
export default {
    name: "Paginator",
    props: ["dataSet"],
    data() {
        return {
            page: 1,
            nextUrl: false,
            prevUrl: false
        }
    },
    watch: {
        dataSet() {
            this.page = this.dataSet.current_page;
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;
        },
        page() {
            return this.broadcast().updateUrl();
        }
    },
    computed: {
        shouldPaginate() {
            return !!this.nextUrl || !!this.prevUrl;
        }
    },
    methods: {
        broadcast() {
            return this.$emit('changed', this.page);
        },
        updateUrl() {
            history.pushState(null, null, `?page=${this.page}`);
        }
    }
}
</script>

<style scoped>

</style>
