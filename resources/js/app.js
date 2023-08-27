import './bootstrap';
import '../sass/app.scss'

import Router from '@/router'
import Store from '@/store'
import { createApp } from 'vue/dist/vue.esm-bundler';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const app = createApp({})

app.use(Router)
app.use(Store)
app.use(ElementPlus)
app.mount('#app')
