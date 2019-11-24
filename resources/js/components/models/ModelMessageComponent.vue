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
                <div id="demo" :style="{height: bodyH+'px','overflow-y': 'scroll'}" class="modal-body demo" v-chat-scroll="{always: true, smooth: false, scrollonremoved:true}">
                    <div v-for="message in history"
                            :key="message.num"
                    >
                        <!-- anther -->
                        <div v-if="message.receiver_id != id" class="row justify-content-start">
                            <div class="col-auto">
                                <span>{{receiver}}</span>:<p class="bg-info text-white mr-5 p-2 rounded">{{message.content}}</p>
                            </div>
                        </div>
                        <!-- Mychat -->
                        <div v-if="message.receiver_id == id" class="row justify-content-end">
                            <div class="col-auto">
                                <p class="bg-secondary text-white ml-5 p-2 rounded">{{message.content}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- loading -->
                  <loading :active.sync="isLoading" 
                  :can-cancel="true" 
                  :on-cancel="onCancel"
                  :is-full-page="fullPage"></loading>
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
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    name:'ModelMessage',
    components: { Loading },
    props:[
        'id',
        'receiver',
        'senderId'
    ],
    data () {
        return {
            bodyH: '',
            history: [],
            messages:'',
            form: new Form({
                sender:this.senderId,
                receiver:this.id,
                content:''
            }),
            //loading
            isLoading: false,
            fullPage: true
        }
    },
    computed:{
        sendable(){
            if(!this.form.content) return true
            return false
        }
    },
    methods: {

        scrollToBottom() {
            setTimeout(function(){ console.log(document.getElementsByClassName('demo')) }, 3000);
           
            $('#myModal').on('show.bs.modal', function (e) {
                console.log('show')
            })
            
            
        },
        modelHeight(){
            const height = window.innerHeight;
            this.bodyH =  height-(height/2);
            
        },
        gethistory(){
            axios.get('/v1/message/one=' + this.form.receiver +'/two=' + this.form.sender)
                            .then(response => {
                                
                                this.history = response.data.history;
                                
                                // console.log(response.data.history);
                            })
                            .then(response => {
                               
                            });
        },
        sendMessgae(){
            this.form.post('/v1/message',this.isLoading = true)
                .then((response)=>{
                    setTimeout(() => {
                    this.isLoading = false
                    },300)
                    this.gethistory();
                    this.form.reset();
                })
            
        },
        onCancel() { //loading pluging
              console.log('User cancelled the loader.')
            }
    },
    created(){
        this.modelHeight()
        this.gethistory()
        
        Echo.join('chatroom')
                // .here()
                // .joining()
                // .leaving()
                .listen('MessagePosted', (e) => {
                    // split data history in components  for push new message
                    if(e.message.receiver_id == this.id && e.message.sender_id == this.senderId ){
                        this.history.push(e.message)
                        
                    }else if(e.message.receiver_id == this.senderId && e.message.sender_id == this.id){
                        this.history.push(e.message)
                    }
                })
    }
}
</script>
<style lang="scss" scoped>
.modal-footer{
    display: block;
}
</style>
