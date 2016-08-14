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
                        <input type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">手机号<i>*</i></div>
                    <div class="col-75">
                        <input type="text" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">公司</div>
                    <div class="col-75">
                        <input type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">地址</div>
                    <div class="col-75">
                        <textarea></textarea>
                    </div>
                </div>
            </form>


        </div>
        <div class="bar bar-tab bg">
            <table width="100%" height="100%" class="next">
                <tr>
                    <td align="center">
                        <a v-link="'cany2'">下一步</a>
                    </td>
                </tr>
            </table>

        </div>
    </div>

</template>


<style lang="less" scoped>
    .t-img{
        line-height: normal;
    }
    img{
        width:30%;
    }
    p{
        font-size: 0.5rem;
        color: #00ffcc;
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
        color: #9eaab1;
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
        background: #203948;
        border: 0.01rem solid #6a92a9;
        height: 1.8rem;
        width:100%;
        color: #ffffff;
        padding-left: 0.5rem;
    }
    textarea{
        height: 5rem;
    }
    a{
        color: #00ffcc;
    }

</style>


