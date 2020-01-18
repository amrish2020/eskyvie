<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">
              <h3 class="card-title">Team Customer</h3>
              <div class="card-tools">
                    <div class="float-left col-md-8">
                        <input class="form-control" v-model="search" type="search" @keyup="searchit" placeholder="Search here" aria-label="Search">
                    </div>
                    <div class="float-right col-md-4">

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
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Assign On</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Assign To</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status</th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="lead in reqleads.data" :key="lead.id">
                                        <td>{{lead.id}}</td>
                                        <td>{{lead.name | capitalize}}</td>
                                        <td>{{lead.created_at | dateformat}}</td>
                                        <td>{{lead.assign_date | dateformat}}</td>
                                        <td>{{lead.staff_id}}</td>
                                        <td>{{lead.status | capitalize}} <br/> <span>{{lead.updated_at | dateformat}}</span></td>
                                        <td><a href="" class="btn btn-primary">Engagge</a></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Customer ID</th>
                                    <th rowspan="1" colspan="1">Created at</th>
                                    <th rowspan="1" colspan="1">Assign On</th>
                                    <th rowspan="1" colspan="1">Assign To</th>
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
    </div>
</template>

<script>
    export default {
        data(){
            return {
                reqleads:{},
                search:'',
                form: new Form({
                    req_lead:'',
                })
            }
        },
        methods:{
            loadTeamCustomerleads(){
                //if(this.$gate.isClientAdmin){}
                this.$Progress.start()
                axios.get('api/teamcustomer').then(({data})=>(this.reqleads = data));
                this.$Progress.finish()
            },
            getResults(page = 1) {
			    axios.get('api/teamcustomer?page=' + page)
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
            this.loadTeamCustomerleads();
        }
    }
</script>
