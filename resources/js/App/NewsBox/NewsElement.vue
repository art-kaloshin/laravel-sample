<template>
    <div>
        <h3>
            {{ news.title }}
        </h3>
        <small>
            {{ news.date }}
            (
                <span class="link-info" @click="handleEdit">Edit</span> /
                <span class="link-info text-danger" @click="handleDelete">Delete</span>
            )
        </small>
        <p>{{ news.description }}</p>
        <p v-if="showText">{{ news.text }}</p>
        <p v-if="! showText" class="text-end text-primary link-info" @click="showText = true">more...</p>
        <p v-if="showText" class="text-end text-primary link-info" @click="showText = false">less...</p>
    </div>

</template>

<script>
export default {
    name: "NewsElement",
    props: ["news"],
    emits: ["newsDelete", "newsEdit"],
    data() {
        return {
            showText: false
        }
    },
    methods: {
        handleDelete() {
            this.$emit('newsDelete', this.news);
        },
        handleEdit() {
            this.$emit('newsEdit', this.news);
        }
    }
}
</script>

<style scoped>
.link-info {
    cursor: pointer;
}
</style>
