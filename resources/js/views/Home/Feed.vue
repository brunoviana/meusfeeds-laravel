<template>
    <div class="p-8 w-full">
        <loading :active="isLoading" :is-full-page="true" :height="25"></loading>

        <div v-if="feed" class="flex justify-right items-center mb-10">
            <h1 class="text-3xl font-black mr-10">{{ feed.titulo }}</h1>
            <!-- <div>
                <i class="text-gray-600 w-7 inline stroke-2" data-feather="check"></i>
                <i class="text-gray-600 w-5 inline stroke-2" data-feather="rotate-cw"></i>
            </div> -->
        </div>

        <div    v-for="(artigo, index) in artigos"
                v-bind:key="index"
                class="flex border-t py-2">

                <!-- <bookmark-icon size="1x" class="text-gray-400 w-4 inline stroke-1 mr-2"></bookmark-icon> -->

            <span class="w-5 inline mr-2 cursor-pointer">
                <check-icon class="text-gray-600 stroke-1"
                            size="1.5x"
                            @click="alternarLido(artigo);">
                </check-icon>
            </span>

            <a :href="artigo.link"
                target="_blank"
                v-bind:class="{
                    'font-semibold': !artigo.lido,
                    'text-black': !artigo.lido,
                    'text-gray-400': artigo.lido
                }">

                <div class="text-sm uppercase"
                     @click="alterarParaLido(artigo);">

                    {{ artigo.titulo }}
                </div>

                <div class="text-xs mb-3"
                     @click="alterarParaLido(artigo);">

                    <clock-icon size="1x" class="text-gray-600 stroke-1 inline"></clock-icon>
                    {{ artigo.data_publicacao | moment('from', 'now', true) }}
                </div>

                <div   class="text-sm font-light"
                        @click="alterarParaLido(artigo);">

                    {{ artigo.descricao | truncate(150) }}
                </div>
            </a>
        </div>

    </div>
</template>


<script>
    import Loading from 'vue-loading-overlay';
    import { CheckIcon, BookmarkIcon, ClockIcon } from 'vue-feather-icons'

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        components: {
            CheckIcon,
            BookmarkIcon,
            ClockIcon,
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
            },

            alternarLido(artigo){
                let lido = artigo.lido == 0 ? 1 : 0;

                artigo.lido = lido;

                axios.post('/artigos/'+artigo.id+'/alterar-lido', {
                    lido: lido
                });
            },

            alterarParaLido(artigo){
                artigo.lido = 1;

                axios.post('/artigos/'+artigo.id+'/alterar-lido', {
                    lido: 1
                });
            }
        }
    }
</script>

