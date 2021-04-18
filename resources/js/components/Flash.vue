<template>
    <div class="alert alert-success alert-flash fade show" role="alert" v-show="show">
        <strong>Success!</strong> {{ this.body }}
    </div>
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
            show: false
        }
    },
    created() {
        if (this.message) {
            this.flash(this.message);
        }

        eventHub.$on('flash', message => this.flash(message));
    },
    methods: {
        flash(message) {
            this.body = message;
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
