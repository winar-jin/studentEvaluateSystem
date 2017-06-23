<template>
    <div class="container">
    sth
        
            <p>username: <input type="text" name="username" v-model="username" /></p>
            <p>password: <input type="text" name="password" v-model="password"/></p>
            <input type="button" value="Submit" @click="register" />
        
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                username:'',
                password:''
            }
        },
        methods: {
            register: function(){
                axios.post('login', {
                username: this.username,
                password: this.password
            })
            .then(function (response) {
                console.log('Register success');
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
            }
        }
    }
</script>
