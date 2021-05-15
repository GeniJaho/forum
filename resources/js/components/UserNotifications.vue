<template>
    <div class="relative" v-if="notifications.length">
        <div>
            <button
                @click="toggleDropdown"
                class="ml-3 bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                id="notificationsDropdown"
                aria-haspopup="true"
                :aria-expanded="String(open)"
            >
                <span class="sr-only">View notifications</span>
                <!-- Heroicon name: outline/bell -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1 right-1 block h-1.5 w-1.5 rounded-full bg-green-400"></span>
            </button>
        </div>

        <div v-if="open"
             class="notificationsList origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
             role="menu"
             aria-orientation="vertical"
             aria-labelledby="notificationsDropdown"
             tabindex="-1"
        >
            <a
                v-for="notification in notifications"
                v-bind:key="notification.id"
                v-text="notification.data.message"
                :href="notification.data.link"
                @click="markAsRead(notification)"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                role="menuitem" tabindex="-1"
            ></a>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserNotifications",
    data() {
        return {
            notifications: [],
            open: false
        }
    },
    methods: {
        markAsRead(notification) {
            axios.delete('/profiles/' + this.$userName + '/notifications/' + notification.id);
        },
        toggleDropdown() {
            this.open = !this.open;
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
