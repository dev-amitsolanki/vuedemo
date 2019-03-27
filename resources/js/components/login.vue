    <template>
  <div class="container">
    <div class="col-sm-6 col-md-6 col-xs-12 col-md-offset-3 col-sm-offset-3" style="margin:0 auto;">
      <div v-if="errorMessage.length > 0">
        <h4
          v-for="(er,index) in errorMessage"
          :key="index"
          class="alert alert-danger col-md"
        >{{ er.message }}</h4>
      </div>
      <div class="card">
        <div class="card-header">
          <h2>Login</h2>
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
              <label for="password">Password</label>
              <input
                type="password"
                v-model="password"
                data-vv-name="password"
                v-validate="{required: true}"
                class="form-control col-md-6"
                placeholder="password"
              >
              <span v-show="errors.has('password')" class="error">{{ errors.first('password') }}</span>
            </div>
            <div v-if="reset == 'password is wrong'">
              <router-link to="/ResetPassword">Forgotten your password ?</router-link>
            </div>
            <div class="form-group">
              <input type="submit" value="submit" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
      <br>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: [],
      reset:''
    };
  },
  methods: {
    onSubmit() {
      this.errorMessage = [];
      this.$validator.validateAll().then(result => {
        if (result) {
          axios
            .post(this.$url + "api/login", {
              email: this.email,
              password: this.password
            })
            .then(response => {
              this.$session.set("name", response.data.data.name);
              this.$session.set("email", response.data.data.email);
              var access = "Bearer " + response.data.accessToken;
              this.$session.set("accessToken", access);
              setTimeout(() => {
                this.$router.push("home");
              }, 1000);
            })
            .catch(error => {
              this.errorMessage.push(error.response.data);
              this.reset = error.response.data.message;
            //   console.log(error.response.data.message);
            });
        }
      });
    }
  }
};
</script>
<style scoped>
.container {
  margin-top: 10%;
}
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

