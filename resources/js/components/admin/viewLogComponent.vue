<template>
    <div>
        <div>
            <keep-alive>
                <component :is="navbarComponent"></component>
            </keep-alive>
        </div>
        <div class="container">
            <div class="card" style=" margin-top:10%;">
                <div class="card-header">
                    <h2 style="text-align:center;">View Activity Log<button type="button" class="btn btn-sm bg-danger float-left">
                    <router-link to="home" style="color:#fff;">Back</router-link>
                    </button></h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Login id</th>
                            <th>Total Logged Count</th>
                            <th>Last Logged In</th>
                        </tr>
                        <tr v-for="(data , index) in logactivity" :key="index">
                            <td>{{ data.name }}</td>
                            <td>{{ data.email}}</td>
                            <td>{{ data.TotalCount }}</td>
                            <td>{{ data.last_login }}</td>
                        </tr>
                    </table>
                    <!-- pagination link start -->
        <div class="row">
                        <div class="col-md-8">
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-bind:class="{disabled:!pagination.first_link}">
                                        <a href="#" @click="logActivity(pagination.first_link)" class="page-link">&laquo;</a>
                                    </li>
                                    <li class="page-item" v-bind:class="{disabled:!pagination.pre_link}">
                                        <a href="#" @click="logActivity(pagination.pre_link)" class="page-link">&lt;</a>
                                    </li>
                                    <li class="page-item" v-for="n in pagination.last_page" v-bind:key="n" v-bind:class="{active:pagination.current_page == n}">
                                        <a href="#" @click="logActivity(pagination.path_page + n)" class="page-link">{{n}}</a>
                                    </li>
                                    <li class="page-item" v-bind:class="{disabled:!pagination.next_link}">
                                        <a href="#" @click="logActivity(pagination.next_link)" class="page-link">&gt;</a>
                                    </li>
                                    <li class="page-item" v-bind:class="{disabled:!pagination.last_link}">
                                        <a href="#" @click="logActivity(pagination.last_link)" class="page-link">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
        <!-- pagination link close -->
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
            logactivity: '',
            user: '',
            pagination:{}
        }
    },
    created(){
        this.logActivity();
    },
    methods:{
        logActivity(pagi){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            pagi = pagi || 'api/login-activity'
            axios.get(pagi).then( response => {
                this.logactivity = response.data.data.data
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
        }
    }
}
</script>
