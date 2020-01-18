<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">
              <h3 class="card-title">My Sales Leads</h3>
              <div class="card-tools">
                    <div class="float-left col-md-8">
                        <input class="form-control" v-model="search" type="search" @keyup="searchit" placeholder="Search here" aria-label="Search">
                    </div>
                    <div class="float-right col-md-4">
                        <button class="btn btn-success" @click="newModal"><i class="right fas fa-user-plus"></i>&nbsp; Request Leads</button>
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
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Customer ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Created at</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status Update On</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="lead in reqleads.data" :key="lead.id">
                                        <td>{{lead.id}}</td>
                                        <td>{{lead.name | capitalize}}</td>
                                        <td>{{lead.created_at | dateformat}}</td>
                                        <td>{{lead.updated_at | dateformat}}</td>
                                        <td>{{lead.status | capitalize}}</td>
                                        <td><a href="" class="btn btn-primary">Engagge</a></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Customer ID</th>
                                    <th rowspan="1" colspan="1">Created at</th>
                                    <th rowspan="1" colspan="1">Status Update On</th>
                                    <th rowspan="1" colspan="1">Status</th>
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
            <form @submit.prevent="RequestLeads()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter number</label>
                        <input v-model="form.req_lead" type="text" name="req_lead" placeholder="Enter number to request lead" class="form-control" :class="{ 'is-invalid': form.errors.has('req_lead') }">
                        <has-error :form="form" field="req_lead"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request</button>
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
                    req_lead:'',
                })
            }
        },
        methods:{
            RequestLeads(){
                this.$Progress.start()
                this.form.post('api/reqmoreleads')
                .then((data)=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Leads Request Successfully Done'
                    });
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
            },
            loadMyleads(){
                //if(this.$gate.isClientAdmin){}
                this.$Progress.start()
                axios.get('api/myleads').then(({data})=>(this.reqleads = data));
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
            this.loadMyleads();
            this.loadStaffList();
            Fire.$on('AfterCreate',()=>{this.loadMyleads()});
        }
    }
</script>
