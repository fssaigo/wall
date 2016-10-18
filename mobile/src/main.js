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
                title:'2016寻找中国幕墙之最',
                component:Index
            },
            '/jl':{
                name:'jl',
                title:'奖项设置',
                component:Jl
            },
            '/rule':{
                name:'rule',
                title:'活动规则',
                component:Rule
            },
            '/zuop':{
                name:'zuop',
                title:'参评项目',
                component:Zuop
            },
            '/zuop/:tel':{
                name:'zuop',
                title:'作品展示',
                component:Zuop
            }
        }
    },
    '/cany1':{
        name:'cany1',
        title:'我要报名',
        component:Cany1
    },
    '/cany1/:work_id/:uid':{
        name:'cany1',
        title:'我要报名',
        component:Cany1
    },
    '/cany2/:info':{
        name:'cany2',
        title:'作品提交',
        component:Cany2
    },
    '/cany2/:work_id/:info':{
        name:'cany2',
        title:'作品提交',
        component:Cany2
    },
    '/success/:tel':{
        name:'success',
        title:'作品展示',
        component:Success
    },
    '/detail/:id':{
        name:'detail',
        title:'作品展示',
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



const iframeLoad = function (src) {
    let iframe = document.createElement('iframe')
    iframe.style.display = 'none'
    iframe.src = src
    document.body.appendChild(iframe)
    iframe.addEventListener('load', function () {
        setTimeout(function () {
            iframe.remove()
        }, 0)
    })
}
// document title change
/**
router.afterEach((transition) => {
    document.title = transition.to.title;
    if (navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
        let src = '/static/fixrouter.html?' + Math.random()
        iframeLoad(src)
    }
})
 */
router.afterEach(function (transition) {
    document.title = transition.to.title;
    if (navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
        var src = '/static/fixrouter.html?' + Math.random()
        iframeLoad(src)
    }
});


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
