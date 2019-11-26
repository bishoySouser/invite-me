<template>
<div id='profile'>
    <h4>Profile Edit</h4>
        <div class='details'>
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Change profile picture <i class="fas fa-camera-retro"></i>
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class='row'>
                            <div class="col-sm-6 text-right">
                                <img v-if='srcOutput == null' src="/img/profilePicturePlaceholder.png" class="img-responsive rounded-circle" height="200" width="190">
                                <img v-else :src="srcOutput" class="img-responsive rounded-circle" height="200" width="190">

                            </div>
                            <div class="col-sm-6">
                                <div class='position' style='position: absolute;bottom: 0px;'>
                                    <button class='btn btn-danger d-block my-2' @click="deleteImage()" v-if='srcOutput != null'>Delete picture</button>
                                    <input class='d-none' type="file" @change="OnFileSelected" ref="fileInput">
                                    <button class='btn btn-success d-block' @click="$refs.fileInput.click()">Upload picture</button>
                                </div>
                                <button class='btn btn-primary float-right' @click="uploadImage()" v-show='saveButton' :disabled='uploaded'>
                                    Save change
                                    <div class="spinner-border text-light" role="status" v-show="uploaded">
                                        <span class="sr-only">Save change</span>
                                    </div>
                                </button>
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
                                <label for="inputFirstName">First Name</label>
                                <input type="text" class="form-control" id="inputFirstName" v-model="firstName" placeholder="First name" maxlength="30">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputLastName">Last Name</label>
                                <input type="text" class="form-control" id="inputLastName" v-model="LastName" placeholder="Last name" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="inputCompany">Company Name</label>
                                <input type="text" class="form-control" id="inputCompany" v-model="companyName" placeholder="Company name" maxlength="30">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCountry">Country</label>
                                <select name="country" class="form-control" id="inputCountry" v-model='country'>
                                    <option value="choose" hidden>choose</option>
                                    <option v-for='country in Countries' :key='country.index'>{{country.name}}</option>
                                </select>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-sm-12 text-right">
                            <button type="button" @click='editInfo()' class="btn btn-primary">Save change</button>
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
                            Change your password <i class="fas fa-key"></i>
                        </button>
                    </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <blockquote class="blockquote">
                                <p class="mb-0">A strong password helps prevent unauthorized access to your email account</p>
                            </blockquote>
                            
                                <div class="form-group">
                                    <label for="oldPassword" class='col-sm-3'>Current password</label>
                                    <input :type="typePassword" class="form-control col-sm-4 d-inline" id="oldPassword" placeholder="old password">
                                    <button @click="showPassword()" v-html="eyaPassword" style="background: none;border: 0px;color: #007bff;button:focus {outline:0 !important;}">{{eyaPassword}}</button>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword" class='col-sm-3'>New password</label>
                                    <input :type="typeNewPassword" class="form-control col-sm-4 d-inline" id="newPassword" placeholder="new password">
                                    <button @click="showNewPassword()" v-html="eyaNewPassword" style="background: none;border: 0px;color: #007bff">{{eyaNewPassword}}</button>
                                </div>
                                <div class="form-group">
                                    <label for="againPassword" class='col-sm-3'>Re-enter new password</label>
                                    <input type="password" class="form-control col-sm-4 d-inline" id="againPassword" placeholder="reenter password">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-primary">Change password</button>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Country from "../../countryList.json"
export default {
    name:'Profile',
    props:[
        'user'
    ],
    data(){
        return{
            selectedFile: null,
            srcOutput: this.user.avatar ? '/img/profile/'+this.user.avatar : this.user.avatar,
            saveButton: false,
            uploaded: false,
            Countries: Country,
            eyaPassword: '<i class="fas fa-eye-slash">',
            typePassword: 'password',
            eyaNewPassword: '<i class="fas fa-eye-slash">',
            typeNewPassword: 'password',
            //information
            firstName: this.user.first_name ? this.user.first_name : '',
            LastName: this.user.last_name ? this.user.last_name : '',
            companyName: this.user.companyName ? this.user.companyName : '',
            country: this.user.country ? this.user.country : 'choose',
        }
    },
    computed:{
        
    },
    methods:{
        OnFileSelected(event) {
            this.selectedFile = event.target.files[0];
            this.srcOutput = URL.createObjectURL(this.selectedFile);
            this.saveButton = true;
            console.log(this.selectedFile); //check file
        },
        uploadImage(){
            const fd = new FormData();
            const config = { headers: { "Content-Type": "multipart/form-data" } };
            fd.append("id", this.user.id);
            fd.append("photo_url", this.selectedFile);
            axios.post('v1/user/uploadProfilePicture', fd, config)
                .then(response => {
                    this.uploaded = true;
                   location.reload();
                });
        },
        deleteImage(){
            const fd = new FormData();
            const config = { headers: { "Content-Type": "multipart/form-data" } };
            fd.append("id", this.user.id);
            axios.post('v1/user/uploadProfilePicture', fd, config)
                .then(response => {

                   location.reload();
                });
        },
        showPassword(){
            this.eyaPassword = this.eyaPassword === '<i class="fas fa-eye-slash">' ? '<i class="fas fa-eye">' : '<i class="fas fa-eye-slash">'
            this.typePassword = this.typePassword === 'password' ? 'text' : 'password'
        },
        showNewPassword(){
            this.eyaNewPassword = this.eyaNewPassword === '<i class="fas fa-eye-slash">' ? '<i class="fas fa-eye">' : '<i class="fas fa-eye-slash">'
            this.typeNewPassword = this.typeNewPassword === 'password' ? 'text' : 'password'
        },
        editInfo(){
            const fd = new FormData();
            const config = { headers: { "Content-Type": "multipart/form-data" } };
            fd.append("id", this.user.id);
            fd.append("firstName", this.user.firstName);
            fd.append("lastName", this.user.lastName);
            fd.append("companyName", this.user.companyName);
            fd.append("country", this.user.country);
            axios.post('v1/user/uploadInformation', {
                firstName : this.user.firstName,
            }, config)
                .then(res => {
                    console.log(res)
                //    location.reload();
                });
        }

    }
}
</script>
<style lang="scss" scoped>

*:focus {outline:none !important}
input {
    background-color:transparent;
    box-shadow: 0px 0px 0px 0px;
}

</style>