<template>
  <div>
    <div
      class="col-sm-6 col-md-6 col-xs-12 col-md-offset-3 col-sm-offset-3"
      style="margin:0 auto; margin-top:10%;"
    >
    <div v-if="errorMessage.length > 0">
        <h4
          v-for="(er,index) in errorMessage"
          :key="index"
          class="alert alert-danger col-md"
        >{{ er[0] }}</h4>
      </div>
      <div v-if="successMessage == true">
        <h4 class="alert alert-success col-md"
        >{{ Success }}</h4>
      </div>
      <div class="card">
        <div class="card-header">
          <h2>
            Password Reset
            <button type="button" class="btn btn-sm bg-danger float-left">
              <router-link to="/" style="color:#fff;">Back</router-link>
            </button>
          </h2>
        </div>
        <form @submit.prevent="onSubmit">
          <div class="card-body">
            <div class="form-group">
              <label for="email">E-mail</label>
              <input
                type="email"
                v-model="email"
                data-vv-name="email"
                v-validate="{required: true}"
                class="form-control col-md-6"
                placeholder="E-mail"
              >
              <span v-show="errors.has('email')" class="error">{{ errors.first('email') }}</span>
            </div>

            <div class="form-group">
              <input type="submit" value="submit" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      email: "",
      errorMessage:[],
      successMessage:false,
      Success:''
    }
  },
  methods:{
      onSubmit(){
          axios.post(this.$url + 'api/password/create',{
              email:this.email
          }).then(response => {
              console.log(response.data.message)
              this.successMessage = true
              this.Success = response.data.message
          }).catch(error => {
              this.errorMessage=[];
              console.log(error.response.data.errors.email)
               this.errorMessage.push(error.response.data.errors.email);
          })
      }
  }
};
</script>
<style>
h2 {
  text-align: center;
  margin-left: 0%;
}
.card .form-group .col-md-6,
.card .form-group .col-sm-6 {
  max-width: 100%;
}
.card .btn-primary {
  display: inherit;
  margin: 0 auto;
}
.error {
  color: red;
}
</style>


