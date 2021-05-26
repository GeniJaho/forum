<template>
    <div>
        <button
            :class="classes"
            :style="isActive ? 'text-shadow: none;' : ''"
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
                'button-neon inner-shadow-neon ground-shadow-neon inline-flex items-center px-3 py-2 mr-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark',
                this.isActive
                    ? 'text-neon-dark bg-neon'
                    : ''
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
