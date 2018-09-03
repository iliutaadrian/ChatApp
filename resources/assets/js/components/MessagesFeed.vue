<template>
    <div class="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :class="`message${message.to == contact.id ? 'sent' : 'received' }`" :key="message.id">
                <div class="text">
                    {{ message.text }}
                </div>
            </li>

        </ul>
    </div>
</template>

<script>
    export default {
        props:{
            contact:{
                type: Object
            },
            messages:{
                type: Array,
                required: true
            }
        },
        methods: {
            scrollToBottom(){
                setTimeout(()=>{
                    $('.feed').scrollTop($('.feed ul').height() + 20);
                }, 50);

            }
        },
        watch:{
            contact(contact){
                this.scrollToBottom();
            },
            messages(messages){
                this.scrollToBottom();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .feed{
        height: 490px;
        overflow: scroll;
        background-color: #f1f1f1;

        ul {
            padding-left: 0;
            list-style-type: none;

            li.messagesent{
                background-color: #dadada;
                width: 300px;
                text-align: justify;
                padding: 5px;
                border-radius: 6px;

                margin-bottom: 5px;
                margin-top: 5px;

                margin-left: 270px;
            }

            li.messagereceived{
                background-color: darkgrey;
                width: 300px;
                text-align: justify;
                padding: 5px;
                border-radius: 6px;

                margin-bottom: 5px;
                margin-top: 5px;

                margin-left: 4px;
            }
        }
    }
</style>