<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="page" >


        <div class="content bg" id="content">
            <div id="head">
                <img src="../imgs/m-banner.jpg" align="absmiddle">
            </div>
            <!--<div class="buttons-tab fixed-tab" data-offset="0">-->
            <div class="buttons-tab bor-style">
                <a v-for='item in navigations' v-text="item.text"  @click="choice($index)"
                   class="tab-link button" :class="{active:item.isFocus}" ></a>
            </div>
            <!--@click="choice($index)"-->

            <div class="tabs">

                <!--transition="fade"-->
                <router-view transition="fade"
                             transition-mode="out-in" keep-alive></router-view>
            </div>
        </div>
        <nav class="bar bar-tab">
            <table width="100%" height="100%" class="cy">

                <tr @click="canyu">

                    <td align="center">
                        <span >我要参与</span>
                    </td>

                </tr>

            </table>
        </nav>
    </div>

</template>

<script>
    export default {
        route:{
            data ({ to }) {
                document.title = "2016寻找中国幕墙之最";
                this.navigations.map(function (v, i) {
                    '/'+to.name == v.path ?v.isFocus = true:v.isFocus = false;
                });
              //  vm.tel = to.params.tel;
            },
            activate:function(transition){
//                this.navigations.map(function (v, i) {
//                    transition.to.name == v.path ?v.isFocus = true:v.isFocus = false;
//                });
                transition.next();
            }
        },
        ready () {
//            alert(1);
        },
        data () {
            return {
                navigations: [
                    {path: '/index', text: '活动说明', isFocus: false,append: false},
                    {path: '/rule', text: '活动规则', isFocus: false,append: false},
                    {path: '/zuop', text: '参评项目', isFocus: false,append: false},
                    {path: '/jl', text: '奖项设置', isFocus: false,append: false},
                ]
            }
        },
        methods: {
            choice: function (index) {
                this.navigations.map(function (v, i) {
                    i == index ? v.isFocus = true : v.isFocus = false;
                });
                this.$route.router.go(this.navigations[index].path)
            },
            canyu:function(){
                this.$route.router.go('/cany1')
            }
        }
    }
</script>
<style lang="less" scoped>

    .fade-transition {
        transition: opacity .1s ease;
    }

    .fade-enter, .fade-leave {
        opacity: 0;
    }

    #head img {
        width: 100%;
    }

    .tabs{
        padding-bottom: 3rem;
    }
    @media screen and (min-width: 768px) {
        .myfont {
            font-size: 24px;
        }
    }
    .bor-style{
        padding-right: 0.5em;
        padding-left: 0.5em;
    }
    .buttons-tab .button.active{
        font-weight: bold;
        border-bottom: 2px solid #fff;
    }


</style>


