<template>
    <div id="modelMs" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body overflow-auto">
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                   <p>dfasd</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'ModelMessage',
    methods: {
        modelHeight(){
            let height = window.innerHeight;
            console.log(height);
        }
    },
    created(){
        this.modelHeight();
    }
}
</script>

<style lang="sass" scoped>

</style>
