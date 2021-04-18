<template>

</template>

<script>

import eventHub from "../eventHub";

export default {
    props: ['attributes'],
    data() {
        return {
            body: this.attributes.body,
            editing: false
        }
    },
    methods: {
        showEdit() {
            this.editing = true;
        },
        hideEdit() {
            this.editing = false;
        },
        update() {
            axios.patch('/replies/' + this.attributes.id, {
                body: this.body
            }).then(() => {
                this.hideEdit();
                eventHub.$emit('flash', 'Updated!')
            });
        },
        destroy() {
            axios.delete('/replies/' + this.attributes.id)
                .then(() => {
                    this.$el.style.display = 'none';
                    eventHub.$emit('flash', 'Your reply has been deleted!')
                });
        }
    }
}
</script>

<style></style>
