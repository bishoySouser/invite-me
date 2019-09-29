<template>
    <div :id="'modelMs'+id" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{receiver}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="massage-body" :style="{height: bodyH+'px'}" class="modal-body overflow-auto">
                    <div v-for="message in history"
                            :key="message.num"
                    >

                        <div v-if="message.receiver_id != id" class="row justify-content-start">
                            <div class="col-auto">
                                <p class="bg-info text-white mr-5 p-2 rounded"> {{message.content}}</p>
                            </div>
                        </div>

                        <div v-if="message.receiver_id == id" class="row justify-content-end">
                            <div class="col-auto">
                                <p class="bg-secondary text-white ml-5 p-2 rounded">{{message.content}}</p>
                            </div>
                        </div>
                    </div>
                    <div id="end"></div>
                </div>
                <div class="modal-footer">
                    <form action="" @submit.prevent="sendMessgae">
                        <div class="form-group">
                            <label for="Messgae">Message:</label>
                            <input type="text" v-model="form.content" class="form-control" id="Messgae" placeholder="Write your message..">
                        </div>
                    <button type="submit" class="btn btn-primary float-right" :disabled="sendable">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'ModelMessage',
    props:[
        'id',
        'receiver',
        'senderId'
    ],
    data () {
        return {
            bodyH: '',
            history: [],
            form: new Form({
                sender:this.senderId,
                receiver:this.id,
                content:''
            })
        }
    },
    computed:{
        sendable(){
            if(!this.form.content) return true
            return false
        }
    },
    methods: {
        scrollToEnd() {
				var container = document.querySelector(".modal-body");
				var scrollHeight = container.scrollHeight;
				container.scrollTop = scrollHeight;
		},
        modelHeight(){
            const height = window.innerHeight;
            this.bodyH =  height-(height/2);
        },
        gethistory(){
            axios.get('api/v1/message/one=' + this.form.receiver +'/two=' + this.form.sender)
                            .then(response => {

                                this.history = response.data.history;
                                console.log(response.data.history);
                            });
        },
        sendMessgae(){
            this.form.post('api/v1/message')
                .then((response)=>{
                    
                    this.gethistory();
                    this.form.reset();
                })
            
        }
    },
    created(){
        this.modelHeight();
        window.addEventListener('scroll', this.handleScroll);
        
    }
}
</script>
<style lang="scss" scoped>
.modal-footer{
    display: block;
}
</style>
