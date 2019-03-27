<template>
    <div>
        <keep-alive :is="navbarComponent"></keep-alive>
        <div class="container">
            <div class="card" style="margin-top:10%;">
                <div class="card-header">
                    <h2 style="text-align:center;">Notice
                        <button type="button" class="btn btn-sm bg-primary float-right" style="color:#fff;" data-toggle="modal" data-target="#newNotice">Add New Notice</button>
                    <button type="button" class="btn btn-sm bg-danger float-left">
                    <router-link to="home" style="color:#fff;">Back</router-link>
                    </button>
                    </h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr.</th>
                            <th>Notice Type</th>
                            <th>Notice for</th>
                            <th>Notice</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <tr v-if="this.Notice.length == 0"><td colspan="6" style="text-align:center;"><strong>No Data Available!</strong></td></tr>
                        <tr v-for="(data, index) in Notice" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ data.notice_type }}</td>
                            <td>{{ data.notice_for }}</td>
                            <td>{{ data.notice}}</td>
                            <td style="text-align:center;">
                                <input type="checkbox" class="checkbox" @click="(setVal(data.id)), (onchange = !onchange)" :checked="data.status == 'active'">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    </table>
                    <!-- pagination link start -->
                        <div class="row">
                            <div class="col-md-8">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item" v-bind:class="{disabled:!pagination.first_link}">
                                            <a href="#" @click="getnotice(pagination.first_link)" class="page-link">&laquo;</a>
                                        </li>
                                        <li class="page-item" v-bind:class="{disabled:!pagination.pre_link}">
                                            <a href="#" @click="getnotice(pagination.pre_link)" class="page-link">&lt;</a>
                                        </li>
                                        <li class="page-item" v-for="n in pagination.last_page" v-bind:key="n" v-bind:class="{active:pagination.current_page == n}">
                                            <a href="#" @click="getnotice(pagination.path_page + n)" class="page-link">{{n}}</a>
                                        </li>
                                        <li class="page-item" v-bind:class="{disabled:!pagination.next_link}">
                                            <a href="#" @click="getnotice(pagination.next_link)" class="page-link">&gt;</a>
                                        </li>
                                        <li class="page-item" v-bind:class="{disabled:!pagination.last_link}">
                                            <a href="#" @click="getnotice(pagination.last_link)" class="page-link">&raquo;</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                 <!-- pagination link close -->
                </div>
            </div>
            <!-- new notice modal start -->
            <div class="modal fade" id="newNotice" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Notice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-label="true">&times;</span>
                            </button>
                        </div>
                    <form @submit.prevent="onSubmit">
                        <div class="modal-body">
                                <br>
                                <label>Notice Type:</label>
                                <select class="form-control" v-model="notice_type">
                                    <option value="normal">Normal</option>
                                    <option value="warning">Warning</option>
                                    <option value="danger">Alert</option>
                                </select>
                                <label>Notice For:</label>
                                <input type="text" class="form-control" v-model="notice_for">
                                <label for="notice">Notice:</label>
                                <textarea class="form-control" v-model="notice"></textarea>
                                <br>
                        </div>
                        <div class="modal-footer">
                            <div style="float:right;">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="noticeClose">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import navbarComponent from '../navbarComponent';
export default {
    components:{
        navbarComponent,

    },
    data(){
        return{
            navbarComponent: navbarComponent,
            notice: '',
            notice_type: '',
            notice_for: '',
            Notice: '',
            onchange: false,
            id: '',
            pagination:{}
        }
    },
    created(){
        this.getnotice();
    },
    methods:{

        setVal(id){
            this.id = id
            this.onclick()
        },
        onSubmit(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.post(this.$url + 'api/newNotice',{
                notice_type: this.notice_type,
                notice_for: this.notice_for,
                notice: this.notice
            })
            .then(response => {
                document.getElementById('noticeClose').click();
                console.log(response.data)
            })
            .catch(error => {
                console.log(error)
            })
            this.getnotice();
        },
        getnotice(pagi){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            pagi = pagi || 'api/getnotice'
            axios.get(pagi).then(response => {
                this.Notice = response.data.data.data
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
            .catch(error => {
                console.log(error)
            })
        },
        onclick(){
            if(this.onchange == true){
                    this.status = 'inactive'
                }else{
                    this.status = 'active'
                }
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.put(this.$url + 'api/status/' + this.id,{
                status: this.status
            })
            .then(response => {
                })
            .catch( error => {
                console.log(error)
            })
                this.getnotice();
        }
    }
}
</script>
<style>
    h2{
        text-align:center;
    }
</style>

