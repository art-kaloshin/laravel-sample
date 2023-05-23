<template>
    <div :key="section.id" class="sectionList clearfix mb-1">
        <span :class="{active: currentSection === section.id}" class="link-info"
              @click.prevent="handleSectionSelect(section)">{{ section.title }}</span>
        <button class="btn btn-primary btn-sm mx-1 float-end" @click="handleEdit(section)">Edit</button>
        <button class="btn btn-danger btn-sm mx-1 float-end" @click="handleDelete(section)">Delete</button>

        <div class="clearfix mb-1"></div>
        <SectionElement
            v-for="childSection in section.children"
            :section="childSection"
            :current-section="currentSection"
            @section-edit="handleEdit"
            @section-delete="handleDelete"
            @section-select="handleSectionSelect"
        />

    </div>
</template>

<script>
export default {
    name: "SectionElement",
    props: ["section", "currentSection"],
    emits: ["sectionSelect", "sectionEdit", "sectionDelete"],
    methods: {
        handleSectionSelect(section) {
            this.$emit('sectionSelect', section);
        },
        handleEdit(section) {
            this.$emit('sectionEdit', section);
        },
        handleDelete(section) {
            this.$emit('sectionDelete', section);
        }
    }
}
</script>

<style scoped>
.active {
    font-weight: bold;
}
</style>
