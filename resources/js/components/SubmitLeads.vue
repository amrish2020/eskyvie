<template>
    <div class="container">
        <div class="row mt-5"> <!-- v-if="$gate.isClientAdmin()" -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add New leads</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" @submit.prevent="createLeads()">
                        <div class="card-body">
                            <div class="col-md-12 float-left">
                                <div class="col-md-4 float-left">
                                    <div class="form-group">
                                        <label>Ads*</label>
                                        <select name="ads_id" v-model="form.ads_id" id='ads_id' class="form-control" :class="{ 'is-invalid': form.errors.has('ads_id') }">
                                            <option value="">Select Ads</option>
                                            <option v-for="ads in adslist" :value="ads.id">{{ads.ads_id}}</option>
                                        </select>
                                        <has-error :form="form" field="ads_id"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-4 float-left">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary">Standard</button>
                                    </div>
                                </div>
                                <div class="col-md-4 float-left">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary">File Upload</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 float-left">
                                <hr/>
                                <h5>Standard Input</h5>
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
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                adslist:[],
                form: new Form({
                    name:'',
                    email:'',
                    ads_id:'',
                    mobile:'',
                })
            }
        },
        methods:{
            createLeads(){
                this.$Progress.start()
                this.form.post('api/leads')
                .then(()=>{
                    toast.fire({
                        icon: 'success',
                        title: 'Leads Created successfully'
                    })
                    this.$Progress.finish();
                    this.form.reset();
                })
                .catch(()=>{

                })
            },
            loadAds(){
                //if(this.$gate.isClientAdmin){}
                this.$Progress.start()
                axios.get('api/adslist').then(({data})=>(this.adslist = data));
                this.$Progress.finish()
            },
        },
        beforeMount() {
            this.loadAds();
        }
    }
</script>
