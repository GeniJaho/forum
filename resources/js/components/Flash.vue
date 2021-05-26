<template>
    <div
        class="fade show text-white bg-neon-extraDark z-10 overflow-hidden rounded-lg px-3 py-4 sm:px-5 fixed bottom-6 right-4 sm:bottom-6 sm:right-6 left-4 sm:left-auto"
        :class="'frame-' + level"
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
            level: 'neon',
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
        flash(message, level = 'neon') {
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

</style>
