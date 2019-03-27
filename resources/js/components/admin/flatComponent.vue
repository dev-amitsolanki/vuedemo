<template>
    <div>
        <div>
            <keep-alive>
                <component :is="navbarComponent"></component>
            </keep-alive>
        </div>
        <div class="container">
            <div class="card" style="width: 50rem; margin-left:10%; margin-top:10%;">
                <div class="card-header">
                    <h2 style="text-align:center;">Flat type<button type="button" class="btn btn-sm bg-primary float-right" style="color:#fff;" data-toggle="modal" data-target="#addModal">Add Flat type</button>
                    <button type="button" class="btn btn-sm bg-danger float-left">
                    <router-link to="home" style="color:#fff;">Back</router-link>
                    </button></h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr.</th>
                            <th>Flat-type</th>
                            <th>Actions</th>
                        </tr>
                        <tbody>
                            <tr v-if="this.FlatType.length == 0">
                                <td colspan="3" style="text-align:center;">
                                    <strong>No record found!</strong>
                                </td>
                            </tr>
                            <tr v-for="(data , index) in FlatType" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.flat_type }}</td>
                                <td style="text-align:center;">
                                <button type="button" data-toggle="modal" @click="deleteModal; setVal(data.id)" data-target="#deleteModal" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Add flat type modal start -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Flat type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="onSubmit">
                        <div class="modal-body">
                            <label>Enter flat type:</label>
                            <input type="text" class="form-control" v-model="flat_type" placeholder="EX. 1-BHK">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <div style="float:right;">
                                <button type="button" class="btn btn-sm btn-danger" id="addclose" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary" >Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add flat type modal close -->
        <!-- Delete flat type modal start -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-danger text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Flat type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete this flat type ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-m btn-warning" id="deleteclose" data-dismiss="modal">No</button>
                        <button type="submit" v-on:click="deleteFlatType(id)" class="btn btn-sm btn-default">Yes I do!</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
import navbarComponent from '../navbarComponent.vue';
export default {
    components:{
        navbarComponent
    },
    data(){
        return{
            navbarComponent: navbarComponent,
            flat_type: '',
            id:'',
            FlatType:'',
        }
    },
    created(){
        this.getflatType();
    },
    methods:{
        setVal(id){
            this.id = id;
        },
        deleteModal(data){
            $("#deleteModal").modal("show");
        },
        onSubmit(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

            axios.post(this.$url + "api/addFlatType",{
                flat_type:this.flat_type,
            })
            .then( response => {
                this.flat_type = '';
                document.getElementById('addclose').click();
            })
            .catch( error => {
                console.log(error)
            })
                this.getflatType();
        },
        getflatType(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

            axios.get('api/getflatType').then( response => {
                this.FlatType = response.data
            });
        },
        deleteFlatType(id){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

            axios.delete(this.$url + "api/deleteFlatType" + '/' + id)
            .then( response => {
                this.getflatType();
                document.getElementById('deleteclose').click();
            })
        }

    }
}
</script>
<style>
    .modal{
        margin-top: 10%
    }
</style>

