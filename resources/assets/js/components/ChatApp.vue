<template>
    <div class="chat-app">
        <div class="row">
            <div class="col-md-4">
                <ContactList :contacts="contacts" @selected="startConversationWith"/>
            </div>
            <div class="col-md-8">
                <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
            </div>
        </div>
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactList from './ContactList';


    export default {
        props: {
          user:{
              type: Object,
              required: true
          }
        },
        data(){
            return{
                selectedContact: null,
                messages: [],
                contacts: []
            }
        },
        mounted() {
            Echo.private('messages${this.user.id}')
                .listen('NewMessage', (e) => {
                this.handleIncoming(e.message);
            });

            axios.get('/contacts')
                .then((response) => {
                    this.contacts = response.data;
            });
        },
        methods:{
            startConversationWith(contact){
                axios.get(`/conversation/${contact.id}`)
                    .then((response)=>{
                    this.messages = response.data;
                    this.selectedContact = contact;
                })
            },
            saveNewMessage(text){
                this.messages.push(text);
            },
            handleIncoming(message){
                if(this.selectedContact && message.from == this.selectedContact.id){
                    this.saveNewMessage(message);
                    return;
                }
            }
        },
        components: {Conversation, ContactList}
    }
</script>
