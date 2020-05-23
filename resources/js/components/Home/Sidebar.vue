<template>
    <div class="bg-gray-100 flex-shrink-0 md:block md:w-56 lg:w-1/5 xl:w-1/6 hidden overflow-y-auto">

    <div class="my-5 mx-4 flex items-center">
        <calendar-icon size="1.5x" class="text-gray-400 w-5 inline stroke-1"></calendar-icon>
        <a href="#" @click.prevent="$router.push({ name: 'home.hello' })" class="text-sm font-bold ml-4 subpixel-antialiased">Hoje</a>
    </div>

    <div class="my-5 mx-4 flex items-center">
        <bookmark-icon size="1.5x" class="text-gray-400 w-5 inline stroke-1"></bookmark-icon>
        <a href="#" @click.prevent="$router.push({ name: 'home.hello' })" class="text-sm font-bold ml-4 subpixel-antialiased">Ler depois</a>
    </div>

    <div class="my-5 mx-4">
        <div class="text-xs text-gray-400 mb-3 uppercase font-medium">
            Feeds
        </div>

        <a href="#" @click.prevent="$router.push({ name: 'home.index' })" class="flex justify-between items-center pl-3 mb-1">

            <span class="truncate pr-4">
                <img class="inline" src="https://www.google.com/s2/favicons?domain=medium.com&amp;alt=feed">
                <span class="text-xs ml-2">Stories by Taylor Otwell on Medium</span>
            </span>

            <span class="text-xs text-gray-500">9</span>
        </a>

        <a href="#" @click.prevent="$router.push({ name: 'home.index' })" class="flex justify-between items-center pl-3 mb-1">

            <span class="truncate pr-4">
                <img class="inline" src="https://www.google.com/s2/favicons?domain=https://littleblah.com/">
                <span class="text-xs  ml-2">Little Blah</span>
            </span>

            <span class="text-xs text-gray-500">7</span>
        </a>

        <a href="#" @click.prevent="$router.push({ name: 'home.index' })" class="flex justify-between items-center pl-3 mb-1">

            <span class="truncate pr-4">
                <img class="inline" src="https://www.google.com/s2/favicons?domain=https://thephp.website/br/">
                <span class="text-xs  ml-2">thePHP Website</span>
            </span>

            <span class="text-xs text-gray-500">9</span>
        </a>

    </div>
    <!-- <div class="mb-4">
        <a href="https://demo.inertiajs.com/" class="flex items-center group py-3">

        <div class="text-white">Dashboard</div></a></div> <div class="mb-4">
            <a href="https://demo.inertiajs.com/organizations" class="flex items-center group py-3">

            <div class="text-indigo-300 group-hover:text-white">Organizations</div></a></div>
            <div class="mb-4">
                <a href="https://demo.inertiajs.com/contacts" class="flex items-center group py-3">

                <div class="text-indigo-300 group-hover:text-white">Contacts</div></a></div>
                <div class="mb-4">
                    <a href="https://demo.inertiajs.com/reports" class="flex items-center group py-3">

        <div class="text-indigo-300 group-hover:text-white">Reports</div></a></div> -->

    </div>

</template>

<script>
    import { CalendarIcon, BookmarkIcon } from 'vue-feather-icons'
    export default {
        components: {
            CalendarIcon,
            BookmarkIcon
        }
    }
</script>
