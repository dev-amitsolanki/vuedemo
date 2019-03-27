<template>
<div>
    <div>
    <keep-alive>
      <component :is="navbarComponent"></component>
    </keep-alive>
    <div class="alert-success">
        <flash-message></flash-message>
    </div>
    </div>
    <div class="container">
    <div class="card">
      <div class="card-header">
        <h2>View member<button type="button" class="btn bg-primary float-right">
            <router-link to="home" style="color:#fff;">Back</router-link>
          </button></h2>
        <div class="pull-left">

        </div>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tr>
            <th>name</th>
            <th>E-mail</th>
            <th>Mobile</th>
            <th>Flat-no</th>
            <th>Block</th>
            <th>Flat-type</th>
            <th>Flat-area</th>
            <th>Parking</th>
            <th colspan="2">Actions</th>
          </tr>

          <tbody>
            <tr v-for="(data, index) in items" :key="index">
              <td>{{ data.name }}</td>
              <td>{{ data.email }}</td>
              <td>{{ data.number }}</td>
              <td>{{ data.flat_no }}</td>
              <td>{{ data.block }}</td>
              <td>{{ data.flat_type }}</td>
              <td>{{ data.flat_area }}</td>
              <td>{{ data.parking }}</td>
              <td>
                <button type="button" data-toggle="modal" @click="editmodal; setVal(data.id,data.name,data.email,data.number,data.flat_no,data.block,data.flat_type,data.flat_area,data.parking)" data-target="#viewModal" class="btn btn-info btn-sm">Edit</button>
              </td>
              <td>
                <button type="button" data-toggle="modal" @click="deletemodal; setVal(data.id)" data-target="#deleteModal" class="btn btn-danger btn-sm">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- pagination link start -->
        <div class="row">
                        <div class="col-md-8">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-bind:class="{disabled:!pagination.first_link}">
                                        <a href="#" @click="getItems(pagination.first_link)" class="page-link">&laquo;</a>
                                    </li>
                                    <li class="page-item" v-bind:class="{disabled:!pagination.pre_link}">
                                        <a href="#" @click="getItems(pagination.pre_link)" class="page-link">&lt;</a>
                                    </li>
                                    <li class="page-item" v-for="n in pagination.last_page" v-bind:key="n" v-bind:class="{active:pagination.current_page == n}">
                                        <a href="#" @click="getItems(pagination.path_page + n)" class="page-link">{{n}}</a>
                                    </li>
                                    <li class="page-item" v-bind:class="{disabled:!pagination.next_link}">
                                        <a href="#" @click="getItems(pagination.next_link)" class="page-link">&gt;</a>
                                    </li>
                                    <li class="page-item" v-bind:class="{disabled:!pagination.last_link}">
                                        <a href="#" @click="getItems(pagination.last_link)" class="page-link">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
        <!-- pagination link close -->
        <!-- Edit model -->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="editMember(data)" class="form-group">
                <div class="modal-body">
                  <input
                    type="hidden"
                    disabled
                    class="form-control"
                    name="id"
                    required
                    :value="this.id"
                  >
                  <div class="form-group">
                    Name:
                    <input type="text" name="name" id="name" v-model="name" class="form-control">
                  </div>
                  <div class="form-group">
                    Email:
                    <input type="email" v-model="email" name="email" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <div class="row">
                        <div class="col-sm">
                            Mobile-number:
                            <input type="number" v-model="number" name="number" id="number"  class="form-control">
                        </div>
                        <div class="col-sm">
                            Flat-number:
                            <input type="number" v-model="flat_no" name="flat_no" id="flat_no" class="form-control">
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
                            Flat-area:
                            <input type="number" v-model="flat_area" name="flat_area" id="flat_area" class="form-control">
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    Do you want to use parking:
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" v-model="parking" name="parking" id="parking" v-validate="{required:true}" value="yes" :checked="this.parking == 'yes'" >yes
                        <!-- <label class="form-check-label" for="inlineRadio1">1</label> -->
                    </div>
                    <div class="form-check form-check-inline">
                        <input clas="form-check-input" type="radio" v-model="parking" name="parking"  id="parking" v-validate="{required:true}" value="no" :checked="this.parking == 'no'" >No
                        <!-- <label class="form-check-label" for="inlineRadio2">2</label> -->
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" id="Editclose" data-dismiss="modal">Close</button>
                  <button type="button" v-on:click="editMember" class="btn btn-default btn-sm">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Edit model END -->
        <!-- Delete model start -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-danger text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Delete member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                 <div class="modal-body">
                    Are you sure want to delete this member?
                    </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" id="deleteclose" data-dismiss="modal">Close</button>
                    <button type="button" v-on:click="deleteItem(id)" class="btn btn-default btn-sm">Submit</button>
                 </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
import navbarComponent from "./navbarComponent.vue";
export default {
  components: {
    navbarComponent,
  },
  mounted() {
    this.getItems();
  },
  data() {
    return {
      navbarComponent: navbarComponent,
      items: "",
      id: "",
      name: "",
      email: "",
      number: "",
      flat_no: "",
      block: "",
      flat_type: "",
      flat_area: "",
      parking: "",
      yes: "",
      no: "",
      checked: true,
      errorMessage: [],
       pagination:{}
    };
  },
  methods: {
    getItems(pagi) {
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
      pagi = pagi || 'api/getitems'
      axios.get(pagi).then( response => {
        this.items = response.data.data.data
        this.pagination = {
                    current_page: response.data.data.current_page,
                    last_page: response.data.data.last_page,
                    from_page: response.data.data.from,
                    to_page:response.data.data.to,
                    total_page: response.data.data.total_page,
                    path_page: response.data.data.path + '?page=',
                    first_link: response.data.data.first_page_url,
                    last_link: response.data.data.last_page_url,
                    pre_link: response.data.data.prev_page_url,
                    next_link: response.data.data.next_page_url
                }
      });
    },
    setVal(
      id,
      name,
      email,
      number,
      flat_no,
      block,
      flat_type,
      flat_area,
      parking
    ) {
      this.id = id;
      this.name = name;
      this.email = email;
      this.number = number;
      this.flat_no = flat_no;
      this.block = block;
      this.flat_type = flat_type;
      this.flat_area = flat_area;
      this.parking = parking;
    },
    editmodal(data) {
      $("#viewModal").modal("show");
    },
    deletemodal(data){
        $("#deleteModal").modal("show");
    },
    editMember() {
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
      axios
        .put(this.$url + "api/edit" + "/" + this.id, {
          name: this.name,
          email: this.email,
          number: this.number,
          flat_no: this.flat_no,
          block: this.block,
          flat_type: this.flat_type,
          flat_area: this.flat_area,
          parking: this.parking
        })
        .then(response => {
          this.getItems();
          setTimeout(() => {
                this.$router.push("viewMember");
                this.flash(response.data.message, 'success', {
                timeout: 3000,
                   });
              }, 1000);
            document.getElementById('Editclose').click();
        })
        .catch(error => {});

    },
    deleteItem(id) {
      axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
      axios.delete(this.$url + "api/delete" + "/" + id).then(response => {
        this.getItems();
        this.flash(response.data.message, 'danger', {
                timeout: 3000,
                   });
       document.getElementById('deleteclose').click();
      })
      .catch(error => {});

    }
  }
};
</script>
<style>
h2 {
  text-align: center;
}
.card {
  margin-top: 5%;
}
</style>


