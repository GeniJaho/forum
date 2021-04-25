<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a id="notifsDropdown" class="nav-link dropdown-toggle" href="#" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <span class="fa fa-bell"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifsDropdown">
            <a
                v-for="notification in notifications"
                v-bind:key="notification.id"
                v-text="notification.data.message"
                :href="notification.data.link"
                @click="markAsRead(notification)"
                class="dropdown-item"
            ></a>
        </div>
    </li>
</template>

<script>
export default {
    name: "UserNotifications",
    data() {
        return {
            notifications: []
        }
    },
    methods: {
        markAsRead(notification) {
            axios.delete('/profiles/' + this.$userName + '/notifications/' + notification.id);
        }
    },
    created() {
        axios.get('/profiles/' + this.$userName + '/notifications')
            .then((response) => this.notifications = response.data);
    }
}
</script>

<style scoped>

</style>
