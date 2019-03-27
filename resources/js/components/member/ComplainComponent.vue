<template>
    <div>
        <div>
            <keep-alive>
                <component :is="navbarComponent"></component>
            </keep-alive>
        </div>
        <div class="container">
            <div style="margin-top:5%;">
                <h2 style="text-align:center;">Complain</h2>
                <br><br>
                <form @submit.prevent="onSubmit" style="margin-left:30%">
                    <div class="form-group">
                        <label>Message type:</label>
                        <select class="form-control col-sm-4" v-model="message_type">
                            <option value="">Select Message Type</option>
                            <option value="complain">Complain</option>
                            <option value="suggetion">Suggetion</option>
                            <option value="request">Request</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Complain To:</label>
                        <select class="form-control col-sm-4" v-model="complain_to">
                            <option value="">Select Complain To</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Related for:</label>
                        <select class="form-control col-sm-4" v-model="related_for">
                            <option value="general">General</option>
                            <option value="water">Water</option>
                            <option value="security">Security</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message :</label>
                        <textarea class="form-control col-sm-6" v-model="message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>
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
            message_type : '',
            complain_to: '',
            related_for: '',
            message: ''
        }
    },
    methods:{
        onSubmit(){
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken');
            axios.post(this.$url + 'api/createComplain',{
                message_type: this.message_type,
                complain_to: this.complain_to,
                related_for: this.related_for,
                message: this.message
            }).then( response => {
                console.log(response.data)
                setTimeout(() => {
                    this.$router.push("home")
                },1000);
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
</script>
