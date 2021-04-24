<template>
    <div :id="'reply-' + id">
        <div class="card activity-item">
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

            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea v-model="body"
                                  type="text" class="form-control"
                                  required
                                  rows="5"></textarea>
                    </div>
                    <button class="btn btn-primary btn-xs" @click="update">
                        Update
                    </button>
                    <button class="btn btn-link btn-xs" @click="hideEdit">
                        Cancel
                    </button>
                </div>
                <div v-else>
                    {{ body }}
                </div>

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
            editing: false
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
            }).then(() => {
                this.hideEdit();
                eventHub.$emit('flash', 'Updated!')
            });
        },
        destroy() {
            axios.delete('/replies/' + this.id)
                .then(() => this.$emit('deleted', this.id));
        }
    }
}
</script>

<style></style>
