import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
export const store = new Vuex.Store({
    state:{
        roll_id:''
    },
    mutations: {
        changRoll_id(state,value){
            state.roll_id = value
        }
    }

});
