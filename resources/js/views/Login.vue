<template>

    <div>
        <p>Login</p>
        <GoogleLogin :params="params"
                    :renderParams="renderParams"
                    :onSuccess="onSuccess"
                    :onFailure="onFailure">
        </GoogleLogin>
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
