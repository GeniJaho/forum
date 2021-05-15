<template>
    <button
        type="button"
        @click="$emit('click', $event)"
        class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
    >
        <span class="sr-only">Open user menu</span>
        <img class="h-8 w-8 rounded-full"
             :src="user.avatar_path"
             alt="">
    </button>
</template>
<script>
export default {
    name: 'Avatar',
    props: {
        user: Object
    }
}
</script>
