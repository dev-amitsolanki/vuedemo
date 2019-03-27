<template>
  <div>
    <div>
      <keep-alive>
        <component :is="navbarComponent"></component>
      </keep-alive>
    </div>
    <div class="container">
            <div class="select-menu">
                <div class="alert-success">
                     <flash-message></flash-message>
                </div>
                <form @submit.prevent="onSubmit">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="block">Select member type:</label>
                                <select name="block" data-vv-name="member_type" v-model="member_type" v-validate="{required:true}" class="form-control">
                                    <option value="Owner">Owner</option>
                                    <option value="Rental">Rental</option>
                                </select>
                                <span v-show="errors.has('member_type')" class="error">{{ 'This field is required!' }}</span>
                            </div>
                            <div class="col-sm-4">
                                 <label for="flat-type">Flat-type:</label>
                                    <select name="flat_type" v-model="flat_type" v-validate="{required:true}"  @change="data" class="form-control">
                                        <option value="">Select Flat-type</option>
                                        <option :value="flat.flat_type" v-for="(flat, index) in this.$session.get('flat_type')" :key="index">{{ flat.flat_type }}</option>
                                    </select>
                                <span v-show="errors.has('flat_type')" class="error">{{ 'This field is required!' }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="button" @click="charge = true" class="btn btn-warning" v-if="!charge">Show</button> -->
                    <!-- <div class="new" v-if="charge"> -->
                    <label for="maintenance_charge">maintenance Charge :</label>
                    <input type="number" v-model="m_charge" class="form-control col-md-4" placeholder="Enter maintenance charge">
                    <label for="late-fee">Late fee charge :</label>
                    <input type="number" v-model="late_fee" class="form-control col-md-4" placeholder="Enter late fee charge">
                    <label for="last-date">Last-date of fill the maintenance:</label>
                    <input type="number" v-model="m_date" data-vv-name="m_date" v-validate="'required|max_value:31|min_value:1'" placeholder="Enter last date of fill maintenance" class="form-control col-md-4">
                    <span v-show="errors.has('m_date')" class="error">{{ errors.first('m_date') }}</span>
                    <br><br>
                    <input type="submit" value="submit"  class="btn btn-primary">
                    <!-- </div> -->
                </form>
            </div>
        </div>
  </div>
</template>
<script>
import navbarComponent from "../navbarComponent.vue";
export default {
  component: {
    navbarComponent
  },
  data() {
    return {
      navbarComponent: navbarComponent,
      member_type: "",
      flat_type: "",
      m_charge: "",
      late_fee: "",
      charge:false,
      m_data: "",
      m_date: '',
      id: ''
    };
  },
  methods:{
      onSubmit(){
        this.$validator.validateAll().then(result => {
            if(result){

          axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

          axios.post(this.$url + "api/m-charge", {
              member_type: this.member_type,
              flat_type: this.flat_type,
              m_charge: this.m_charge,
              late_fee: this.late_fee,
              id: this.id,
              m_date: this.m_date
          })
          .then(response => {
              console.log(response.data)
          })
          .catch(error => {
              console.log(error)
          })
            }
        })
      },
      data(){
          axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

          axios.post(this.$url + "api/m-data",{
              member_type: this.member_type,
              flat_type: this.flat_type,
          }).then(response => {
              this.m_data = response.data;
              this.m_charge = response.data.data.m_charge;
              this.late_fee = response.data.data.late_fee;
              this.id = response.data.data.id;
              this.m_date = response.data.mdate.m_date;
              this.flash(response.data.message,'success',{
                    timeout:3000,
                });
          })
          .catch(error => {
              console.log(error);
          })
      }
  }
};
</script>
<style>
.select-menu {
  margin-top: 5%;
}
</style>

