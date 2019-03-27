<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <router-link to="/home" class="home nav-link">Home</router-link>
        <router-link to="/register" class="home nav-link" v-if=" this.$session.get('roll_id') == 2 || roll_id == 2 ">AddMember</router-link>
        <router-link to="/CalcMaintenance" v-if=" this.$session.get('roll_id') == 2 || roll_id == 2 " class="home nav-link">maintenance</router-link>


        <ul class="nav home nav-link" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Member setting
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
            <li>
                <router-link to="/register">AddMember</router-link>
            </li>
            <li>
                <router-link to="/viewMember" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1" >View member</router-link>
            </li>
            </ul>
        </li>
        </ul>

        <ul class="nav home nav-link" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            General setting
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
            <li>
                <router-link to="/addblock">Add block</router-link>
                <!-- <a href="#" v-on:click="logout">Logout</a> -->
            </li>
            <li>
                <router-link to="/addFlatType">Add Flat type</router-link>
                <!-- <a href="#" v-on:click="logout">Logout</a> -->
            </li>
            <li>
                <router-link to="/maintenance" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1">Add charge</router-link>
            </li>
            </ul>
        </li>
        </ul>
        <ul class="nav home nav-link" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Communication
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
            <li>
                <router-link to="/notice">New Notice</router-link>
            </li>
            <li>
                <router-link to="/viewcomplain">Complaints</router-link>
            </li>
            <li>
                <!-- <router-link to="/maintenance" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1">Add charge</router-link> -->
            </li>
            </ul>
        </li>
        </ul>
        <router-link to="/ViewLog" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1" class="home nav-link">View Log</router-link>

            <!-- member complain -->
            <ul class="nav home nav-link" v-if=" this.$session.get('roll_id') == 2 || roll_id == 2">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Complains
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    <li>
                         <router-link to="/complain" >New Complain</router-link>
                    </li>
                    <li>
                        <router-link to="/complainView" >View Complain</router-link>
                    </li>
                    <li>
                        <!-- <router-link to="/maintenance" v-if=" this.$session.get('roll_id') == 1 || roll_id == 1">Add charge</router-link> -->
                    </li>
                    </ul>
                </li>
            </ul>

        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            Welcome
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{this.$session.get('name')}}
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
            <li>
                <!-- <router-link to="/" v-on:click="logout()">Logout</router-link> -->
                <a href="#" v-on:click="logout">Logout</a>
            </li>
            <li>
                <router-link to="/profile">Profile</router-link>
                <!-- <a href="#" v-on:click="logout">Logout</a> -->
            </li>
            </ul>
        </li>
        </ul>
    </div>
  </nav>
</template>
<script>
export default {
    data(){
        return{
            roll_id: '',
    }
    },
  mounted(){
      this.user()
  },
  methods: {
    user(){
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
         axios.get("/api/getuser").then( response => {
        this.roll_id = response.data
        this.$session.set('roll_id',response.data)
        this.$store.commit('changRoll_id',response.data);
      })
    },
    logout() {
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
      axios.post(this.$url + "logout").then(response => {
        this.$session.destroy();
        setTimeout(() => {
          this.$router.push("/");
        }, 100);
      });
    },

  }
};
</script>

<style>
.right {
  float: right;
  margin-left: 75%;
  color: #fff;
}
.right-1 {
  margin-left: 2%;
  color: #fff;
}
.home {
  color: #fff;
}
.dropdown,
.dropdown-toggle {
  color: #fff;
}
.dropdown-menu {
  color: #fff;
}
.navbar>.container, .navbar-nav {display: inline-block;}
.home { float: left;}
.navbar-nav { float: right;}
.navbar-nav li { padding: .5rem 1rem;}
</style>
