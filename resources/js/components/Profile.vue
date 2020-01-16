<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                       <form>
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name" placeholder="Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" >
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="text" name="email" placeholder="Email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Mobile no.:</label>
                                <input v-model="form.mobile" type="text" name="mobile" placeholder="Mobile number"  class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                <has-error :form="form" field="mobile"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input v-model="form.username" type="text" name="username" placeholder="Username" class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                                <has-error :form="form" field="username"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password" placeholder="Password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <button type="submit" @click.prevent="updateInfo" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                users:{},
                form: new Form({
                    id:'',
                    username:'',
                    password:'',
                    name:'',
                    email:'',
                    password:'',
                    mobile:'',
                    photo:''
                })
            }
        },
        methods:{
            updateInfo(){
                this.$Progress.start();
                this.form.put('api/profile/')
                .then(()=>{
                    toast.fire({
                        icon: 'success',
                        title: 'User Updated successfully'
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
            }
        },
        created() {
            axios.get('api/profile/').then(({data})=>(this.form.fill(data)));
        }
    }
</script>
