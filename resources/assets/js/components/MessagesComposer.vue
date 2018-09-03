<template>
    <div class="composer">
        <textarea v-model="message" @keydown.enter="send" placeholder="Write message...."></textarea>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                message: ''
            };
        },
        methods:{
            send(e){
                e.preventDefault();
                if(this.message == ''){
                    return;
                }
                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>
<style lang="scss" scoped>
    .composer{
        margin-top: 10px;

        textarea{
            width: 100%;
            resize: none;
            border: 1px solid black;
        }
    }

</style>