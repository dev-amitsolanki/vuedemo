<template>
  <div>
    <div>
      <keep-alive>
        <component :is="navbarComponent"></component>
      </keep-alive>
    </div>
    <div class="container">
      <div class="mnt">
        <form @submit.prevent="onSubmit">
            <div class="alert-danger">
                     <flash-message></flash-message>
                </div>
           <div class="form-group">
            <div class="row">
                <div class="col-sm">
                    <label for="block">Block:</label>
                        <select name="block" v-model="block" class="form-control">
                            <option value="">Select Block</option>
                            <option :value="block.block" v-for="(block,index) in this.$session.get('block')" :key="index">{{ block.block }}</option>
                        </select>
                        <span v-show="errors.has('block')" class="error">{{ errors.first('block') }}</span>
                </div>
                <div class="col-sm">
                    <label for="flat-type">enter your Flat number:</label>
                    <input type="text" data-vv-name="flat_no" v-model="flat_no" class="form-control" v-validate="{required: true}" placeholder="Enter your flat number">
                    <span v-show="errors.has('flat_no')" class="error">{{ errors.first('flat_no') }}</span>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="flat-type">What type of your flat:</label> &nbsp;
                        <div class="form-check form-check-inline">
                            <input type="radio" data-vv-name="flat_type" v-validate="{required : true}" v-model="flat_type" class="form-check-input" value="Owner">
                            <label class="form-check-label" for="gridRadios1">
                                Owner
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" data-vv-name="flat_type" v-validate="{required : true}" v-model="flat_type" class="form-check-input" value="Rental">
                            <label class="form-check-label" for="gridRadios2">
                                Rental
                            </label>
                        </div>
                        <br>
                         <span v-show="errors.has('flat_type')" class="error">{{ errors.first('flat_type') }}</span>
                    </div>
                </div>
            </div>
                <br>
            <input type="submit" class="btn btn-info" value="Show">
            </div>
        </form>
        <div v-if="showMaintenance">
            <table class="table table-bordered col-md-6">
                <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Maintenance</td>
                    <td>{{ maintenance }}</td>
                </tr>
                <tr >
                    <td>2</td>
                    <td>Late-fee</td>
                    <td>{{ late_fee }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center">Total</td>
                    <td>{{ total }}</td>
                </tr>
            </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import navbarComponent from "../navbarComponent.vue";
export default {
  components: {
    navbarComponent
  },
  data() {
    return {
      navbarComponent: navbarComponent,
      showMaintenance:false,
      flat_no:'',
      block:'',
      flat_type:'',
      Mdata: '',
      maintenance: '',
      late_fee: '',
      total: '',
      errorMessage: [],
    }
  },
  methods:{
      onSubmit(){
        this.$validator.validateAll().then(result => {
            if(result){
          axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
          axios.post(this.$url + 'api/mainteCal',{
              flat_no: this.flat_no,
              block: this.block,
              flat_type: this.flat_type
          })
          .then(response => {
              if(response.data.success == false){
                  this.flash(response.data.message,'danger',{
                    timeout:3000,
                });
              }else{
              this.Mdata = response.data;
              this.maintenance = response.data.data.m_charge;
              this.showMaintenance = true;
              this.late_fee = response.data.late_fee;
              this.total = response.data.total;
              }
          })
          .catch(error => {
              console.log(error)
          })

            }
        })
      }
  }
};
</script>
<style>
.mnt {
  margin-top: 5%;
    margin-left: 10%;
}
</style>
