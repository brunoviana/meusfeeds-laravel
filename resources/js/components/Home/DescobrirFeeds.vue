<template>
  <div class="h-full overflow-y-scroll">
        <loading :active="isModalLoading" :is-full-page="false" :height="25"></loading>

        <input type="text" v-model="urlParaDescobrir" class="border-2" />
        <button v-on:click="descobrir">
            DESCOBRIR
        </button>

        <ul v-for="(feedDescoberto, index) in feedsDescobertos" v-bind:key="index">
            <li>
                <div><strong>{{ feedDescoberto.titulo }}</strong></div>
                <div><em>{{ feedDescoberto.descricao }}</em></div>
                <div v-for="(artigo, index2) in feedDescoberto.ultimos_artigos" v-bind:key="index2">
                    <span>- {{ artigo }}</span>
                </div>
                <button v-on:click="adicionarFeed(feedDescoberto)">
                    SEGUIR
                </button>
            </li>
        </ul>

        <button v-on:click="fechar">
            FECHAR
        </button>
    </div>
</template>
<script>
    import Loading from 'vue-loading-overlay';

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        components: {
            Loading
        },
        props: ['$sidebar'],
        data: function() {
            return {
                isModalLoading: false,
                feedDescoberto: [],
                urlParaDescobrir: 'brunoviana.dev',
                feedsDescobertos: [],
            }
        },
        mounted: function(){

        },
        methods: {
            descobrir: function(){
                this.isModalLoading = true;
                this.feedsDescobertos = [];

                axios.post('/feeds/descobrir', {
                    'url': this.urlParaDescobrir
                })
                .then(function (response) {
                    this.feedsDescobertos = response.data.data;

                    this.isModalLoading = false;
                }.bind(this))
                .catch(function(){
                    this.isModalLoading = false;
                }.bind(this));
            },
            adicionarFeed: function(feed){
                this.isModalLoading = true;

                axios.post('/feeds', {
                    'titulo': feed.titulo,
                    'link_rss': feed.link_rss
                })
                .then(function (response) {
                    this.isModalLoading = false;

                    this.$sidebar.carregarFeeds();
                    this.fechar();
                }.bind(this))
                .catch(function(){
                    this.isModalLoading = false;
                }.bind(this));
            },
            fechar: function(){
                this.$emit('closePanel', {});
            }
        }
    }
</script>
