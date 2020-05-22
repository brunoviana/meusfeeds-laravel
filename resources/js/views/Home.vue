<template>
    <div>
        <h1>Vue Router Demo App</h1>

        <p>
            <router-link :to="{ name: 'home.index' }">Home</router-link> |
            <router-link :to="{ name: 'home.hello' }">Hello World</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>

</template>
