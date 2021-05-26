<template>
    <div :id="'reply-' + id">
        <div
            class="frame-neon hover:box-shadow-neon overflow-hidden rounded-lg divide-y"
            :class="isBest ? 'border-teal divide-teal' : 'divide-neon'"
        >
            <div class="px-4 py-5 sm:px-6">
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 justify-between align-middle text-white">
                    <div class="flex items-center" :class="isBest ? 'text-teal' : ''">
                        <div>
                            <a class="text-neon hover:text-neon-dark"
                               :href="'/profiles/' + reply.owner.name">
                                {{ reply.owner.name }}
                            </a>
                            said <span v-text="ago"></span>
                        </div>
                    </div>
                    <div class="flex flex-row space-x-3">
                        <template v-if="signedIn">
                            <favorite :reply="reply"></favorite>
                        </template>

                        <button
                            v-if="! isBest && authorize('owns', reply.thread)"
                            @click="markBestReply"
                            type="button"
                            class="button-neon inner-shadow-neon text-teal hover:text-neon-dark inline-flex items-center px-3 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                            <font-awesome-icon
                                :icon="iconFavorite"
                                class="h-5 w-5 fa-fw"></font-awesome-icon>
                        </button>

                        <button
                            v-if="authorize('owns', reply)"
                            @click="showEdit"
                            type="button"
                            class="button-neon inner-shadow-neon inline-flex items-center px-3 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                            <font-awesome-icon :icon="iconEdit"
                                               class="h-5 w-5 fa-fw"></font-awesome-icon>
                        </button>

                        <button
                            v-if="authorize('owns', reply)"
                            @click="destroy"
                            type="button"
                            class="button-neonSecondary inner-shadow-neonSecondary inline-flex items-center px-3 py-2 h-full text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neonSecondary-dark focus:ring-neonSecondary-dark">
                            <font-awesome-icon :icon="iconDelete"
                                               class="h-5 w-5 fa-fw"></font-awesome-icon>
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 sm:px-6 text-white"
                 :class="isBest ? 'text-teal' : ''"
            >
                <div v-if="editing">
                    <form @submit.prevent="update" class="relative">
                        <textarea
                            type="text"
                            class="bg-transparent border-2 border-neon placeholder-neon text-white block w-full sm:text-sm rounded-md focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark"
                            required
                            rows="5"
                            v-model="body"
                        ></textarea>

                        <button type="submit" class="button-neon inner-shadow-neon inline-flex items-center px-3 py-2 mt-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                            Update
                        </button>
                        <button type="button" class="ml-2 button-neonSecondary inner-shadow-neonSecondary inline-flex items-center px-3 py-2 mt-3 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neonSecondary-dark focus:ring-neonSecondary-dark" @click="hideEdit">
                            Cancel
                        </button>
                    </form>
                </div>
                <div v-else v-html="body"></div>
            </div>
        </div>
    </div>
</template>

<script>

import eventHub from "../eventHub";
import Favorite from "./Favorite";
import { faEdit } from '@fortawesome/free-regular-svg-icons'
import {faTimes} from '@fortawesome/free-solid-svg-icons'
import {faStar} from '@fortawesome/free-regular-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import moment from "moment";

export default {
    name: "Reply",
    props: ['reply'],
    components: {
        Favorite, FontAwesomeIcon
    },
    data() {
        return {
            id: this.reply.id,
            body: this.reply.body,
            editing: false,
            isBest: this.reply.isBest
        }
    },
    computed: {
        ago() {
            return moment(this.reply.created_at).fromNow() + "...";
        },
        iconFavorite() {
            return faStar;
        },
        iconEdit() {
            return faEdit;
        },
        iconDelete() {
            return faTimes;
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
            axios.patch('/replies/' + this.id, {
                body: this.body
            })
                .then(response => {
                    if (!response) {
                        return;
                    }

                    this.hideEdit();
                    eventHub.$emit('flash', 'Updated!')
                })
                .catch(error => {
                    eventHub.$emit('flash', error.response.data, 'neonSecondary');
                });
        },
        destroy() {
            axios.delete('/replies/' + this.id)
                .then(() => this.$emit('deleted', this.id));
        },
        markBestReply() {
            axios.post('/replies/' + this.id + '/best')
                .then(() => {
                    eventHub.$emit('best-reply-selected', this.id);
                });
        }
    },
    created() {
        eventHub.$on('best-reply-selected', id => {
            this.isBest = id === this.id;
        });
    }
}
</script>

<style></style>
