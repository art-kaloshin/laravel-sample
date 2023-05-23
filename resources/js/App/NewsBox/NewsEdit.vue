<template>
    <div class="modal-dialog-centered modal-dialog modal">
        <div class="modal-content">
            <div class="modal-body">
                <h3 v-if="!! newsId">Edit news</h3>
                <h3 v-else>Create news</h3>
                <label>Title</label>
                <input v-model="newsTitle" class="form-control"/>
                <label>Description</label>
                <input v-model="newsDescription" class="form-control">
                <label>Text</label>
                <textarea v-model="newsText" class="form-control"></textarea>
                <label>Sections</label><br>
                <template v-for="section in sectionList">
                    <input :checked="isChecked(section.id)" type="checkbox" @click="toggleSection(section.id)">
                    {{ section.title }} <br/>
                    <template v-for="childSection in section.children">
                        - <input :checked="isChecked(childSection.id)" type="checkbox"
                                 @click="toggleSection(childSection.id)"> {{ childSection.title }} <br/>
                    </template>
                </template>

                <button class="btn btn-primary mt-1 me-1" @click="handleSave">Save Async</button>
                <button class="btn btn-primary mt-1 me-1" @click="handleSaveSync">Save Sync</button>
                <button class="btn btn-warning mt-1" @click="handleCancel">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewsEdit",
    props: ["news", "sectionList"],
    emits: ["cancelEdit", "saveNews", "saveNewsSync"],
    data() {
        return {
            newsId: this.news?.id,
            newsTitle: this.news?.title,
            newsDescription: this.news?.description,
            newsText: this.news?.text,
            newsSections: this.news?.sections || []
        }
    },
    methods: {
        toggleSection(id) {
            if (!this.isChecked(id)) {
                this.newsSections.push({id: id});

                return;
            }

            this.newsSections = this.newsSections.filter((item) => item.id !== id);
        },
        isChecked(id) {
            return this.newsSections.filter((item) => item.id === id).length > 0;
        },
        handleCancel() {
            this.$emit('cancelEdit');
        },
        handleSave() {
            this.$emit('saveNews', {
                id: this.newsId,
                title: this.newsTitle,
                description: this.newsDescription,
                text: this.newsText,
                section: this.newsSections
            })
        },
        handleSaveSync() {
            this.$emit('saveNewsSync', {
                id: this.newsId,
                title: this.newsTitle,
                description: this.newsDescription,
                text: this.newsText,
                section: this.newsSections
            })
        }
    }
}
</script>

<style scoped>
.modal {
    left: 0;
    top: 0;
    position: fixed;
    right: 0;
    bottom: 0;
    display: flex;
}
</style>
