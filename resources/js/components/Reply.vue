<template>
    <div :id="'reply-' + id">
        <div
            class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200 border"
            :class="isBest ? 'border-green-700' : 'border-transparent'"
        >
            <div class="px-4 py-5 sm:px-6">
                <div class="flex flex-row justify-between">
                    <div>
                        <a class="text-indigo-600 hover:text-indigo-500"
                           :href="'/profiles/' + reply.owner.name">
                            {{ reply.owner.name }}
                        </a>
                        said <span v-text="ago"></span>
                    </div>
                    <div class="flex flex-row space-x-3">
                        <div v-if="signedIn">
                            <favorite :reply="reply"></favorite>
                        </div>

                        <button
                            v-if="! isBest && authorize('owns', reply.thread)"
                            @click="markBestReply"
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <font-awesome-icon
                                :icon="iconFavorite"
                                class="h-5 w-5 fa-fw text-green-400"></font-awesome-icon>
                        </button>

                        <button
                            v-if="authorize('owns', reply)"
                            @click="showEdit"
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <font-awesome-icon :icon="iconEdit"
                                               class="h-5 w-5 fa-fw"></font-awesome-icon>
                        </button>

                        <button
                            v-if="authorize('owns', reply)"
                            @click="destroy"
                            type="button"
                            class="inline-flex items-center px-3 py-2 h-full border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <font-awesome-icon :icon="iconDelete"
                                               class="h-5 w-5 fa-fw"></font-awesome-icon>
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 sm:px-6"
                 :class="isBest ? 'text-green-700' : ''"
            >
                <div v-if="editing">
                    <form @submit.prevent="update">
                        <div class="form-group">
                        <textarea
                            v-model="body"
                            type="text"
                            class="form-control"
                            required
                            rows="5"
                        ></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-xs">
                            Update
                        </button>
                        <button type="button" class="btn btn-link btn-xs" @click="hideEdit">
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
import {faStar, faTimes} from '@fortawesome/free-solid-svg-icons'
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
                    eventHub.$emit('flash', error.response.data, 'danger');
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
