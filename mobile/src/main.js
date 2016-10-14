import './lib/sui/less/sm.less';
import './lib/common/common.less';
import Vue from 'vue'
import Router from 'vue-router'


//import App from './components/App.vue'

import Product from './components/Product.vue'
import Index from './components/Index.vue'
import Jl from './components/Jiangli.vue'
import Rule from './components/Rule.vue'
import Zuop from './components/Zuop.vue'
import ZuopDetail from './components/ZuopDetail.vue'

import Cany1 from './components/Cany1.vue'
import Cany2 from './components/Cany2.vue'
import Success from './components/Success.vue'



//import NewsView from 'components/NewsView.vue'
//import ItemView from 'components/ItemView.vue'
//import UserView from 'components/UserView.vue'

//const App = Vue.extend({
//  components: {
//    Index
//  }
//})
// install router
Vue.use(Router)

// register filters globally
//Vue.filter('fromNow', fromNow)
//Vue.filter('domain', domain)

// routing

//
//var router = new Router({
//    history:true,
//    rootUrl:"/root",
//    defaultUrl:"/root"
//});
const router = new Router({
    //history: true,
    saveScrollPosition: true,
    defaultUrl:"/"
});
router.map({
    '/': {
        component: Product,
        subRoutes: {
            '/': {
                name:'index',
                component:Index
            },
            '/jl':{
                name:'jl',
                component:Jl
            },
            '/rule':{
                name:'rule',
                component:Rule
            },
            '/zuop':{
                name:'zuop',
                component:Zuop
            },
            '/zuop/:tel':{
                name:'zuop',
                component:Zuop
            }
        }
    },
    '/cany1':{
        name:'cany1',
        component:Cany1
    },
    '/cany1/:work_id/:uid':{
        name:'cany1',
        component:Cany1
    },
    '/cany2/:info':{
        name:'cany2',
        component:Cany2
    },
    '/cany2/:work_id/:info':{
        name:'cany2',
        component:Cany2
    },
    '/success/:tel':{
        name:'success',
        component:Success
    },
    '/detail/:id':{
        name:'detail',
        component:function (resolve) {
            require(['./components/ZuopDetail.vue'], resolve)
        }
    }
    //'/news/:page': {
    //  component: App
    //}
    //'/user/:id': {
    //  component: UserView
    //},
    //'/item/:id': {
    //  component: ItemView
    //}
})
//
//router.beforeEach(function () {
//  window.scrollTo(0, 0)
//})
//
router.redirect({

    '*': '/'
    //'/success':'/detail/:id'
})
const App = Vue.extend({
    components: {
        Product,
        Index,
        Jl,
        Rule,
        Zuop,
        Cany1,
        Cany2,
        Success
    }
});
router.start(App, '#app')
