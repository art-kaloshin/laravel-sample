<template>
    <div class="text-center">
        <a v-for="link in links" @click.prevent="handlePageClick(link)" :href="link.url" v-html="link.label" class="p-2" :class="{'text-black': link.active}"></a>
    </div>
</template>

<script>
export default {
    name: "Pagination",
    props: ["links"],
    emits: ["pageSelect"],
    methods: {
        handlePageClick(link) {
            ! link.active && this.$emit('pageSelect', link.url);
        }
    }
}
</script>

<style scoped>
    .text-black {
        text-decoration: none;
        font-weight: bold;
    }
</style>
