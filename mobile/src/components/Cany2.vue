<template>
    <div class="page">

        <div class="content bg re-padding">
            <div class="t-img">
                <img src="../imgs/cany1.png">
            </div>
            <p class="t-info">
                个人信息只做为联络及存档，不会在任何页面显示，*为必填项
            </p>

            <h5>作品信息</h5>
            <form>
                <div class="row">
                    <div class="col-25">标题<i>*</i></div>
                    <div class="col-75">
                        <textarea class="height01" placeholder="标题请直接突出该项目的“之最”特征，如：全球最大单体陶板幕墙—XXX项目"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">上传图片<i>*</i></div>
                    <div class="col-75">
                        <div id="input-file">
                            <span id="text">点击上传</span>
                            <input type="file" multiple="multiple" class="width03" id="file">
                        </div>
                        <!--<input class="img-button" type="button" @click="choice" value="选择图片" >-->
                        <!--<input type="text">-->
                        <!--<file-upload post-action="/post.method" put-action="/put.method"></file-upload>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">&nbsp;</div>
                    <div class="col-75">
                        <div  id="imgs">
                            <!--<img class='card-cover'-->
                                 <!--src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg"-->
                                 <!--alt="">-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">项目介绍<i>*</i></div>
                    <div class="col-75">
                        <textarea
                                placeholder="对项目整体的文字介绍，包含但不限于项目名称、项目地点、项目简介、设计理念、难点亮点、技术参数（能够量化的体现“之最”的数据或信息）"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">业主单位</div>
                    <div class="col-75">
                        <input type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">顾问公司<br>/个人</div>
                    <div class="col-75">
                        <textarea class="height01"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">幕墙设计<br>单位/个人</div>
                    <div class="col-75">
                        <textarea class="height01"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">幕墙施工<br>单位/个人</div>
                    <div class="col-75">
                        <textarea class="height01"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">用材品牌</div>
                    <div class="col-75">
                        <input type="text" placeholder="玻璃、板材、胶、五金件等">
                    </div>
                </div>

            </form>


        </div>
        <nav class="bar bar-tab">
            <table width="100%" height="100%" class="cy">
                <tr>
                    <td align="center">
                        <a @click="submit">提交作品</a>
                    </td>
                </tr>
            </table>

        </nav>
    </div>
</template>

<script>
    import request from 'superagent';

    export default {
        route: {
            data ({ to }) {
                let info = JSON.parse(to.params.info);
                console.log(info.name);
//                $route.router
            },
        },
        ready(){
//          alert(1);
            let img_id_num = 0;
            $("#file").html5Uploader({
                name: "foo",
                postUrl: "bar.aspx",
                onClientLoad:function(e1,e2){
                    //  console.log(e1);
                    //    console.log(e2);
                },
                onClientLoadEnd:function(e,file){

                    img_id_num++;
                    var newdiv = document.createElement("div");
                    newdiv.style.width = '5rem';
                    newdiv.style.height = '5rem';
                    newdiv.style.float = 'left';
                    newdiv.style.marginRight = "0.5rem";
                    newdiv.style.marginBottom = "0.5rem";
                    $(newdiv).attr("id","img_id_num_"+img_id_num)
                    $('#imgs').append(newdiv)

//                    var style = '';
                    $(newdiv).append('<a href="javascript:remove('+img_id_num+')"><i class="iconfont" style="font-size: 18px;">&#xe609;</i></a><lable class="circular"></lable>');


                    var div = document.createElement("div");
                    $(newdiv).append(div);
                    var img = document.createElement("img");

                    img.style.width = '5rem';
                    img.style.height = '5rem';
                    img.file = file;
                    $(div).append(img);
                    var reader = new FileReader();
                    reader.onload = (function(aImg){
                        return function(e){
                            aImg.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);
                },

                onServerAbort:function(t1,t2){
                    console.log(t1);
                    console.log(t2);
                }
            });
        },
        methods:{
            remove:function(id){
                //   $('#img_id_num_'+id).prop('outerHTML', '');
                $('#img_id_num_'+id).remove();
            },
            choice:function(){
                $('#multiple').click();

            },
            submit:function(){
//                v-link="'success'"
            }
        },
        events:{
        }
    }
</script>
<style lang="less" scoped>
    .circular{
        border-radius: 50%;
        width: 14px;
        height: 14px;
        background-color: white;
        margin-left: 112px;
        margin-top: -2px;
        position: absolute;
        z-index: 98;
    }
    #imgs a {
        position: absolute;
        margin-left: 110px;
        margin-top: -16px;
        z-index: 99;
    }
    #input-file {
        position: relative; /* 保证子元素的定位 */
        width: 40%;
        height: 1.8rem;
        border: none;
        background-color: #02f5c5;

        text-align: center;
        cursor: pointer;
    }

    #text {
        display: inline-block;
        vertical-align: middle;
        color: black;
        font-family: "黑体";
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }

    #file {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        /* 宽高和外围元素保持一致 */
        height: 1.5rem;
        opacity: 0;
        -moz-opacity: 0;  /* 兼容老式浏览器 */
        filter: alpha(opacity=0); /* 兼容IE */
    }
    .re-padding {
        padding-bottom: 3rem;
    }

    .t-img {
        line-height: normal;
    }

    img {
        width: 30%;
    }

    p {
        font-size: 0.5rem;
        color: #00ffcc;
        margin-top: 0;
    }

    h5 {
        color: white;
    }

    .row {
        font-size: 0.7rem;
        margin: 0.6rem 0;
    }

    .col-25 {
        color: #9eaab1;
        line-height: 1.8rem;
        margin-left: 0;
        width: 25%;
    }

    .col-75 {
        width: 75%;
        margin-left: 0;
    }

    i {
        color: #ff3300;
        font-size: 1rem;
    }

    input, textarea {
        font-size: 0.7rem;
        background: #203948;
        border: 0.01rem solid #6a92a9;
        height: 1.8rem;
        width: 100%;
        color: #ffffff;
        padding-left: 0.5rem;
        padding-right: 0.1rem;
    }

    textarea {
        height: 5rem;
        padding-top: 0.3rem;
        line-height: 0.9rem;
        resize: none;
        margin: 0;
    }

    .height01 {
        height: 2.5rem;
    }

    .re-lineheight {
        line-height: 1rem;
    }

    ::-webkit-input-placeholder { /* WebKit browsers */
        color: #3f7593;
    }

    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color: #3f7593;
    }

    ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color: #3f7593;
    }

    :-ms-input-placeholder { /* Internet Explorer 10+ */
        color: #3f7593;
    }

</style>
