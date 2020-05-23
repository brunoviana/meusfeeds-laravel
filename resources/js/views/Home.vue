<template>
    <div class="h-screen flex flex-col">
        <Navigation />

        <main class="flex flex-grow overflow-hidden">
            <Sidebar />
            <router-view></router-view>
        </main>
    </div>


</template>

<script>
    import Navigation from '../components/Home/Navigation';
    import Sidebar from '../components/Home/Sidebar';

    export default {
        name: 'Home',
        components: {
            Navigation,
            Sidebar
        }
    }
</script>

