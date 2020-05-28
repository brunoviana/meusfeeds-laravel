<template>
    <div class="bg-gray-100 flex-shrink-0 md:block md:w-56 lg:w-1/5 xl:w-1/6 hidden overflow-y-auto">
        <div class="my-5 mx-4 flex items-center">
            <calendar-icon size="1.5x" class="text-gray-400 w-5 inline stroke-1"></calendar-icon>
            <a href="#" @click.prevent="$router.push({ name: 'home.index' })" class="text-sm font-bold ml-4 subpixel-antialiased">Hoje</a>
        </div>

        <div class="my-5 mx-4 flex items-center">
            <bookmark-icon size="1.5x" class="text-gray-400 w-5 inline stroke-1"></bookmark-icon>
            <a href="#" @click.prevent="$router.push({ name: 'home.hello' })" class="text-sm font-bold ml-4 subpixel-antialiased">Ler depois</a>
        </div>

        <div class="my-5 mx-4">

            <div class="text-xs text-gray-400 mb-3 uppercase font-medium flex justify-between">
                <span>Feeds</span>
                <span>
                    <a href="#" @click.prevent="abrirModal">
                        [+]
                    </a>
                </span>
            </div>

            <div class="vld-parent" style="min-height: 100px;">
                <loading :active="isFeedsLoading" :is-full-page="false" :height="25"></loading>

                <div v-for="(feed, indexFeed) in feeds" v-bind:key="indexFeed">

                    <a href="#" @click.prevent="$router.push({ name: 'home.feed', params: { id: feed.id }})" class="flex justify-between items-center pl-3 mb-1">

                        <span class="truncate pr-4">
                            <img class="inline" :src="'https://www.google.com/s2/favicons?domain='+feed.dominio+'&amp;alt=feed'">
                            <span class="text-xs ml-2">{{ feed.titulo }}</span>
                        </span>

                        <span class="text-xs text-gray-500">{{ feed.nao_lidos }}</span>
                    </a>
                </div>

            </div>

        </div>

        <modal name="descobrir-feeds">
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

                <button v-on:click="fecharModal">
                    FECHAR
                </button>
            </div>
        </modal>

    </div>

</template>

<script>
    import Loading from 'vue-loading-overlay';
    import { CalendarIcon, BookmarkIcon } from 'vue-feather-icons'

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        components: {
            CalendarIcon,
            BookmarkIcon,
            Loading
        },
        data: function() {
            return {
                isModalLoading: false,
                isFeedsLoading: false,
                urlParaDescobrir: 'brunoviana.dev',
                feedsDescobertos: [],
                feeds: []
            }
        },
        mounted: function(){
            this.carregarFeeds();
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

                    this.carregarFeeds();
                    this.fecharModal();
                }.bind(this))
                .catch(function(){
                    this.isModalLoading = false;
                }.bind(this));
            },
            carregarFeeds: function(){
                this.isFeedsLoading = true;

                axios.get('/feeds')
                .then(function (response) {
                    this.feeds = response.data.data;

                    this.isFeedsLoading = false;
                }.bind(this))
                .catch(function(){
                    this.isFeedsLoading = false;
                }.bind(this));
            },
            abrirModal: function() {
                this.$modal.show('descobrir-feeds');
            },
            fecharModal: function() {
                this.$modal.hide('descobrir-feeds');
            }
        }
    }
</script>
