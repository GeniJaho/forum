<template>
    <div>
        <button
            :class="classes"
            @click="subscribe"
        >
            {{ this.isActive ? 'Unsubscribe' : 'Subscribe' }}
        </button>
    </div>
</template>

<script>

export default {
    name: "SubscribeButton",
    props: ['active'],
    data() {
        return {
            isActive: this.active
        }
    },
    computed: {
        classes() {
            return [
                'inline-flex items-center px-3 py-2 mr-3 border shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
                this.isActive
                    ? 'border-transparent text-white bg-indigo-600 hover:bg-indigo-700'
                    : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'
            ]
        }
    },
    methods: {
        subscribe() {
            let requestType = this.isActive ? 'delete' : 'post';

            axios[requestType](location.pathname + '/subscriptions')
                .then(() => this.isActive = !this.isActive);
        }
    }
}
</script>

<style scoped>

</style>
