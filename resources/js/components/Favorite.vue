<template>
    <button
        :class="{
            'btn': true,
            'btn-primary': active,
            'btn-default': !active
        }"
        @click="toggle"
    >
        <span>{{ count }}</span>
        <i :class="{
            'fa': active,
            'far': !active,
            'fa-heart ml-1': true
        }"></i>
    </button>
</template>

<script>

import eventHub from "../eventHub";

export default {
    name: "Favorite",
    props: ['reply'],
    data() {
        return {
            count: this.reply.favoritesCount,
            active: this.reply.isFavorited
        }
    },
    computed: {
        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },
    methods: {
        toggle() {
            this.active ? this.destroy() : this.create();
        },
        create() {
            axios.post(this.endpoint)
                .then(() => {
                    this.active = true;
                    this.count++;
                    eventHub.$emit('flash', 'Liked!')
                });
        },
        destroy() {
            axios.delete(this.endpoint)
                .then(() => {
                    this.active = false;
                    this.count--;
                    eventHub.$emit('flash', 'Unliked!')
                });
        }
    }
}
</script>

<style></style>
