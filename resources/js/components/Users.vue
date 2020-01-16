<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users</h3>
              <div class="card-tools">
                    <div class="float-left col-md-8">
                        <input class="form-control" v-model="search" type="search" @keyup="searchit" placeholder="Search here" aria-label="Search">
                    </div>
                    <div class="float-right col-md-4">
                        <button class="btn btn-success" @click="newModal"><i class="right fas fa-user-plus"></i>&nbsp; Add New</button>
                    </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                      <div class="col-sm-12 col-md-6"></div>
                      <div class="col-sm-12 col-md-6"></div>
                      </div>
                      <div class="row">
                          <div class="col-sm-12">
                              <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="ID: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Mobile: activate to sort column ascending">Mobile</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending">Role</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Status : activate to sort column ascending">Status</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Create at : activate to sort column ascending">Created at</th>
                                    <th rowspan="1" colspan="1">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="user in users.data" :key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.name | capitalize}}</td>
                                        <td>{{user.email}}</td>
                                        <td>{{user.mobile}}</td>
                                        <td>{{user.type | capitalize}}</td>
                                        <td></td>
                                        <td>{{user.created_at | dateformat}}</td>
                                            <td>
                                                <a href="#" @click="editModal(user)"><i class="right fas fa-edit"></i></a>&nbsp;/&nbsp;
                                                <a href="#" @click="deleteUser(user.id)"><i class="right fas fa-trash text-red"></i></a>
                                            </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Name</th>
                                    <th rowspan="1" colspan="1">Email</th>
                                    <th rowspan="1" colspan="1">Mobile</th>
                                    <th rowspan="1" colspan="1">Role</th>
                                    <th rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1">Created</th>
                                    <th rowspan="1" colspan="1">Action</th>
                                </tr>
                                </tfoot>
                            </table>
                            </div>
                            </div>

                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
            </div>
          </div>
            </div>
        </div>

        <!--div v-if="!$gate.isClientAdmin()">
            <not-found></not-found>
        </div -->
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewLabel" v-show="!isedit">Add New User</h5>
                <h5 class="modal-title" id="addNewLabel" v-show="isedit">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="isedit ? updateUser() : createUser()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" @change="parentUser" v-model="form.role" id='role' class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                            <option value="">Select User Role</option>
                            <!--option value="1">Client Admin</option>
                            <option value="7">Customer</option>
                            <option value="2">Admin</option-->
                            <option value="3">Sales Manager</option>
                            <option value="4">Sales Exec.</option>
                            <option value="5">Marketing Manager</option>
                            <option value="6">Marketing Exec.</option>
                        </select>
                        <has-error :form="form" field="role"></has-error>
                    </div>
                    <div class="form-group" v-show="isSuper" id='parent_mgr'>
                        <label>Parent Manager</label>
                        <select name="parent_id" v-model="form.parent_id" id='parent_id' class="form-control">
                            <option value="">Select</option>
                            <option v-for="usr in parents" :value="usr.id">{{usr.name}}</option>
                        </select>
                    </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" v-show="!isedit">Create</button>
                    <button type="submit" class="btn btn-success" v-show="isedit">Update</button>
                </div>
            </form>
            </div>
        </div>
        </div>
     <!-- Modal end -->

    </div>
</template>

<script>
    export default {
        data(){
            return {
                users:{},
                parents:[],
                isedit:false,
                isSuper:false,
                search:'',
                form: new Form({
                    id:'',
                    username:'',
                    password:'',
                    name:'',
                    email:'',
                    password:'',
                    role:'',
                    mobile:'',
                })
            }
        },
        methods:{
            createUser(){
                this.$Progress.start()
                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'User Created successfully'
                    })
                    this.$Progress.finish();
                    this.isSuper = false;
                })
                .catch(()=>{

                })
            },
            loadUsers(){
                //if(this.$gate.isClientAdmin){}

                this.$Progress.start()
                axios.get('api/user').then(({data})=>(this.users = data));
                this.$Progress.finish()
            },
            deleteUser(id){
                swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    //ajax req
                    if(result.value){
                        this.form.delete('api/user/'+id)
                        .then(()=>{
                            swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');
                        })
                        .catch(()=>{
                            swal(
                                'Failed!',
                                'There Was Something wrong.',
                                'warning'
                            )
                        });
                    }
                })
            },
            newModal(){
                this.isedit = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(user){
                this.form.reset();
                this.isedit = true;
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            updateUser(id){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'User Updated successfully'
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
            },
            getResults(page = 1) {
			    axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
            },
            searchit(){
                axios.get('api/findUser?q=' + this.search)
				.then((data) => {
					this.users = data.data;
				});
            },
            parentUser(event){
                let val = event.target.value;
                if(val == 4 || val == 6){
                    this.isSuper = true;
                    axios.get('api/parentUserList?pid='+val).then(({data})=>(
                        this.parents = data
                    ));
                } else {
                    this.isSuper = false;
                }
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate',()=>{this.loadUsers()});
        }
    }
</script>
