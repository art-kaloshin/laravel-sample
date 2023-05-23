<template>
    <div class="card p-2 mt-3">
        <h3 v-if="!! sectionId">Edit section</h3>
        <h3 v-else>Create section</h3>

        <label class="mt-1">Name</label>
        <input v-model="sectionTitle" class="form-control">
        <label class="mt-1">Parent</label>
        <select v-model="parentId" class="form-control">
            <option value="">- clear -</option>
            <template v-for="section in sectionListFiltered">
                <option :selected="section.id === parentId" :value="section.id">{{ section.title }}</option>

                <template v-for="childSection in section.children">
                    <option :selected="childSection.id === parentId" :value="childSection.id">- {{
                            childSection.title
                        }}
                    </option>
                </template>
            </template>
        </select>

        <button class="btn btn-primary mt-1" @click="handleSave">Save</button>
        <button class="btn btn-warning mt-1" @click="handleCancel">Cancel</button>
    </div>
</template>

<script>
export default {
    name: "SectionEdit",
    props: ["section", "sectionList"],
    emits: ["saveSection", "cancelEdit"],
    data() {
        return {
            sectionTitle: this.section?.title ?? '',
            sectionId: this.section?.id,
            parentId: this.section?.parent_id ?? 0,
        }
    },
    computed: {
        sectionListFiltered() {
            return this.sectionList.filter((item) => item.id !== this.sectionId && item.parent_id !== this.sectionId);
        }
    },
    methods: {
        handleCancel() {
            this.$emit('cancelEdit');
        },
        handleSave() {
            if (this.sectionId !== this.parentId) {
                this.$emit('saveSection', {
                    id: this.sectionId,
                    title: this.sectionTitle,
                    parent_id: this.parentId
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
