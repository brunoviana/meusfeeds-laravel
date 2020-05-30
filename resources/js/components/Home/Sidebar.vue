<template>
    <div class="bg-gray-100 flex-shrink-0 md:block md:w-56 lg:w-1/5 xl:w-1/6 hidden overflow-y-auto">
        <div class="my-5 mx-4 flex items-center">
            <calendar-icon size="1.5x" class="text-gray-400 w-5 inline stroke-1"></calendar-icon>
            <a href="#" @click.prevent="$router.push({ name: 'home.index' })" class="text-sm font-bold ml-4 subpixel-antialiased">Hoje</a>
        </div>

        <!-- <div class="my-5 mx-4 flex items-center">
            <bookmark-icon size="1.5x" class="text-gray-400 w-5 inline stroke-1"></bookmark-icon>
            <a href="#" @click.prevent="$router.push({ name: 'home.hello' })" class="text-sm font-bold ml-4 subpixel-antialiased">Ler depois</a>
        </div> -->

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

    </div>

</template>

<script>
    import DescobrirFeeds from './DescobrirFeeds';
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
                isFeedsLoading: false,
                feeds: [],
                painelDescobrirFeeds: null,
            }
        },
        mounted: function(){
            this.carregarFeeds();
        },
        methods: {
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
                this.painelDescobrirFeeds = this.$showPanel({
                    component : DescobrirFeeds,
                    openOn: 'right',
                    props: {
                        '$sidebar': this
                    }
                });

                // panel1Handle.promise
                // .then(result => {

                // });
            },
            // fecharModal: function() {
            //     this.painelDescobrirFeeds.hide()
            // }
        }
    }
</script>
