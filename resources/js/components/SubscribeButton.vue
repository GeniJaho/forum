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
                'btn border',
                this.isActive ? 'btn-primary' : 'btn-default'
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
