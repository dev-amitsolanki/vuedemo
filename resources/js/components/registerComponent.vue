<template>
  <div>
    <keep-alive>
      <component :is="navbarComponent"></component>
    </keep-alive>
    <div class="container">
      <div class="col-sm-6 col-md-6 col-xs-12 col-md-offset-3 col-sm-offset-3" style="margin:0 auto;">
        <div class="content">
          <div v-if="errorMessage.length > 0">
            <h4
              v-for="(err,index) in errorMessage"
              :key="index"
              class="alert alert-danger"
            >{{ err.error }}</h4>
          </div>
          <form @submit.prevent="onSubmit">
            <h2 class="regiser">Register</h2>
            <div class="form-group">
              <div class="row">
                <div class="col-sm">
                  <input type="text" class="form-control" data-vv-name="name" v-model="name" v-validate="{required:true}" placeholder= "Enter your name">
                  <span v-show="errors.has('name')" class="error">{{ errors.first('name') }}</span>
                </div>
                <div class="col-sm">
                  <input type="email" class="form-control" data-vv-name="email" v-model="email" v-validate="{required:true}" placeholder="Enter your email">
                  <span v-show="errors.has('email')" class="error">{{ errors.first('email') }}</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm">
                  <input type="number" class="form-control" data-vv-name="number" v-model="number" v-validate="{required: true}"  placeholder="Enter your Mobile number">
                  <span v-show="errors.has('number')" class="error">{{ errors.first('number') }}</span>
                </div>
                <div class="col-sm">
                  <input type="password" class="form-control" data-vv-name="password" v-model="password" v-validate="{required: true}" placeholder="Enter your password">
                  <span v-show="errors.has('password')" class="error">{{ errors.first('password') }}</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-sm">
                  <input type="password" class="form-control" data-vv-name="password_confirmation " v-model="password_confirmation" v-validate="{required: true}" placeholder="Re-type your password">
                  <span v-show="errors.has('password_confirmation ')" class="error" >{{ errors.first('password_confirmation ') }}</span>
                </div>
                <div class="col-sm">
                  <input type="number" class="form-control" v-model="flat_no" data-vv-name="flat_no" v-validate="{required:true}" placeholder="Enter your flat no">
                  <span v-show="errors.has('flat_no')" class="error">The flat no field is required.</span>
                </div>
              </div>
            </div>
            <br>
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
                        <input type="number" name="flate_area" data-vv-name="flat_area"
                        v-validate="{required:true}" v-model="flat_area" placeholder="Enter your flat area" class="form-control">
                        <span v-show="errors.has('flat_area')" class="error">The area field is required.</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="flat-type">Do you want to use parking :</label> &nbsp;
                        <div class="form-check form-check-inline">
                            <input type="radio" name="parking" v-validate="{required:true}" v-model="parking" class="form-check-input" value="yes" >
                            <label class="form-check-label" for="gridRadios1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="parking" v-validate="{required:true}" v-model="parking" class="form-check-input" value="no" >
                            <label class="form-check-label" for="gridRadios2">
                                No
                            </label>
                        </div>
                    </div>
                </div>
            <span v-show="errors.has('parking')" class="error">{{ errors.first('parking') }}</span>
            </div>
            <br>
            <div v-if="this.$session.get('roll_id') == 1">
            <label for="user_roll">User roll</label>
            <br>
            <select  name="user_roll" v-model="user_roll" class="form-control col-md-6">
              <option value="2">Member</option>
              <option value="1">Admin</option>
            </select>
            <br>
            <br>
          </div>
            <button type="submit" class="btn btn-default" value="submit">Submit</button>
            <router-link to="/home" class="btn btn-danger">Cancel</router-link>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { bus } from "./../app.js";
import navbarComponent from "./navbarComponent.vue";
export default {
  components: {
    navbarComponent
  },
  data() {
    return {
      userroll: false,
      navbarComponent: navbarComponent,
      name: "",
      email: "",
      number: "",
      password: "",
      password_confirmation: "",
      flat_no: "",
      block: "",
      flat_type: "",
      flat_area: "",
      parking: "",
      user_roll: "",
      errorMessage: [],
    };

  },
   created() {
    // this.getItems();
  },
  methods: {
    //  getItems() {
    //   axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
    //   // var _this = this;
    //   axios.get("/api/getitems").then( response => {
    //     this.items = response.data
    //   });
    // },
    onSubmit() {
      this.errorMessage = [];

      this.$validator.validateAll().then(result => {
        if (result) {
          axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
          axios
            .post(this.$url + "api/register", {
              name: this.name,
              email: this.email,
              number: this.number,
              password: this.password,
              password_confirmation: this.password_confirmation,
              flat_no: this.flat_no,
              block: this.block,
              flat_type: this.flat_type,
              flat_area: this.flat_area,
              user_roll: this.user_roll,
              parking: this.parking
            })
            .then(response => {
              setTimeout(() => {
                this.$router.push("home");
                this.flash(response.data.message,'success',{
                    timeout:3000,
                });
              }, 1000);
            })
            .catch(error => {
              this.errorMessage.push(error.response.data);
            });
        }
      });
    }
  }
};
</script>
<style>
.content {
  margin-top: 5%;
  align-content: center;
}
h2 {
  margin-left: 0%; text-align:center;
}
.error {
  color: red;
}
</style>


