<template>
    <div>
        <div>
            <keep-alive>
                <component :is="navbarComponent"></component>
            </keep-alive>
        </div>
        <div class="container">
            <div class="card" style="width: 50rem; margin-left:10%;">
                <div class="card-header">
                    <h2>Block<button type="button" class="btn btn-sm bg-primary float-right" style="color:#fff;" data-toggle="modal" data-target="#addModal">Add Block</button>
                    <button type="button" class="btn btn-sm bg-danger float-left">
                    <router-link to="home" style="color:#fff;">Back</router-link>
                    </button></h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr.</th>
                            <th>Block</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                        <tbody>
                        <tr v-if="this.blocks.length == 0" ><td colspan="3" style="text-align:center;"><strong>No record found!</strong></td></tr>
                        <tr  v-for="(data , index) in blocks" :key="index">
                            <td>{{ index +  1 }}.</td>
                            <td>{{ data.block }}</td>
                            <td style="text-align:center;">
                                <!-- <button type="button" class="btn btn-sm bg-primary" data-toggle="modal" data-target="" style="color:#fff;">Edit</button> -->
                                <button type="button" data-toggle="modal" @click="deleteModal; setVal(data.id)" data-target="#deleteModal" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- add block model -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Block</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="onSubmit">
                        <div class="modal-body">
                            <label>Enter block name:</label>
                            <input type="text" v-model="block" placeholder="Enter block name" class="form-control">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <div style="float:right;">
                            <button type="button" class="btn btn-sm btn-danger" id="close" data-dismiss="modal">Close</button>
                            <input type="submit" value="Submit" class="btn btn-sm btn-success" >
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- add modal close -->
            <!-- delete modal start -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-danger text-white">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete block</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure want to delete the block?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-warning" id="deleteclose" data-dismiss="modal">No</button>
                            <button type="button" v-on:click="deleteBlock(id)" class="btn btn-sm btn-default">Yes i do!</button>
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
            block: '',
            blocks: ''
        }
    },
    created(){
        this.getBlock();
    },
    methods:{
        setVal(id){
            this.id = id;
        },
        onSubmit(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.post(this.$url + 'api/addblock',{
                block: this.block
            }).then(response => {
                this.block = '';
                document.getElementById('close').click();
            })
            .catch(error => {
                console.log(error);
            })
                this.getBlock();
                // $("#addModal").modal("hide");
                // $('.modal-backdrop ').css("position", "initial");
        },
        getBlock(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.get('api/getBlock')
            .then( response => {
                this.blocks = response.data
                console.log(response.data);

            })
        },
        deleteModal(data){
            $("#deleteModal").modal("show");
        },
        deleteBlock(id){

            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');

            axios.delete(this.$url + 'api/deleteBlock' + '/' + id )
            .then( response => {
                this.getBlock();
                document.getElementById('deleteclose').click();
            })
            .catch(error => {
                console.log(error)
            })
            // $("#deleteModal").modal("hide");
            // $('.modal-backdrop ').css("position", "initial");
        }
    }
}
</script>
<style>
    .card{
        margin-top: 10%;
    }
    h2{
        text-align: center;
    }
    .modal{
        margin-top: 10%
    }
</style>

