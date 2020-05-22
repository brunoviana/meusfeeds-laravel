<template>
    <div>
        <h1>Vue Router Demo App</h1>

        <p>
            <router-link :to="{ name: 'home.index' }">Home</router-link> |
            <router-link :to="{ name: 'home.hello' }">Hello World</router-link> |
            <a href="#" v-if="$auth.check()" @click.prevent="logout()">Logout</a>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>

</template>

<script>
    export default {
        methods: {
            logout() {
                this.$auth
                    .logout({
                        makeRequest: true,
                        redirect: {name: 'login'},
                    });
            }
        }
    }
</script>

