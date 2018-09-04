<template>
    <div class="chat-app">
        <div class="row">
            <div class="col-md-4">
                <ContactList :contacts="contacts" :onlineUsers="onlineUsers" @selected="startConversationWith"/>
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
                contacts: [],
                onlineUsers: [],
            }
        },
        mounted() {
            Echo.private('messages.' + this.user.id)
                .listen('NewMessage', (e) => {
                this.handleIncoming(e.message);
            });

            axios.get('/contacts')
                .then((response) => {
                    this.contacts = response.data;
            });

            Echo.join('online')
                .here((users)=>{
                    this.onlineUsers = users;
                })
                .joining((user)=>{
                    this.onlineUsers.push(user);
                })
                .leaving((user) =>{
                    this.onlineUsers = this.onlineUsers.filter((u) => {
                        u != user
                    });
                });
        },
        methods:{
            startConversationWith(contact){
                axios.get('/conversation/'+ contact.id)
                    .then((response)=>{
                    this.messages = response.data;
                    this.selectedContact = contact;
                });
                this.updateUnreadCount(contact, 1);
            },
            saveNewMessage(message){
                this.messages.push(message);
            },
            handleIncoming(message){
                if(this.selectedContact && message.from == this.selectedContact.id){
                    this.saveNewMessage(message);
                    return;
                }
                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset){
                this.contacts = this.contacts.map((single)=>{
                    if(single.id != contact.id){
                        return single;
                    }
                    if(reset){
                        single.unread = 0;
                    }
                    else{
                        single.unread += 1;
                    }

                    return single;
                });
            }
        },
        components: {Conversation, ContactList}
    }
</script>
