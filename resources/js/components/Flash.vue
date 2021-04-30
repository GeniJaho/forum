<template>
    <div
        class="alert alert-flash fade show"
        :class="'alert-' + level"
        role="alert" v-show="show"
        v-text="body"
    ></div>
</template>

<script>
import eventHub from "../eventHub";

export default {
    props: {
        message: String
    },
    data() {
        return {
            body: '',
            level: 'success',
            show: false
        }
    },
    created() {
        if (this.message) {
            this.flash(this.message);
        }

        eventHub.$on('flash', (message, level) => this.flash(message, level));
    },
    methods: {
        flash(message, level = 'success') {
            this.body = message;
            this.level = level;
            this.show = true;

            this.hide();
        },
        hide() {
            setTimeout(
                () => this.show = false,
                3000
            );
        }
    }
}
</script>

<style>
.alert-flash {
    position: fixed;
    right: 25px;
    bottom: 10px;
}
</style>
