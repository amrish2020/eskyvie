<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
            <div class="card-header">
              <h3 class="card-title">Team Ads</h3>
              <div class="card-tools">
                    <div class="float-left col-md-8">
                        <input class="form-control" v-model="search" type="search" @keyup="searchit" placeholder="Search here" aria-label="Search">
                    </div>
                    <div class="float-right col-md-4">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addNew"><i class="right fas fa-newspaper"></i>&nbsp; Create Ads</button>
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
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ads ID: activate to sort column ascending">Ads ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending">Type</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Start at: activate to sort column ascending">Start at</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="End at: activate to sort column ascending">End at</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Budget : activate to sort column ascending">Budget</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Leads : activate to sort column ascending">Leads</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CPL(MYR) : activate to sort column ascending">CPL(MYR)</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Status : activate to sort column ascending">Status</th>
                                    <th rowspan="1" colspan="1"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" v-for="ad in ads.data" :key="ad.id">
                                        <td>{{ad.id}}</td>
                                        <td>{{ad.ads_id}}</td>
                                        <td>{{ad.media | capitalize}}<span>{{ad.ads_type | capitalize}}</span></td>
                                         <td>{{ad.start_at | dateformat}}</td>
                                        <td>{{ad.end_at | dateformat}}</td>
                                        <td>RM{{ad.budeget}}</td>
                                        <td>total lead</td>
                                        <td>cpl</td>
                                        <td>status</td>
                                        <td>
                                            <a href="#"><i class="right fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Ads ID</th>
                                    <th rowspan="1" colspan="1">Type</th>
                                    <th rowspan="1" colspan="1">Start at</th>
                                    <th rowspan="1" colspan="1">End at</th>
                                    <th rowspan="1" colspan="1">Budget</th>
                                    <th rowspan="1" colspan="1">Leads</th>
                                    <th rowspan="1" colspan="1">CPL(MYR)</th>
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
                <pagination :data="ads" @pagination-change-page="getResults"></pagination>
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
                <h5 class="modal-title" id="addNewLabel">Create a New Ads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="createAds()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Media</label>
                        <select name="media" v-model="form.media" id='media' class="form-control" :class="{ 'is-invalid': form.errors.has('media') }">
                            <option value="">Select Media</option>
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="linkedin">Linkedin</option>
                        </select>
                        <has-error :form="form" field="media"></has-error>
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <input v-model="form.url" type="text" name="url" placeholder="URL" class="form-control" :class="{ 'is-invalid': form.errors.has('url') }" >
                        <has-error :form="form" field="url"></has-error>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Ads Type</label>
                                <select name="ads_type" v-model="form.ads_type" id='ads_type' class="form-control" :class="{ 'is-invalid': form.errors.has('ads_type') }">
                                    <option value="">Select Type</option>
                                    <option value="promoted post">Promoted Post</option>
                                    <option value="new promotion">New Promotion</option>
                                </select>
                                <has-error :form="form" field="ads_type"></has-error>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Budeget(MYR)</label>
                                <input v-model="form.budeget" type="text" name="budeget" placeholder="Budeget(MYR)" class="form-control" :class="{ 'is-invalid': form.errors.has('budeget') }" >
                                <has-error :form="form" field="budeget"></has-error>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Start Date</label>
                                <datepicker v-model="form.start_at" format="yyyy-MM-dd" placeholder="Select Start Date" clear-button-icon="true" name="start_at"></datepicker>
                                <has-error :form="form" field="start_at"></has-error>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <datepicker v-model="form.end_at" format="yyyy-MM-dd" placeholder="Select End Date" clear-button-icon="true" name="end_at"></datepicker>
                                <has-error :form="form" field="end_at"></has-error>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
            </div>
        </div>
        </div>
     <!-- Modal end -->

    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'

    export default {
        components: {
            Datepicker
        },
        data(){
            return {
                ads:{},
                search:'',
                form: new Form({
                    id:'',
                    media:'',
                    url:'',
                    ads_type:'',
                    budeget:'',
                    start_at:'',
                    end_at:'',
                })
            }
        },
        methods:{
            createAds(){
                this.$Progress.start()
                this.form.post('api/ads')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Ads Created successfully'
                    })
                    this.$Progress.finish();
                    this.form.reset();
                })
                .catch(()=>{

                })
            },
            loadAds(){
                this.$Progress.start()
                axios.get('api/ads').then(({data})=>(this.ads = data));
                this.$Progress.finish()
            },
            getResults(page = 1) {
			    axios.get('api/ads?page=' + page)
				.then(response => {
					this.ads = response.data;
				});
            },
            searchit(){
                axios.get('api/findAds?q=' + this.search)
				.then((data) => {
					this.ads = data.data;
				});
            }
        },
        created() {
            this.loadAds();
            Fire.$on('AfterCreate',()=>{this.loadAds()});
        }
    }
</script>
