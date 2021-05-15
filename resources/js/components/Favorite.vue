<template>
    <button
        @click="toggle"
        :class="classes"
        type="button" class="inline-flex items-center px-3 py-2 h-full border shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <font-awesome-icon
            :icon="active ? iconHeartSolid : iconHeart"
            class="h-5 w-5 fa-fw mr-2"></font-awesome-icon>
        <span>{{ count }}</span>
    </button>
</template>

<script>

import eventHub from "../eventHub";
import {faHeart} from '@fortawesome/free-regular-svg-icons'
import {faHeart as faHeartSolid} from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

export default {
    name: "Favorite",
    props: ['reply'],
    components: { FontAwesomeIcon },
    data() {
        return {
            count: this.reply.favoritesCount,
            active: this.reply.isFavorited
        }
    },
    computed: {
        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        },
        iconHeart() {
            return faHeart;
        },
        iconHeartSolid() {
            return faHeartSolid;
        },
        classes() {
            return this.active
                ? 'border-transparent text-white bg-indigo-600 hover:bg-indigo-700'
                : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'
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
