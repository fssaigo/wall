<template xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <div class="page">

        <div class="content bg re-padding">
            <div class="t-img">
                <img src="../imgs/cany1.png">
            </div>
            <p class="t-info">
                个人信息只做为联络及存档，不会在任何页面显示，*为必填项
            </p>

            <h5>个人信息</h5>
            <form>
                <div class="row">
                    <div class="col-25">姓名<i>*</i></div>
                    <div class="col-75">
                        <input type="text" v-model="info.name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">手机号<i>*</i></div>
                    <div class="col-75">
                        <input type="tel" v-model="info.mobile">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">公司</div>
                    <div class="col-75">
                        <input type="text" v-model="info.zzcompany">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">地址</div>
                    <div class="col-75">
                        <textarea v-model="info.address"></textarea>
                    </div>
                </div>
            </form>


        </div>
        <div class="bar bar-tab bg">
            <table width="100%" height="100%" class="next">
                <tr @click="next">
                    <td align="center">
                        <span >下一步</span>
                    </td>
                </tr>
            </table>

        </div>
    </div>

</template>
<script>
    //getCookie
    import request from 'superagent'
    export default {
        route: {
            data ({ to }) {
                let vm = this;
                vm.info.work_id = to.params.work_id;
                console.log(to.params)
                let userId = to.params.uid;
                if(!userId)
                    userId = getCookie('userId');
                if(userId){
                    request.get('/?c=ajax&a=user&id='+userId)
                            .end(function (err, res) {
                                console.log(res);
                                var result = JSON.parse(res.text);
                                if (result.status == 1) {
                                    if (result.data) {
                                        vm.info.name = result.data.name;
                                        vm.info.mobile = result.data.mobile;
                                        vm.info.zzcompany = result.data.company;
                                        vm.info.address = result.data.address;
                                    }
                                } else {
                                    $.alert(result.msg);
                                }
                            });
                }
            },
        },
        data(){
            return {
                info:{
                    name:'',
                    mobile:'',
                    zzcompany:'',
                    address:'',
                    work_id:null
                }

            }
        },
        methods:{
            next:function(){
                let vm = this;
                if(vm.info.name == ''){
                    $.alert('姓名不能为空!');
                    return;
                }
                var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                if(!myreg.test(vm.info.mobile)) {
                    $.alert('请输入正确的的手机号码!');
                    return;
                }
                this.$route.router.go({ name: 'cany2', params: {work_id:vm.info.work_id,info: JSON.stringify(this.info) }})
            }
        }
    }
</script>


<style lang="less" scoped>
     input{
        -webkit-appearance:none; /*去除系统默认的样式*/
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);   /* 点击高亮的颜色*/
    }
     input[type="submit"],
     input[type="reset"],
     input[type="button"],
     button { -webkit-appearance: none; }

    textarea {  -webkit-appearance: none;}

    .bar-tab:before{
        background-color:#fff;
    }

    .t-img{
        line-height: normal;
    }
    img{
        width:30%;
    }
    p{
        font-size: 0.6rem;
        color: #fff1b3;
        margin-top: 0;
    }
    h5{
        color: white;
    }
    .row{
        font-size: 0.7rem;
        margin: 0.6rem 0;
    }
    .col-25{
        color: #fff;
        line-height: 1.8rem;
        margin-left: 0;
        width:25%;
    }
    .col-75{
        width: 75%;
        margin-left: 0;
    }
    i{
        color: #ff3300;
        font-size: 1rem;
    }
    input,textarea{
        background: #963535;
        /*border:none;*/
        border: 1px #fff solid;
        height: 1.8rem;
        width:100%;
        color: #ffffff;
        padding-left: 0.5rem;
        border-radius:0;
    }
    textarea{
        height: 5rem;
    }
    span{
        color: #fff;
    }

</style>


