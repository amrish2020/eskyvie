<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">
              <h3 class="card-title">Assign Leads</h3>
              <div class="card-tools">
                    <div class="float-left col-md-8">
                        <input class="form-control" v-model="search" type="search" @keyup="searchit" placeholder="Search here" aria-label="Search">
                    </div>
                    <div class="float-right col-md-4">
                        <button class="btn btn-success" @click="newModal"><i class="right fas fa-user-plus"></i>&nbsp; Assign Leads</button>
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
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Stff ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Created at</th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="lead in reqleads" :key="lead.id">
                                        <td>{{lead.id}}</td>
                                        <td>{{lead.staff_id}}</td>
                                        <td>{{lead.name | capitalize}}</td>
                                        <td>{{lead.status | capitalize}}</td>
                                        <td>{{lead.created_at | dateformat}}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Staff ID</th>
                                    <th rowspan="1" colspan="1">Name</th>
                                    <th rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1">Created</th>
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
                <pagination :data="reqleads" @pagination-change-page="getResults"></pagination>
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
                <h5 class="modal-title" id="addNewLabel" v-show="!isedit">Assigm Leads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="AssignLeads()">
                <div class="modal-body">
                    <div class="form-group" id='parent_mgr'>
                        <label>Select staff</label>
                        <select name="staff_id" v-model="form.staff_id" id='staff_id' class="form-control">
                            <option value="" selected='true'>Select</option>
                            <option v-for="usr in staffs" :value="usr.id">{{usr.name}}</option>
                            <has-error :form="form" field="staff_id"></has-error>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
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
                reqleads:{},
                staffs:{},
                isedit:false,
                search:'',
                form: new Form({
                    staff_id:'',
                })
            }
        },
        methods:{
            AssignLeads(){
                this.$Progress.start()
                this.form.post('api/requestleads')
                .then((data)=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');

                    if(data.data.msg == 'fail'){
                        toast.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Leads can not be assign already have open lead.',
                        });

                        this.$Progress.fail();
                    } else {
                        toast.fire({
                            icon: 'success',
                            title: 'Leads Assign Successfully'
                        });
                        this.$Progress.finish();
                    }
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
            },
            loadRequestleads(){
                //if(this.$gate.isClientAdmin){}
                this.$Progress.start()
                axios.get('api/requestleads').then(({data})=>(this.reqleads = data));
                this.$Progress.finish()
            },
            loadStaffList(){
                //if(this.$gate.isClientAdmin){}
                this.$Progress.start()
                axios.get('api/stafflist').then(({data})=>(this.staffs = data));
                this.$Progress.finish()
            },
            newModal(){
                this.form.reset();
                $('#addNew').modal('show');
            },
            getResults(page = 1) {
			    axios.get('api/reqleads?page=' + page)
				.then(response => {
					this.reqleads = response.data;
				});
            },
            searchit(){
                /*axios.get('api/findUser?q=' + this.search)
				.then((data) => {
					this.users = data.data;
				});*/
            },
        },
        created() {
            this.loadRequestleads();
            this.loadStaffList();
            Fire.$on('AfterCreate',()=>{this.loadRequestleads()});
        }
    }
</script>
