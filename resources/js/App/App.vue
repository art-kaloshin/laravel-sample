<template>
    <div class="row">
        <div class="col-12">
            <h1>Super news portal!</h1>
        </div>
    </div>

    <SearchBox @search="handleSearch" @search-post="handleSearchPost"></SearchBox>

    <div class="row">
        <div class="col-sm-12 col-md-8">
            <Loader v-if="!loaded" />
            <NewsBox v-if="loaded" :news-list="newsList" :section-list="sectionList" @news-list-update="handleUpdateNewsList"></NewsBox>
            <Pagination v-if="loaded" :links="pages" @page-select="handleChangePage"></Pagination>
        </div>
        <div class="col col-sm-12 col-md-4">
            <SectionBox :current-section="currentSection" :section-list="sectionList"
                        @section-list-update="handleUpdateSectionList"
                        @section-select="handleSectionSelect"></SectionBox>
        </div>
    </div>
</template>

<script>
import SearchBox from "./SearchBox/SearchBox.vue";
import NewsBox from "./NewsBox/NewsBox.vue";
import SectionBox from "./SectionBox/SectionBox.vue";
import Pagination from "./NewsBox/Pagination.vue";
import Loader from "./Loader/Loader.vue";

export default {
    name: "App",
    components: {Loader, Pagination, SectionBox, NewsBox, SearchBox},
    data() {
        return {
            newsUrl: '/api/news',
            sectionUrl: '/api/section',
            page: 1,
            loaded: false,
            currentSection: 0,
            searchString: '',
            sectionList: [],
            newsList: [],
            pages: []
        }
    },
    methods: {
        handleSearch(search) {
            this.searchString = search;
            this.loadNews(this.newsUrl);
        },
        handleSearchPost(search) {
            this.searchString = search;

            axios.post(this.newsUrl + '/search', {
                section: this.currentSection,
                search: this.searchString
            }).then((r) => {
                this.newsList = r.data.data;
                this.pages = r.data.meta.links;
                this.loaded = true;
            });
        },
        handleSectionSelect(id) {
            this.currentSection = id;
            this.loadNews(this.newsUrl);
        },
        handleUpdateNewsList() {
            this.loadNews(this.newsUrl);
        },
        handleUpdateSectionList() {
            this.loadSections(this.sectionUrl);
        },
        handleChangePage(url) {
            this.loadNews(url);
        },
        loadNews(url) {
            this.loaded = false;

            (url.indexOf('?') < 0) && (url = url + '?');
            (this.currentSection > 0) && (url = url + '&section=' + this.currentSection);
            (this.searchString !== '') && (url = url + '&search=' + this.searchString);

            axios.get(url).then((r) => {
                this.newsList = r.data.data;
                this.pages = r.data.meta.links;
                this.loaded = true;
            });
        },
        loadSections(url) {
            axios.get(url).then((r) => {
                this.sectionList = r.data.data;
            });
        }
    },
    mounted () {
        this.loadNews(this.newsUrl);
        this.loadSections(this.sectionUrl);
    }
}
</script>

<style scoped>
    body {
        background-color: white;
    }
</style>
