import axios from 'axios'
import { http_build_query } from '@/helpers.js'

export default {
    namespaced: true,
    state:{
        list:[]
    },
    getters:{
        list(state){
            return state.list
        }
    },
    mutations:{
        SET_LIST (state, value) {
            state.list = value;
        },
        SET_ITEM (state, value) {
            state.list.push(Object.assign({}, value))
        }
    },
    actions:{
        list({commit},params){

            return axios.get('/api/v1/requests?'+http_build_query(params)).then((response)=> {
                commit('SET_LIST',response.data.data)
                return response;
            })
        },
        item({commit},id){
            return axios.get('/api/v1/requests/'+id).then((response)=> {
                return response;
            })
        },
        store({commit},item){
            return axios.post('/api/v1/requests',item).then((response)=> {
                return response;
            })
        },
        answer({commit},{ id,answer }){
            console.log(answer)
            return axios.put('/api/v1/requests/'+id+'/change-status',answer).then((response)=> {
                return response;
            })
        },
        delete({},id){
            return axios.delete('/api/v1/requests/' + id).then((response)=> {
                return response;
            })
        },
    }
}
