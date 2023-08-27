import { createStore } from 'vuex'
import requests from '@/store/requests'

const store = createStore({
    modules:{
        requests
    }
})
export default store
