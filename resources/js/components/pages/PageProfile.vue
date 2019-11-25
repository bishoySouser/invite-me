<template>
<div id='profile'>
    <h4>Profile Edit</h4>
        <div class='details'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Change Profile Picture <i class="fas fa-camera-retro"></i>
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class='row'>
                            <div class="col-sm-6 text-right">
                                <img v-if='srcOutput == false' src="/img/profilePicturePlaceholder.png" class="img-responsive" height="200" width="190">
                                <img v-else :src="srcOutput" class="img-responsive" height="200" width="190">

                            </div>
                            <div class="col-sm-6">
                                <div class='position' style='position: absolute;bottom: 0px;'>
                                    <button class='btn btn-danger d-block my-2'>Delete picture</button>
                                    <input class='d-none' type="file" @change="OnFileSelected" ref="fileInput">
                                    <button class='btn btn-success d-block' @click="$refs.fileInput.click()">Upload picture</button>
                                </div>
                                <button class='btn btn-primary float-right' @click="uploadImage(3)" v-show='srcOutput != null'>Save change</button>
                            </div>
                        </div>
                    
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Edit Information <i class="fas fa-user-edit"></i>
                        </button>
                    </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Change Password <i class="fas fa-key"></i>
                        </button>
                    </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'Profile',
    props:[
        'user'
    ],
    data(){
        return{
            selectedFile: null,
            srcOutput: this.user.avatar ? '/img/profile/'+this.user.avatar : this.user.avatar
        }
    },
    methods:{
        OnFileSelected(event) {
            this.selectedFile = event.target.files[0];
            this.srcOutput = URL.createObjectURL(this.selectedFile);
            console.log(this.selectedFile); //check file
        },
        uploadImage(id){
            const fd = new FormData();
            const config = { headers: { "Content-Type": "multipart/form-data" } };
            fd.append("id", this.user.id);
            fd.append("photo_url", this.selectedFile);
            axios.post('v1/user/uploadProfilePicture', fd, config)
                .then(response => {
                   location.reload();
                });
            }
    }
}
</script>
<style lang="scss" scoped>
</style>