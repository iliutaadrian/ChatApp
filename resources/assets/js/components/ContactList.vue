<template>
    <div class="contact-list">
        <ul>
            <li v-for="(contact, index) in contacts" :key="contact.id" @click="selectContact(index, contact)" :class="{ 'selected':  index == selected}" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="avatar">
                            <img :src="contact.profile_image" alt="contact.name">
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="contact">
                            <p class="name">{{ contact.name }}</p>
                            <p class="email">{{ contact.email }}</p>
                        </div>
                    </div>
                </div>




            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props:{
            contacts:{
                type: Array,
                default: []
            }
        },
        data(){
            return{
                selected: 0
            };
        },
        methods:{
            selectContact(index, contact){
                this.selected = index;
                this.$emit('selected', contact);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contact-list{
        height: 600px;
        overflow: scroll;
        border-right: 1px solid gray;

        ul{
            padding-left: 0;
            list-style-type: none;

            .selected{
                background-color: #e0e0e0;
            }

            li{
                padding: 2px;
                border-bottom: 1px solid gray;
                height: 90px;
                cursor: pointer;



                .avatar{
                    padding-left: 1px;
                    padding-top: 9px;
                    img{
                        height: 70px;
                        border-radius: 50%;
                    }
                }

                .contact{
                    padding-left: 3px;

                    .name{
                        margin: 0;
                        padding-top: 19px;
                        font-size: 17px;
                    }

                    .email{
                        font-size: 12px;
                    }
                }
            }
        }


    }
</style>