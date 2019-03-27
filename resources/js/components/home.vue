<template>
  <div>
    <keep-alive>
      <component :is="navbarComponent"></component>
    </keep-alive>
    <div v-if="successMessageArr.length > 0" class="alert alert-success alert-dismissible fade in">
      <a class="close" data-dismiss="alert" aria-label="close" @click="emptyMessage">&times;</a>
      <strong v-for="(ss,index) in successMessageArr" :key="index">{{ ss }}</strong>
    </div>
    <div class="container">
        <div class="content text-center">
            <h3>Wel come {{this.$session.get('name')}}</h3>
        </div>
        <div class="row" v-if="roll_id == 1">
            <div class="col-sm">
                <div class="card">
                    <div class="card-header">Total member</div>
                    <div class="card-body">{{total}}</div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-header">Total member</div>
                    <div class="card-body">{{total}}</div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-header">Total member</div>
                    <div class="card-body">{{total}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-header">
                    <h3 style="text-align:center;">Notice</h3>
                </div>
                <div class="card-body">
                    <ol v-for="(data, index) in Notice" :key="index">
                        <div class="row"><p v-if="data.notice_type == 'warning'" style="color:orange;" >{{ data.notice }}</p></div>
                        <div class="row"><p v-if="data.notice_type == 'danger'"  style="color:red;">{{ data.notice }}</p></div>
                        <div class="row"><p v-if="data.notice_type == 'normal'"  >{{ data.notice }}</p></div>

                        <!-- <li v-if="data.notice_type == 'warning'" class="alert-warning">{{ data.notice }}</li> -->
                        <!-- <li v-if="data.notice_type == 'danger'" class="alert-danger">{{ data.notice }}</li> -->
                        <!-- <li v-if="data.notice_type == 'normal'">{{ data.notice }}</li> -->
                    </ol>
                </div>
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
      navbarComponent: navbarComponent,
      successMessageArr: [],
      total: "",
      roll_id: '',
      Notice:'',
      amit: 'danger'
    };
  },
  mounted() {
    this.user();
    this.totalMember();
    this.getflatType();
    this.getBlock();
    this.getnotice();
  },
  methods: {

      totalMember() {
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
      var _this = this;
      axios.get("/api/getmember", {
      }).then(response => {
        this.total = response.data.data.data.length;
      });
    },
    user(){
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
         axios.get("/api/getuser").then( response => {
        this.roll_id = response.data
        this.$session.set('roll_id',response.data)
        this.$store.commit('changRoll_id',response.data);
      })
    },
    getflatType(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

            axios.get('api/getflatType').then( response => {
                this.$session.set('flat_type',response.data);
           });
    },
    getBlock(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.get('api/getBlock')
            .then( response => {
                this.$session.set('block',response.data);
           })
    },
    getnotice(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.get('api/NoticeGet').then(response => {
                this.Notice = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },

  }
};
</script>



