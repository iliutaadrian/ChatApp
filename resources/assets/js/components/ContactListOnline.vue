<template>

    <div class="online" v-if="checkUserOnline()"></div>
    <div class="ofline" v-else></div>

</template>

<script>
    export default {
        props:{
            onlineUsers: {
                type: Array,
                default: []
            },
            contact:{
                type: Object,
                default: null
            }
        },
        methods:{
            checkUserOnline(){
                console.log(this.onlineUsers);
                return _.find(this.onlineUsers, {id: this.contact.id});
            }
        }
    }
</script>

<style lang="scss" scoped>
    .ofline {
        background-color: red;
        width: 16px;
        height: 16px;
        position: relative;
        border: 1px solid gray;
        border-radius: 50%;
        left: 50px;
        bottom: 18px;
    }

    .online {
        background-color: #00ff54;
        width: 16px;
        height: 16px;
        position: relative;
        border: 1px solid gray;
        border-radius: 50%;
        left: 50px;
        bottom: 18px;
    }
</style>