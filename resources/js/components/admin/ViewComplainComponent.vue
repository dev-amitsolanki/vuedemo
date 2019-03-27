<template>
    <div>
        <div>
            <keep-alive :is="navbarComponent"></keep-alive>
        </div>
        <div>
             <div class="card" style="margin-top:5%;">
                 <div class="card-header">
                     <h2 style="text-align:center;"> View Complains
                         <button type="button" class="btn btn-sm bg-danger float-left">
                    <router-link to="home" style="color:#fff;">Back</router-link>
                    </button>
                     </h2>
                 </div>
                 <div class="card-body">
                     <table class="table table-bordered table-hover table-striped">
                         <tr>
                             <th>Sr.</th>
                             <th>Complain type</th>
                             <th>Date</th>
                             <th>Complain from</th>
                             <th>Contact Number</th>
                             <th>Related to</th>
                             <th>Message</th>
                             <th>Status</th>
                             <th>Closed By</th>
                             <th>Resolution</th>
                             <th colspan="2" style="text-align:center;">Action</th>
                         </tr><tr style="text-align:center;" v-if="this.complains.length == 0" ><td colspan="11"><strong>No Complain found!!</strong></td> </tr>
                         <tr v-for="(data, index) in complains" :key="index">
                             <td scope="row">{{ index+1 }}</td>
                             <td>{{ data.message_type }}</td>
                             <td>{{ data.date }}</td>
                             <td>{{ data.name }}</td>
                             <td>{{ data.number }}</td>
                             <td>{{ data.related_for }}</td>
                             <td>{{ data.message }}</td>
                             <td>{{ data.status }}</td>
                             <td>{{ data.closed_by }}</td>
                             <td>{{ data.resolution }}</td>
                             <td>
                                 <button class="btn btn-primary btn-sm" @click="editModal; setVal(data.id)" data-toggle="modal" data-target="#editModal">Edit</button>
                             </td>
                             <td>
                                 <button class="btn btn-sm btn-danger" @click="deleteModal; setVal(data.id)" data-toggle="modal" data-target="#deleteModal">Delete</button>
                             </td>
                         </tr>
                     </table>
                    <!-- pagination link start -->
                        <div class="row">
                            <div class="col-md-8">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item" v-bind:class="{disabled:!pagination.first_link}">
                                            <a href="#" @click="data(pagination.first_link)" class="page-link">&laquo;</a>
                                        </li>
                                        <li class="page-item" v-bind:class="{disabled:!pagination.pre_link}">
                                            <a href="#" @click="data(pagination.pre_link)" class="page-link">&lt;</a>
                                        </li>
                                        <li class="page-item" v-for="n in pagination.last_page" v-bind:key="n" v-bind:class="{active:pagination.current_page == n}">
                                            <a href="#" @click="data(pagination.path_page + n)" class="page-link">{{n}}</a>
                                        </li>
                                        <li class="page-item" v-bind:class="{disabled:!pagination.next_link}">
                                            <a href="#" @click="data(pagination.next_link)" class="page-link">&gt;</a>
                                        </li>
                                        <li class="page-item" v-bind:class="{disabled:!pagination.last_link}">
                                            <a href="#" @click="data(pagination.last_link)" class="page-link">&raquo;</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                 <!-- pagination link close -->
                 </div>
            </div>
            <!-- edit modal start -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit</h5>
                            <button  type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-label="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="onSubmit">
                            <div class="modal-body">
                                <label>Resolution:</label>
                                <textarea class="form-control" v-model="resolution"></textarea>
                                <label>Status:</label>
                                <select name="block" v-model="status" class="form-control">
                                    <option value="complete">Complete</option>
                                    <option value="processing">Processing</option>
                                </select>

                            </div>
                            <div class="modal-footer">
                                 <div style="float:right;">
                                     <button type="button" class="btn btn-sm btn-danger" id="editClose" data-dismiss="modal">Close</button>
                                     <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                 </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- edit modal close -->
            <!-- delete modal start -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete complain</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-label="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure want to delete this complain ?
                        </div>
                        <div class="modal-footer">
                            <div style="float:right;">
                                <button type="button" class="btn btn-sm btn-danger" id="deleteClose" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-success" v-on:click="deleteComplain(id)">Yes i do!!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- delete modal close -->
        </div>
    </div>
</template>
<script>
import navbarComponent from '../navbarComponent.vue';
export default {
    component:{
        navbarComponent
    },
    data(){
        return{
            navbarComponent: navbarComponent,
            complains: '',
            id: '',
            resolution:'',
            status: '',
            pagination:{}
        }
    },
    created(){
        this.data();
    },
    methods:{
        data(pagi){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            pagi = pagi || 'api/getcomplain'
            axios.get(pagi).then( response => {
                this.complains = response.data.data.data
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
            })
        },
        setVal(id){
            this.id = id;
        },
        editModal(){
            $("#editModal").modal("show");
        },
        deleteModal(){
            $("#deleteModal").modal("show");
        },
        onSubmit(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.put(this.$url + "api/submitResolution"+ "/" + this.id,{
                resolution: this.resolution,
                status: this.status
            })
            .then( response =>{
                this.data();
                console.log(response.data)
            })
            .catch(error => {
                console.log(error)
            })

            document.getElementById("editClose").click();
        },
        deleteComplain(id){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.delete(this.$url + "api/deleteComplain" + "/" + id )
            .then( response => {
                this.data();
                console.log(response.data)
            })
            .catch( error => {
                console.log(error)
            })
            document.getElementById("deleteClose").click();
        }
    }
}
</script>
<style>
.modal{
        margin-top: 10%
    }

</style>

