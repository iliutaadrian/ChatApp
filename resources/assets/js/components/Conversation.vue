<template>
    <div class="conversation">
        <div class="row">
            <div class="col-md-12">
                <h1>{{contact ? contact.name : "Select a contact" }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <MessagesFeed :contact="contact" :messages="messages"/>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <MessagesComposer @send="sendMessage"/>
            </div>
        </div>
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessagesComposer from './MessagesComposer';

    export default {
        props:{
            contact:{
                type: Object,
                default: null
            },
            messages:{
                type: Array,
                default: []
            }
        },
        methods:{
            sendMessage(text){
                if(!this.contact){
                    return;
                }
                axios.post('/conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response)=>{
                    this.$emit('new', response.data);
                })
            }
        },
        components: {MessagesFeed, MessagesComposer}
    }
</script>

<style lang="scss" scoped>
    h1{
        background-color: #e0e0e0;
        text-align: center;
    }
</style>
