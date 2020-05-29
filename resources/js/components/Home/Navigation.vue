<template>
    <nav class="md:flex flex-shrink-0">
        <div class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center">

            <div class="md:flex-shrink-0 py-4 flex">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8" src="/img/logos/workflow-mark-on-dark.svg" alt="" />
                </div>
            </div>

            <!-- Menu -->
            <div class="flex items-center">
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline">

                    </div>
                </div>
            </div>

            <!-- Sininho com fotinha -->
            <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
                <div v-on-clickaway="close" class="ml-3 relative">
                <div>
                    <button v-on:click="open = !open" class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid">
                    <img class="h-8 w-8 rounded-full" src="https://lh3.googleusercontent.com/a-/AOh14GiV-6sGJocWh7ik0npt-7IaLlyjQAWF6EF17Y8rCaU" alt="" />
                    </button>
                </div>

                <div v-if="open" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                    <div class="py-1 rounded-md bg-white shadow-xs">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <a href="#" @click.prevent="logout()" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                    </div>
                </div>
                </div>
            </div>
            </div>

        </div>
  </nav>

</template>

<script>
    import { mixin as clickaway } from 'vue-clickaway';
    export default {
        mixins: [ clickaway ],
        data() {
            return {
                open: false
            }
        },
        methods: {
            close: function(){
                this.open = false;
            },
            logout: function() {
                this.$auth
                    .logout({
                        makeRequest: true,
                        redirect: {name: 'login'},
                    });
            }
        }
    }
</script>
