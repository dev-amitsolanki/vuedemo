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
                    <table class="table table-bordered">
                        <tr>
                             <th>Sr.</th>
                             <th>Complain type</th>
                             <th>Date</th>
                             <th>Complain To</th>
                             <th>Contact Number</th>
                             <th>Related for</th>
                             <th>Message</th>
                             <th>Status</th>
                             <th>Closed By</th>
                             <th>Resolution</th>
                        </tr>
                        <tr style="text-align:center;" v-if="this.complains.length == 0" ><td colspan="11"><strong>No Complain found!!</strong></td></tr>
                        <tr v-for="(data, index) in complains" :key="index">
                            <td scope="row">{{ index+1 }}</td>
                             <td>{{ data.message_type }}</td>
                             <td>{{ data.date }}</td>
                             <td>{{ data.complain_to }}</td>
                             <td>{{ data.number }}</td>
                             <td>{{ data.related_for }}</td>
                             <td>{{ data.message }}</td>
                             <td>{{ data.status }}</td>
                             <td>{{ data.closed_by }}</td>
                             <td>{{ data.resolution }}</td>
                        </tr>
                    </table>
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
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import navbarComponent from '../navbarComponent';
export default {
    components:{
        navbarComponent
    },
    data(){
        return{
            navbarComponent: navbarComponent,
            complains:'',
            pagination:{}
        }
    },
    created(){
        this.data();
    },
    methods:{
        data(pagi){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            pagi = pagi || 'api/complainData'
            axios.get(pagi)
            .then( response => {
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
            .catch( error =>{
                console.log(error)
            })
        }
    }
}
</script>

