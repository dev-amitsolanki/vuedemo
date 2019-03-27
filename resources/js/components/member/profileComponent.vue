<template>
  <div>
    <keep-alive>
      <component :is="navbarComponent"></component>
    </keep-alive>
    <div class="container">
      <h2>Profile</h2>
      <br>
      <div class="content">
          <div v-if="errorMessage.length > 0">
            <h4
              v-for="(err,index) in errorMessage"
              :key="index"
              class="alert alert-danger"
            >{{ err.message }}</h4>
          </div>
          <div class="alert-success alert-flash">
          <flash-message class="myCustomClass"></flash-message>
          </div>
        <form @submit.prevent="onSubmit">
            <div class="form-group">
            <div class="row">
                <div class="col-sm">
                <label for="flat-type">Name:</label>
                <input type="text" class="form-control" placeholder="Enter your name" v-model="name">
                </div>
                <div class="col-sm">
                <label for="flat-type">Email:</label>
                <input type="email" class="form-control" placeholder="Enter your email" v-model="email">
                </div>
            </div>
            </div>
            <div class="form-group">
            <div class="row">
                <div class="col-sm">
                <label for="flat-type"> Number:</label>
                <input type="number" class="form-control" placeholder="Enter your number" v-model="number">
                </div>
                <div class="col-sm"><br>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" class="form-check-input" @click="pCheckbox = !pCheckbox" :checked="pCheckbox">click here to change your password.
                </div>
            </div>
            </div>
            <div class="form-group" v-if="pCheckbox">
            <div class="row">
                <div class="col-sm">
                    <label for="flat-type">Password:</label>
                    <input type="password" class="form-control" placeholder="Enter your new password" v-model="password" v-validate="{required : true }" name="password">
                    <span v-show="errors.has('password')" class="error">{{ errors.first('password') }}</span>
                </div>
                <div class="col-sm">
                    <label for="flat-type">Confirm-password:</label>
                    <input type="password" class="form-control" placeholder="Re-enter your password" v-model="password_confirmation" name="password_confirmation" >
                    <span v-show="errors.has('password_confirmation ')" class="error" >{{ errors.first('password_confirmation ') }}</span>
                </div>
            </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="block">Block:</label>
                        <select name="block" v-model="block" class="form-control">
                            <option value="">Select Block</option>
                            <option :value="block.block" v-for="(block,index) in this.$session.get('block')" :key="index">{{ block.block }}</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label for="flat-type">Flat-type:</label>
                        <select name="flat_type" v-model="flat_type" class="form-control">
                            <option value="">Select Flat-type</option>
                            <option :value="flat.flat_type" v-for="(flat, index) in this.$session.get('flat_type')" :key="index">{{ flat.flat_type }}</option>
                        </select>
                    </div>
                    <div class="col-sm">
                        <label for="flat-type">Flate-area:</label>
                        <input type="number" name="flate_area" v-model="flat_area" placeholder="Enter your flat area" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="flat-type">Your parking access is:</label> &nbsp;
                        <div class="form-check form-check-inline">
                            <input type="radio" name="parking" v-model="parking" class="form-check-input" value="yes" :checked="this.parking == 'yes'">
                            <label class="form-check-label" for="gridRadios1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="parking" v-model="parking" class="form-check-input" value="no" :checked="this.parking == 'no'">
                            <label class="form-check-label" for="gridRadios2">
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row float-right">
                    <router-link to="/home"><button type="button" class="btn btn-danger">Cancel</button></router-link>&nbsp;&nbsp;
                    <input type="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import navbarComponent from "../navbarComponent";
export default {
  components: {
    navbarComponent
  },
  data() {
    return {
      navbarComponent: navbarComponent,
      pCheckbox: false,
      name: '',
      email: '',
      number: '',
      password: '',
      password_confirmation:'',
      block: '',
      flat_type: '',
      flat_area: '',
      parking: '',
      id: '',
      errorMessage : []
    };
  },
  created(){
      this.getData();
  },
  methods:{
        onSubmit(){
            this.errorMessage = [];
            this.$validator.validateAll().then(result => {
            if(result){
             axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')

                axios.put(this.$url + 'api/edit' + '/' + this.id ,{
                    name : this.name,
                    email : this.email,
                    number : this.number,
                    pCheckbox : this.pCheckbox,
                    password : this.password,
                    password_confirmation: this.password_confirmation,
                    block : this.block,
                    flat_type : this.flat_type,
                    flat_area : this.flat_area,
                    parking : this.parking
                        }).then( response => {
                            console.log(response.data.message)
                        this.flash(response.data.message, 'success', {
                            timeout: 3000,
                            });
                    })
                    .catch(error => {
                         this.errorMessage.push(error.response.data);
                    })
             }
            });
        },
        getData(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            axios.get(this.$url + 'api/data').then( response => {
                this.userData = response.data
                this.id = response.data.id
                this.name = response.data.name
                this.email = response.data.email
                this.number = response.data.number
               this.block = response.data.block
                this.flat_type = response.data.flat_type
                this.flat_area = response.data.flat_area
                this.parking = response.data.parking
            })
        }
  }
};
</script>
<style>
h2 {
  text-align: center;
  margin-top: 10%;
}
.content {
  margin-left: 10%;
}
.error{
    color:red;
}
</style>
