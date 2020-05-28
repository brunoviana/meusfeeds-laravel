<template>
    <div class="p-8 overflow-y-auto">
        <loading :active="isLoading" :is-full-page="true" :height="25"></loading>

        <div v-if="feed" class="flex justify-right items-center">
            <h1 class="text-3xl font-black mr-10">{{ feed.titulo }}</h1>
            <div>
                <i class="text-gray-600 w-7 inline stroke-2" data-feather="check"></i>
                <i class="text-gray-600 w-5 inline stroke-2" data-feather="rotate-cw"></i>
            </div>
        </div>

        <div v-for="(artigo, index) in artigos" v-bind:key="index">
            <a :href="artigo.link" target="_blank" class="flex border-t py-2">
                <bookmark-icon size="1x" class="text-gray-400 w-4 inline stroke-1 mr-2"></bookmark-icon>
                <check-icon size="1x" class="text-gray-600 w-5 inline stroke-1 mr-2"></check-icon>

                <span class="text-sm text-gray-400 flex-none mr-2">{{ artigo.titulo }}</span>
                <span class="text-sm text-gray-400 font-light mr-2 truncate">{{ artigo.descricao }}</span>
                <span class="text-xs text-gray-400">{{ artigo.data_publicacao | moment('from', 'now', true) }}</span>
            </a>
        </div>

    </div>
</template>


<script>
    import Loading from 'vue-loading-overlay';
    import { CheckIcon, BookmarkIcon } from 'vue-feather-icons'

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        components: {
            CheckIcon,
            BookmarkIcon,
            Loading
        },
        data: function() {
            return {
                isLoading: false,
                feed: null,
                artigos: []
            }
        },
        mounted: function(){
            this.carregarFeed();
        },
        watch: {
            '$route.params.id': function (id) {
                this.carregarFeed();
            }
        },
        methods: {
            carregarFeed: function(){
                this.isLoading = true;
                this.feed = null;
                this.artigos = [];

                axios.get('/feeds/'+this.$route.params.id)
                .then(function (response) {
                    this.feed = response.data.data;

                    this.carregaArtigos();
                }.bind(this))
                .catch(function(){
                    this.isLoading = false;
                }.bind(this));
            },

            carregaArtigos: function(){
                this.isLoading = true;

                axios.get('/feeds/'+this.$route.params.id+'/artigos')
                .then(function (response) {
                    this.artigos = response.data.data;

                    this.isLoading = false;
                }.bind(this))
                .catch(function(){
                    this.isLoading = false;
                }.bind(this));
            }
        }
    }
</script>

