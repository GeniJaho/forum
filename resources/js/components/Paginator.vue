<template>

    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-3">
        <div class="flex justify-between flex-1">
            <a
                v-show="prevUrl"
                :href="prevUrl"
                rel="prev"
                @click.prevent="page--"
                class="button-neon inner-shadow-neon items-center relative inline-flex px-4 py-2 mr-3 text-sm font-medium leading-5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark active:bg-neon-dark transition ease-in-out duration-150"
            >&laquo; Prev</a>

            <a
                v-show="nextUrl"
                :href="nextUrl"
                class="button-neon inner-shadow-neon items-center relative inline-flex px-4 py-2 text-sm font-medium leading-5 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark active:bg-neon-dark transition ease-in-out duration-150"
                rel="next"
                @click.prevent="page++"
            >Next &raquo;</a>
        </div>
    </nav>
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
