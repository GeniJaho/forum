<template>

</template>

<script>
import Replies from "../components/Replies";
import eventHub from "../eventHub";
import { faEdit } from '@fortawesome/free-regular-svg-icons'
import { faTimes } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

export default {
    name: "Thread",
    components: {
        Replies,
        FontAwesomeIcon
    },
    props: {
        thread: Object,
    },
    data() {
        return {
            repliesCount: this.thread.replies_count,
            locked: this.thread.locked,
            editing: false,
            title: this.thread.title,
            body: this.thread.body,
            form: {}
        }
    },
    computed: {
        editIcon() {
            return faEdit;
        },
        deleteIcon() {
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
        replyAdded() {
            this.repliesCount++;
        },
        replyRemoved() {
            this.repliesCount--;
        },
        toggleLock() {
            let method = this.locked ? 'delete' : 'post';

            let uri = '/locked-threads/' + this.thread.slug;

            axios[method](uri);

            this.locked = !this.locked;
        },
        update() {
            let uri = '/threads/' + this.thread.channel.slug + '/' + this.thread.slug;
            axios.patch(uri, this.form)
                .then(response => {
                    if (!response) {
                        return;
                    }

                    this.title = this.form.title;
                    this.body = this.form.body;

                    this.hideEdit();

                    eventHub.$emit('flash', 'Your thread has been updated!')
                })
                .catch(error => {
                    eventHub.$emit('flash', error.response.data, 'neonSecondary');
                });
        },
        resetForm() {
            this.form = {
                title: this.thread.title,
                body: this.thread.body
            }

            this.hideEdit();
        }
    },
    created() {
        this.resetForm();
    }
}
</script>

<style scoped>

</style>
