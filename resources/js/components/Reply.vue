<template>
    <div :id="'reply-' + id">
        <div
            class="card activity-item"
            :class="isBest ? 'border-success' : ''"
        >
            <div class="card-header header">
                <div>
                    <a :href="'/profiles/' + reply.owner.name">
                        {{ reply.owner.name }}
                    </a>
                    said <span v-text="ago"></span>
                </div>
                <div class="inline">
                    <div v-if="signedIn">
                        <favorite :reply="reply"></favorite>
                    </div>

                    <div v-if="! isBest"
                         class="d-flex align-items-center justify-content-center"
                         @click="markBestReply"
                    >
                        <button class="btn btn-primary">
                            <i class="far fa-star"></i>
                        </button>
                    </div>

                    <div v-if="canUpdate"
                         class="d-flex align-items-center justify-content-center" @click="showEdit"
                    >
                        <button class="btn btn-primary">
                            <i class="far fa-edit"></i>
                        </button>
                    </div>

                    <div v-if="canUpdate"
                         class="d-flex align-items-center justify-content-center" @click="destroy"
                    >
                        <button class="btn btn-danger">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div
                class="card-body"
                :class="isBest ? 'text-success' : ''"
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
import moment from "moment";

export default {
    name: "Reply",
    props: ['reply'],
    components: {
        Favorite
    },
    data() {
        return {
            id: this.reply.id,
            body: this.reply.body,
            editing: false,
            isBest: false
        }
    },
    computed: {
        ago() {
            return moment(this.reply.created_at).fromNow() + "...";
        },
        signedIn() {
            return this.$userId;
        },
        canUpdate() {
            return this.authorize(
                userId => this.reply.user_id.toString() === userId
            );
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
            // axios.post('/replies/' + this.id + '/best');
            this.isBest = true;
        }
    }
}
</script>

<style></style>
