<template>
    <div>
        <div class="d-inline-block">
            <img class="h-8 w-8 rounded-full mr-1 mb-2"
                 :src="avatar"
                 alt="Avatar"
            >
            <h1 class="d-inline-block" v-text="user.name"></h1>
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
