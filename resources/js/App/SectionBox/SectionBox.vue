<template>
    <h2 class="border-bottom border-primary pb-2">
        Categories
        <button class="btn btn-primary float-end btn-sm" @click="handleCreate">Create</button>
    </h2>

    <SectionElement
        v-for="section in sectionList"
        :section="section"
        @section-edit="handleEdit"
        @section-delete="handleDelete"
        @section-select="handleSectionSelect"
    />

    <SectionEdit v-if="showForm" :key="editSection" :section-list="sectionList" :section="editSection" @save-section="handleSaveSection" @cancel-edit="handleCancel"></SectionEdit>
</template>

<script>
import SectionEdit from "./SectionEdit.vue";
import SectionElement from "./SectionElement.vue";
export default {
    name: "SectionBox",
    components: {SectionElement, SectionEdit},
    props: ["sectionList"],
    emits: ["sectionSelect", "sectionListUpdate"],
    data() {
        return {
            showForm: false,
            editSection: {},
        }
    },
    methods: {
        handleCreate() {
            this.editSection = {};
            this.showForm = true;
        },
        handleEdit(section) {
            this.editSection = section;
            this.showForm = true;
        },
        handleCancel() {
            this.showForm = false;
        },
        handleSaveSection(section) {
            this.showForm = false;

            if (!!section.id) {
                axios.put('/api/section/' + section.id, section).then(() => {
                    this.$emit('sectionListUpdate');
                });
            } else {
                axios.post('/api/section', section).then(() => {
                    this.$emit('sectionListUpdate');
                });
            }
        },
        handleDelete(section) {
            axios.delete('/api/section/' + section.id).then((r) => {
                this.$emit('sectionListUpdate');
            });
        },
        handleSectionSelect(section) {
            this.$emit('sectionSelect', section.id);
        }
    }
}
</script>

<style lang="scss">
    .link-info {
        cursor: pointer;
    }
    .sectionList {
        div {
            margin-left: 15px;
        }
    }
</style>
