<template>
    <input
        type="file"
        accept="image/*"
        class="text-neon"
        @change="onChange"
    >
</template>

<script>
export default {
    name: "ImageUpload",
    methods: {
        onChange(e) {
            if (!e.target.files.length) return;

            let file = e.target.files[0];

            let reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onload = e => {
                let src = e.target.result;

                this.$emit('loaded', {src, file});
            }
        },
    }
}
</script>

<style scoped>

</style>
