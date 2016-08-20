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
                        <textarea v-model="detail.title" class="height01"
                                  placeholder="标题请直接突出该项目的“之最”特征，如：全球最大单体陶板幕墙—XXX项目"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">上传图片<i>*</i></div>
                    <div class="col-75">
                        <div id="input-file">
                            <span id="text">点击上传</span>
                            <input type="file" class="width03" id="file">
                        </div>
                        <!--<input class="img-button" type="button" @click="choice" value="选择图片" >-->
                        <!--<input type="text">-->
                        <!--<file-upload post-action="/post.method" put-action="/put.method"></file-upload>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">&nbsp;</div>
                    <div class="col-75">
                        <div id="imgs">
                            <!--<img class='card-cover'-->
                            <!--src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg"-->
                            <!--alt="">-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">项目介绍<i>*</i></div>
                    <div class="col-75">
                        <textarea v-model="detail.description"
                                  placeholder="对项目整体的文字介绍，包含但不限于项目名称、项目地点、项目简介、设计理念、难点亮点、技术参数（能够量化的体现“之最”的数据或信息）"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">业主单位</div>
                    <div class="col-75">
                        <input v-model="detail.yzcompany" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">顾问公司<br>/个人</div>
                    <div class="col-75">
                        <textarea v-model="detail.adviser" class="height01"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">幕墙设计<br>单位/个人</div>
                    <div class="col-75">
                        <textarea v-model="detail.design" class="height01"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">幕墙施工<br>单位/个人</div>
                    <div class="col-75">
                        <textarea v-model="detail.construction" class="height01"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25 re-lineheight">用材品牌</div>
                    <div class="col-75">
                        <input v-model="detail.material" type="text" placeholder="玻璃、板材、胶、五金件等">
                    </div>
                </div>
                <input id="photoIds" type="hidden">
                <input type="hidden" id="uid" name="uid">
            </form>


        </div>
        <nav class="bar bar-tab">
            <table width="100%" height="100%" class="cy">
                <tr @click="submit">
                    <td align="center">
                        <span>提交作品</span>
                    </td>
                </tr>
            </table>

        </nav>
    </div>
</template>

<script>
    import request from 'superagent';

    export default {
        data(){
            return {
                info: {
                    name: '',
                    mobile: '',
                    zzcompany: '',
                    address: ''
                },
                detail: {
                    title: '',
                    description: '',
                    yzcompany: '',
                    adviser: '',
                    design: '',
                    construction: '',
                    material: '',
                    uid: '',
                    photoIds: '',
                    workId: null
                }
            }
        },
        route: {
            data ({ to }) {
                let vm = this;
                if (to.params.info != 'success') {
                    let info_ = JSON.parse(to.params.info);
                    vm.info = info_;

                }
                vm.detail = {
                    title: '',
                    description: '',
                    yzcompany: '',
                    adviser: '',
                    design: '',
                    construction: '',
                    material: '',
                    uid: '',
                    photoIds: '',
                    workId: null
                };
                setTimeout(function () {
                    var ids = $("#photoIds").val();
                    var n = ids.split(',');
                    for (var i = 0; i < n.length; i++) {
                        remove(n[i]);
                    }
                }, 100);


                vm.detail.workId = to.params.work_id;
                if (vm.detail.workId && vm.detail.workId != ':work_id') {

                    request.get('/?c=index&a=show&id=' + vm.detail.workId + "&random=" + Math.random())
                            .end(function (err, res) {
                                var result = JSON.parse(res.text);
                                if (result.status == 1) {
                                    if (result.data) {
                                        var r = result.data;
                                        vm.detail.yzcompany = r.company;
                                        vm.detail.title = r.title;
                                        vm.detail.description = r.description;
                                        vm.detail.adviser = r.adviser;
                                        vm.detail.design = r.design;
                                        vm.detail.material = r.material;
                                        vm.detail.construction = r.construction;

                                        setTimeout(function () {
                                            result.ablum.map(function (v, i) {
                                                var ids = $("#photoIds").val();
                                                vm.appendImg(v.work_ablum_id, ids, v.src);
                                            });
                                        }, 150);
                                    }
                                } else {
                                    $.alert(result.msg);
                                }
                            });
                }
            }
        },
        ready(){
            let vm = this;

            function remove(id) {
                $('#img_id_num_' + id).remove();
                var ids = ',' + $("#photoIds").val();
                var ods = ids.replace(',' + id + ',', ',');
                var nid = ods.substring(1);
                $("#photoIds").val(nid);
            }

            $("#file").html5Uploader({
                name: "photoFile",
                postUrl: "/?c=upload&a=photo",
                onServerError: function () {
                    $.hidePreloader();
                },
                onServerLoadStart: function () {
                    $.showPreloader('正在上传...');
                },
                onSuccess: function (e, file, dhtml) {
                    $.hidePreloader();
                    var response = JSON.parse(dhtml);
                    if (response.status == 1) {
                        var id = response.data.id;
                        var ids = $("#photoIds").val();
                        vm.appendImg(id, ids, response.data.url);
                    } else {
                        $.alert(response.message);
                    }
                }
            });

        },
        methods: {
            remove: function (id) {
                $('#img_id_num_' + id).remove();
            },
            choice: function () {
                $('#multiple').click();

            },
            appendImg(id, ids, url){
                if (ids != "") {
                    var mth = ',' + ids + ',';
                } else {
                    var mth = '';
                }
                var n = ids.split(',').length - 1;
                if (n <= 2) {
                    if (mth.indexOf(',' + id + ',') == -1) {
                        ids += id + ',';
                    }
                    $("#photoIds").val(ids);

                    var dstyle = "width:3.6rem;height:3.6rem;float:left;margin-right:0.5rem;margin-bottom:0.5rem;";
                    var style = "position: absolute;margin-left: 3.1rem;margin-top: -0.6rem;z-index: 99;";
                    var lstyle = "border-radius: 50%;width: 14px;height: 14px;background-color: white;margin-left:3.1rem; margin-top: -0.2rem;position: absolute;z-index: 98;";

                    var iHtml = '<div style="' + dstyle + '" id="img_id_num_' + id + '">' +
                            '<a style="' + style + '" href="javascript:remove(' + id + ')"><i class="iconfont" style="font-size: 18px;color: red;">&#xe609;</i></a>' +
                            '<lable style="' + lstyle + '"></lable>' +
                            '<div><img style="width:3.6rem;height: 3.6rem;" src="' + url + '"></div>' +
                            '</div>';
                    $('#imgs').append(iHtml)
                } else {
                    $.alert("最多不超过3个图片");
                }
            },
            submit: function () {
                var vm = this;
                if (vm.detail.title == '') {
                    $.alert('请输入标题!');

                    return;
                }

                if (vm.detail.description == '') {
                    $.alert('请输入项目介绍!');

                    return;
                }
                if ($("#photoIds").val() == '') {
                    $.alert('请上传图片!');

                    return;
                }
                request
                        .post('/?c=ajax&a=join')
                        .set('Content-Type', 'application/x-www-form-urlencoded')
                        .set('Accept', 'application/json')
                        .send(vm.info)
                        .end(function (err, res) {
                            if (err || !res.ok) {
                                $.alert('error');
                            } else {
                                var result = JSON.parse(res.text);
                                if (result.status == 0) {
                                    $.alert(result.msg);
                                } else {
                                    vm.detail.uid = result.data.uid;
                                    vm.detail.photoIds = $("#photoIds").val();
                                    vm.submitDetail();
                                }
                            }
                        });
            },
            submitDetail: function () {
                var vm = this;
                request
                        .post('/?c=ajax&a=work')
                        .set('Content-Type', 'application/x-www-form-urlencoded')
                        .set('Accept', 'application/json')
                        .send(vm.detail)
                        .end(function (err, res) {
                            if (err || !res.ok) {
                                $.alert('Oh no! error');
                            } else {
                                var result = JSON.parse(res.text);
                                if (result.status == 0) {
                                    $.alert(result.msg);
                                } else {
                                    var ids = vm.detail.photoIds;
                                    var n = ids.split(',');
                                    for (var i = 0; i < n.length; i++) {
                                        remove(n[i]);
                                    }

                                    vm.$route.router.go({
                                        name: 'success',
                                        params: {tel: vm.info.mobile},
                                        append: false
                                    });
                                }
                            }
                        });


            }
        },
        events: {}
    }
</script>
<style lang="less" scoped>
    input {
        -webkit-appearance: none; /*去除系统默认的样式*/
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0); /* 点击高亮的颜色*/
    }

    input[type="submit"],
    input[type="reset"],
    input[type="button"],
    button {
        -webkit-appearance: none;
    }

    textarea {
        -webkit-appearance: none;
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
        width: 100%;
        top: 0;
        left: 0;
        /* 宽高和外围元素保持一致 */
        height: 1.8rem;
        opacity: 0;
        -moz-opacity: 0; /* 兼容老式浏览器 */
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
        font-size: 0.6rem;
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
        border: 0.03rem #6a92a9 solid !important;
        height: 1.8rem;
        width: 100%;
        color: #ffffff;
        padding-left: 0.5rem;
        padding-right: 0.1rem;
        border-radius: 0;

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
