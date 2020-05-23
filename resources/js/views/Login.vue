<template>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="mb-12">
                <img class="mx-auto h-12 w-auto" src="/img/logos/workflow-mark-on-white.svg" alt="Workflow" />
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Faça login para acessar seus feeds
                </h2>
            </div>

            <div class="flex justify-center">


                <GoogleLogin :params="params"
                            :onSuccess="onSuccess"
                            :onFailure="onFailure">

                    <span class="w-64 flex py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        <img src="https://feedly.com/images/login-google@2x.png" class="w-6 mr-3" />
                        Continuar com Google
                    </span>

                </GoogleLogin>
            </div>
        </div>
    </div>

</template>

<script>
    import GoogleLogin from 'vue-google-login';
    export default {
        name: 'Login',
        data() {
            return {
                // client_id is the only required property but you can add several more params, full list down bellow on the Auth api section
                params: {
                    client_id: "613936141640-sqfhsj0krs1b18llnvm6set4afe4regj.apps.googleusercontent.com"
                },
                // only needed if you want to render the button with the google ui
                renderParams: {
                    width: 250,
                    height: 50,
                    longtitle: true
                }
            }
        },
        methods: {
            onSuccess: function(googleUser){
                let profile = googleUser.getBasicProfile();

                this.$auth.login({
                    params: {
                        nome: profile.getName(),
                        email: profile.getEmail(),
                        foto: profile.getImageUrl()
                    },
                    success: function () {},
                    error: function () {},
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                });

                console.debug(profile.getName());
                console.debug(profile.getEmail());
                console.debug(profile.getImageUrl());
            },
            onFailure: function(){
                alert('Tente novamente')
            }
        },
        components: {
            GoogleLogin
        }
    }
</script>
