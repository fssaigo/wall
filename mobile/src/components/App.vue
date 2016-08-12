<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="page">


        <div class="content bg">
            <div id="head">
                <img src="../imgs/m-banner.jpg" align="absmiddle">
            </div>
            <!--<div class="buttons-tab fixed-tab" data-offset="0">-->
            <div class="buttons-tab bor-style">
                <a v-for='item in navigations' v-text="item.text"
                   class="tab-link button" :class="{active:item.isFocus}" @click="choice($index)"></a>
            </div>

            <div class="tabs">
                <!--transition="fade"-->
                <router-view transition="fade"
                             transition-mode="out-in" keep-alive></router-view>
            </div>
        </div>
        <nav class="bar bar-tab">
            <table width="100%" height="100%" class="cy">
                <tr>
                    <td align="center">
                        <a href="#">我要参与</a>
                    </td>
                </tr>
            </table>

        </nav>


    </div>

</template>

<script>

    export default {
        data () {
            return {
                navigations: [
                    {path: 'index', text: '活动说明', isFocus: true},
                    {path: 'jl', text: '奖项设置', isFocus: false},
                    {path: 'rule', text: '活动规则', isFocus: false},
                    {path: 'zuop', text: '作品展示', isFocus: false},
                ]
            }
        },
        methods: {
            choice: function (index) {
                this.navigations.map(function (v, i) {
                    i == index ? v.isFocus = true : v.isFocus = false;
                });
                this.$route.router.go(this.navigations[index].path)
            }
        }
    }
</script>
<style lang="less">
    @import "../lib/sui/less/sm.less";

    .fade-transition {
        transition: opacity .1s ease;
    }

    .fade-enter, .fade-leave {
        opacity: 0;
    }

    .line {
        border-bottom: 4px solid #00ffcc;
    }

    .bg {
        background-color: #0e2532;
        h3 {
            color: white;
        }
    }

    #head img {
        width: 100%;
    }

    .myfont {
        color: #9eaab1;
        font-size: 14px;
    }

    .cy a {
        color: black;
        font-weight: bold;
    }

    .foot {
        display: block;
        line-height: 4px;
        font-size: 14px;
        div {
            margin-top: 2rem;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }
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
    }
</style>


