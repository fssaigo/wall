<template>
    <div class="page" id="page_detail">
        <div class="content bg" id="content_comment">

            <div class="swiper-container" data-space-between='10'>
                <div class="swiper-wrapper">
                    <!--<div class="swiper-slide"><img src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i1/TB1n3rZHFXXXXX9XFXXXXXXXXXX_!!0-item_pic.jpg_320x320q60.jpg" alt=""></div>-->
                    <!--<div class="swiper-slide"><img src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i4/TB10rkPGVXXXXXGapXXXXXXXXXX_!!0-item_pic.jpg_320x320q60.jpg" alt=""></div>-->
                    <!--<div class="swiper-slide"><img src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i1/TB1kQI3HpXXXXbSXFXXXXXXXXXX_!!0-item_pic.jpg_320x320q60.jpg" alt=""></div>-->

                    <div class="swiper-slide" v-for="item in ablum"><img src={{item.src}} alt=""></div>

                </div>
            </div>


            <div class="zp-info">
                <div class="zp-title">{{title}}</div>
                <div class="zp-description">
                    {{description}}
                </div>
            </div>
            <div class="zp-stat">
                <a href="javascript:void(0)">
                    <span class="iconfont">&#xe601;</span>
                    评 {{comment_n}}
                </a>
                <a href="javascript:void(0)">
                    <a @click="zanT(zan)" href="javascript:void(0)">
                        <span class="iconfont">&#xe607;赞</span>
                        {{zan}}
                    </a>

                </a>
            </div>
            <div class="zp-msg">
                <p>我有话要说..</p>
                <form class="row">
                    <input type="tel" v-model="mobile" placeholder="手机号仅作为获奖联络，请放心填写" class="col-80">

                    <textarea v-model="text" class="col-80"
                              placeholder="对此作品，您是否有内容要补充？要吐槽？欢迎留言，让我们共同完善作品内容，还有精美奖品等着您"></textarea>
                    <button type="button" class="col-20" @click="submit">发表</button>
                </form>

                <div class="infinite-scroll infinite-scroll-bottom" data-distance="0" id="comment">

                    <div class="list-block">
                        <ul class="list-container">
                            <li class="item-content row" v-for='item in list'>
                                <div class="col-20">
                                    <div class="zp-user"><span class="icon icon-friends"></span></div>
                                </div>
                                <div class="col-80">
                                    {{item.content}}
                                </div>
                            </li>


                        </ul>
                    </div>

                    <!-- 加载提示符 -->
                    <div class="infinite-scroll-preloader" v-if="loading">
                        <div class="preloader"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
    import request from 'superagent';

    export default {
        route: {
            data ({to}) {
                var id = to.params.id;
                let vm = this;
                vm.text = '';
                request.get('/?c=index&a=show&id=' + id + "&random=" + Math.random())
                        .end(function (err, res) {
                            var result = JSON.parse(res.text);
                            if (result.status == 1) {
                                if (result.data) {
                                    vm.title = result.data.title;
                                    vm.description = result.data.description;
                                    vm.ablum = result.ablum;
                                    vm.comment_n = result.data.comment;
                                    vm.zan = result.data.zan;
                                    setTimeout(function () {
                                        $.reinitSwiper();
                                    }, 100);
                                }
                            } else {
                                $.alert(result.msg);
                            }
                        });
                vm.list = [];
                vm.text = '';
                vm.mobile = '';
                vm.lastIndex = 10;
                vm.addItems(vm.itemsPerLoad, 0);
            }

        },
        data(){
            return {
                title: '',
                description: '',
                ablum: [],
                loading: false,
                list: [],
                text: '',
                comment_n: 0,
                zan: 0,
                mobile: '',
                maxItems: 1000,
                itemsPerLoad: 14,
                lastIndex: 14
            }
        },
        methods: {
            zanT: function (num) {
                let vm = this;
                var id = vm.$route.params.id;
//                if (!localStorage.getItem("selfNum_" + id)) {
//                    localStorage.setItem("selfNum_" + id, 0);
//                }
//                localStorage.setItem("selfNum_" + id, ++num);
                request.get('/?c=ajax&a=vote&id=' + id + '&random=' + Math.random()).end(function (err, res) {
                    if (err || !res.ok) {
                        $.alert('error');
                    } else {
                        var result = JSON.parse(res.text);
                        if (result.status == 1) {
                            vm.zan = num;

                            $.modal({
                                title: '点赞成功',
                                afterText: '<div class="swiper-container" style="width: auto; margin:5px -15px -15px">' +
                                '<div class="swiper-pagination"></div>' +
                                '<div class="swiper-wrapper">' +
                                '<div class="swiper-slide"><img src="http://www.zhuanti2016.wangziqing.cc/xiugai/code.jpg" height="150" style="display:block;margin-left: auto;margin-right: auto;">' +
                                '<div style="text-align: center"><p style="margin-left:10px;margin-right:10px;font-size:12px;">感谢您的参与，扫描二维码（或长按进行识别），关注活动微信公众号，更多惊喜等着您</p>' +
                                '<p style="margin-left:10px;margin-right:10px;font-size:12px;color:red;">转发活动并截屏发送到微信公众号，还可参与抽奖</p></div></div>' +
                                '</div>' +
                                '</div>',
                                buttons: [
                                    {
                                        text: '关闭',
                                        onClick: function () {
                                            $.closeModal(this)
                                        }
                                    }
                                ]
                            })

                        } else {
                            $.alert(" 您已经点过赞了，2小时之内只能点一次哦");
//                                $.alert(result.msg);
                        }
                    }
                });
            },


            addItems: function (number, lastIndex) {
                let vm = this;
                request.get('/?c=index&a=comment&id=' + vm.$route.params.id + '&offset=' + lastIndex + '&size=' + number + '&random=' + Math.random()).end(function (err, res) {
                    if (err || !res.ok) {
                        $.alert('error');
                    } else {
                        var result = JSON.parse(res.text);
                        if (result.status == 1) {
                            if (result.data) {
                                console.log(result.data);
                                var i = 0;
                                result.data.map(function (v, index) {
                                    vm.list.push(v);
                                });
                            } else {
                                vm.loading = false;
                            }
                        } else {
                            $.alert(result.msg);
                        }
                    }

                });
            },

            submit: function () {
                var vm = this;
                var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

                if (vm.text == '') {
                    $.alert('评价内容不能为空!');
                } else if (!myreg.test(vm.mobile)) {
                    $.alert('请输入正确的的手机号码!');
                } else {

                    request.post('/?c=ajax&a=comment&id=' + vm.$route.params.id + '&random=' + Math.random())
                            .set('Content-Type', 'application/x-www-form-urlencoded')
                            .send({speak: vm.text, mobile: vm.mobile})
                            .end(function (err, res) {

                                if (err || !res.ok) {
                                    $.alert('error');
                                } else {
                                    var result = JSON.parse(res.text);
                                    if (result.status == 0) {
                                        $.alert(result.msg);
                                    } else {
                                        $.showPreloader('提交中...');
                                        vm.comment_n++;
                                        vm.list = [];
                                        vm.text = '';
                                        vm.lastIndex = 14;
                                        vm.addItems(vm.itemsPerLoad, 0);
                                        setTimeout(function () {
                                            $.hidePreloader();
                                            $.alert('感谢提交,审核通过后,可在页面中查看您的评论内容!');
                                        }, 500);
                                    }
                                }
                            })

                }
            }
        }
        ,
        ready()
        {
            let vm = this;
            $.init();
            $('#content_comment').on('infinite', function () {
                // 如果正在加载，则退出
                if (vm.loading) return;
                // 设置flag
                vm.loading = true;
                // 模拟1s的加载过程
                setTimeout(function () {
                    // 重置加载flag
                    vm.loading = false;
                    if (vm.lastIndex >= vm.maxItems) {
                        // 加载完毕，则注销无限加载事件，以防不必要的加载
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        // 删除加载提示符
                        $('.infinite-scroll-preloader').remove();
                        return;
                    }
                    // 添加新条目
                    vm.addItems(vm.itemsPerLoad, vm.lastIndex);
                    // 更新最后加载的序号
                    //   $.alert($('.card').length)
                    vm.lastIndex = $('.list-container li').length + 14;
                    //  $.alert(lastIndex)
                    //容器发生改变,如果是js滚动，需要刷新滚动
                    $.refreshScroller();
                }, 1000);
            });

        }


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

    .swiper-container {
        padding-bottom: 0;
    }

    .swiper-slide {
        height: 320px;
        width: 100%;

    }

    .swiper-slide img {
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        height: 320px;
    }

    p {
        margin-bottom: 0;
    }

    .infinite-scroll-preloader {
        margin-top: -20px;
    }

    .list-block ul:before, .list-block ul:after {
        background: none;
    }

    .list-block ul {
        background: none;
        border: none;
        color: #ffffff;
        font-size: 0.7rem;
        color: #c9e0ed;
    }

    .iconfont {
        font-size: 0.7rem;
    }

    .item-content {
        border-bottom: 0.03rem solid #fff !important;
        padding: 0.5rem 0;
        margin-left: 0.1rem;
    }

    .item-content .col-20 {
        width: 10%;
        margin-left: 0;
    }

    .item-content .col-80 {
        width: 88%;
        margin-left: 0;
        line-height: 0.8rem;
    }

    textarea {
        color: #fff;
    }

    .list-block {
        margin-top: 0;
    }

    .zp-user {
        width: 1.5rem;
        height: 1.5rem;
        border: 0.01rem solid #fff1b3;
        color: #fff1b3;
        text-align: center;
        font-size: 0.9rem;
        background: #963535;
    }

    .zp-msg {
        padding: 0.4rem 1rem;
    }

    .zp-msg p {
        color: #fff;
        font-size: 0.6rem;
    }

    form.row {
        margin-bottom: 1rem;
        margin-top: 0.5rem;
    }

    .zp-msg textarea {
        background: none;
        border: 0.03rem solid #fff1b3 !important;
        font-size: 0.6rem;
        line-height: 0.8rem;
        height: 3.2rem;
        resize: none;
        padding: 0.4rem;
        border-radius: 0;
        margin-top: 10px;
    }

    .zp-msg input {
        background: none;
        border: 0.03rem solid #fff1b3 !important;
        font-size: 0.6rem;
        color: white;
        /*line-height: 0.8rem;*/
        /*height: 3.2rem;*/
        resize: none;
        padding: 0.4rem;
        border-radius: 0;
    }

    .zp-msg button {
        background: #fff1b3;
        color: black;
        height: 3.2rem;
        border: none;
        margin-left: 0.2rem;
        width: 17%;
        font-size: 0.8rem;
        font-weight: bold;
        margin-top: 10px;
    }

    .zp-stat {
        padding: 0.4rem 1rem;
        font-size: 0.5rem;
        border-bottom: 0.03rem solid #fff !important;
    }

    .zp-stat a {
        padding-right: 0.6rem;
    }

    .slide {
        height: 13rem;
        background: #fff;
    }

    .zp-info {
        padding: 0rem 1rem 1rem 1rem;
        border-bottom: 0.03rem solid #fff !important;
    }

    .zp-title {
        color: #fefefe;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
        margin-top: 0.6rem;
    }

    .zp-description {
        font-size: 0.6rem;
        color: #fff;
        line-height: 0.8rem;
    }

    ::-webkit-input-placeholder { /* WebKit browsers */
        color: #fff1b3;
    }

    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color: #fff1b3;
    }

    ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color: #fff1b3;
    }

    :-ms-input-placeholder { /* Internet Explorer 10+ */
        color: #fff1b3;
    }
</style>