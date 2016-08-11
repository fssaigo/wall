import Vue from 'vue'
import Router from 'vue-router'
import App from './components/App.vue'
import Index from './components/Index.vue'
import Jl from './components/Jiangli.vue'
import Rule from './components/Rule.vue'
import Zuop from './components/Zuop.vue'
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
var router = new Router()

router.map({
    '/': {
        component: App,
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
})

router.start(App, '#app')
