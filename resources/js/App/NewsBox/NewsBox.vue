<template>
    <h2 class="border-bottom border-primary pb-2">
        News
        <button class="btn btn-primary btn-sm float-end" @click="handleCreate">Create</button>
    </h2>
    <template v-for="news in newsList">
        <NewsElement :news="news" @news-delete="handleDelete" @news-edit="handleEdit"/>
    </template>

    <NewsEdit v-if="showForm" :news="editNews" :section-list="sectionList" :key="editNews" @cancel-edit="handleCancel" @save-news="handleSave"/>
</template>

<script>
import NewsElement from "./NewsElement.vue";
import NewsEdit from "./NewsEdit.vue";
export default {
    name: "NewsBox",
    components: {NewsEdit, NewsElement},
    props: ["newsList", "sectionList"],
    emits: ["newsListUpdate"],
    data() {
        return {
            showForm: false,
            editNews: {}
        }
    },
    methods: {
        handleCancel() {
            this.showForm = false;
        },
        handleDelete(news) {
            axios.delete('/api/news/' + news.id).then(() => {
                this.$emit('newsListUpdate');
            })
        },
        handleEdit(news) {
            this.showForm = true;
            this.editNews = news;
        },
        handleCreate() {
            this.showForm = true;
            this.editNews = {};
        },
        handleSave(news) {
            this.showForm = false;

            if (!!news.id) {
                axios.put('/api/news/' + news.id, news).then(() => {
                    this.$emit('newsListUpdate');
                });
            } else {
                axios.post('/api/news', news).then(() => {
                    this.$emit('newsListUpdate');
                });
            }
        },

    }
}
</script>

<style scoped>

</style>
