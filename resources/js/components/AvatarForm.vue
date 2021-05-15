<template>
    <div>
        <div class="flex flex-row space-x-3 mb-3">
            <img class="h-16 w-16 rounded-full"
                 :src="avatar"
                 alt="Avatar"
            >
            <h1 class="font-medium leading-5 text-xl self-center" v-text="user.name"></h1>
        </div>

        <form v-if="canUpdate"
              enctype="multipart/form-data"
              method="post"
        >
            <image-upload
                name="avatar"
                @loaded="onLoad"
            ></image-upload>
        </form>
    </div>
</template>

<script>
import eventHub from "../eventHub";
import ImageUpload from "./ImageUpload";

export default {
    name: "AvatarForm",
    components: { ImageUpload },
    props: ['user'],
    data() {
        return {
            avatar: this.user.avatar_path
        }
    },
    computed: {
        canUpdate() {
            return this.authorize(userId => userId === this.user.id.toString());
        }
    },
    methods: {
        onLoad(avatar) {
            this.avatar = avatar.src;
            this.persist(avatar.file);
        },
        persist(avatar) {
            let data = new FormData();

            data.append('avatar', avatar);

            axios.post(`/api/users/${this.user.name}/avatar`, data)
                .then(() => {
                    eventHub.$emit('flash', "Avatar uploaded!");
                });
        }
    }
}
</script>

<style scoped>

</style>
