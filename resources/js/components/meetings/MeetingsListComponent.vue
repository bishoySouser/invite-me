<template>
    <div id="meeting-list">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col">time</th>
                <th scope="col" colspan="3" class="text-center">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>
                        <button>dsa</button>
                    </td>
                    <td>
                        <button>dsa</button>
                    </td>
                    <td>
                        <button>dsa</button>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name:'meetingList',
    props:[
        'owerid'
    ],
    data () {
        return{
            list: []
        }
    },
    methods:{
        getMeetingList(){
            axios.get('/v1/meeting/'+this.owerid)
            .then((res) => {
                this.list = res.data.list
            })
        }
    },
    created(){
        
    }
    
}
</script>

<style lang="scss" scoped>

</style>