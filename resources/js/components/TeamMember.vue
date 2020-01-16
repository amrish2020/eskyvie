<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Team Member</h3>
                <div class="card-tools">
                    <div class="float-left col-md-8">
                        <input class="form-control" v-model="search" type="search" @keyup="searchit" placeholder="Search here" aria-label="Search">
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
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Fullname & Staff ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Phone no.</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Position</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Join Since</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Online Status</th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="user in users.data" :key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.name | capitalize}}<br/><span>Staff ID</span></td>
                                        <td>{{user.mobile}}</td>
                                        <td>Role</td>
                                        <td>{{user.created_at | dateformat}}</td>
                                        <td>Online Status</td>
                                        <td>
                                            <a href="#" @click="editModal(user)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">#</th>
                                    <th rowspan="1" colspan="1">Full Name & Staff ID</th>
                                    <th rowspan="1" colspan="1">Phone no.</th>
                                    <th rowspan="1" colspan="1">Position</th>
                                    <th rowspan="1" colspan="1">Join Since</th>
                                    <th rowspan="1" colspan="1">Online Status</th>
                                    <th rowspan="1" colspan="1"></th>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="isedit ? updateUser() : createUser()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name : </label>
                        <span>{{form.name}}</span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <span>{{form.email}}</span>
                    </div>
                    <div class="form-group">
                        <label>Mobile no.:</label>
                        <span>{{form.mobile}}</span>
                    </div>
                    <div class="form-group">
                        <label>Join Since</label>
                        <span>{{form.created_at | dateformat}}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

            loadUsers(){
                //if(this.$gate.isClientAdmin){}

                this.$Progress.start()
                axios.get('api/user').then(({data})=>(this.users = data));
                this.$Progress.finish()
            },


            editModal(user){
                this.form.reset();
                this.isedit = true;
                $('#addNew').modal('show');
                this.form.fill(user);
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
