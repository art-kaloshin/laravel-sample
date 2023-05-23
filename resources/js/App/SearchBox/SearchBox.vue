<template>
    <div class="row mb-2 text-bg-light pt-3 pb-3 rounded-3 d-flex">
        <div class="col flex-grow-1">
            <input class="form-control" v-model="searchString">
        </div>
        <div class="col flex-grow-0 flex-nowrap d-flex">
            <button class="btn btn-primary me-1" @click="handleSearch">Search</button>
            <button class="btn btn-warning" @click="searchString = ''">Clear</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchBox",
    emits: ["search", "searchPost"],
    data() {
        return {
            searchString: '',
        }
    },
    methods: {
        handleSearch() {
            this.$emit('searchPost', this.searchString);
        }
    },
    watch: {
        searchString() {
            this.$emit('search', this.searchString);
        }
    }
}
</script>

<style scoped>

</style>
