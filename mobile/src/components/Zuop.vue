<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <div class="bar bar-header-secondary re-bar">
            <div class="searchbar">
                <a class="searchbar-cancel re-cancel" @click="cancel">取消</a>
                <div class="search-input re-input">
                    <label class="icon icon-search" for="search"></label>
                    <input type="search" id='search'
                           v-model="searchText" placeholder='输入您的手机号检索您的作品' @blur="search" @keyup.esc="search" @keyup.enter="search"/>
                </div>
            </div>
        </div>
        <div class="content-padded myfont" id="content_zuop">
            <div class="infinite-scroll infinite-scroll-bottom" data-distance="0" id="list">

                <div class="row">
                    <div class="col-50">
                        <div class="cd" v-for='item in list1'>
                            <div valign="bottom" class="card-header color-white no-border no-padding">
                                <a v-link="{ name: 'detail', params: { id: item.work_id }}">
                                    <img class='card-cover' src={{item.picture}}>
                                </a>
                            </div>
                            <div class="card-content">
                                <div class="card-content-inner">
                                    <p>{{item.title}}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a @click="zanT(item.work_id,zan)" href="javascript:void(0)" class="link">
                                    <i class="iconfont">
                                        &#xe607;
                                        赞 {{item.zan}}
                                    </i>

                                </a>

                                <a  v-link="{ name: 'detail', params: { id: item.work_id }}" class="link">
                                    <span class="iconfont">&#xe601;</span>
                                    评论 {{item.comment}}
                                </a>
                                <a v-if="show"  v-link="{ name: 'cany1', params: { work_id: item.work_id ,uid : item.uid}}" class="link">
                                    <span class="iconfont" style="font-size: 16px;">&#xe60b;</span>

                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="col-50">
                        <div class="cd" v-for='item in list2'>
                            <div valign="bottom" class="card-header color-white no-border no-padding">
                                <a v-link="{ name: 'detail', params: { id: item.work_id }}">
                                    <img class='card-cover' src={{item.picture}}>
                                </a>
                            </div>
                            <div class="card-content">
                                <div class="card-content-inner">
                                    <p>{{item.title}}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a @click="zanT(item.work_id,zan)" href="javascript:void(0)" class="link">
                                    <i class="iconfont">
                                        &#xe607;
                                        赞 {{item.zan}}
                                    </i>
                                </a>
                                <a v-link="{ name: 'detail', params: { id: item.work_id }}" class="link">
                                    <span class="iconfont">&#xe601;</span>
                                    评论 {{item.comment}}
                                </a>
                                <a v-if="show" v-link="{ name: 'cany1', params: { work_id: item.work_id ,uid : item.uid}}" class="link">
                                    <span class="iconfont" style="font-size: 16px;">&#xe60b;</span>

                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="ct">

                </div>


                <!-- 加载提示符 -->
                <div class="infinite-scroll-preloader" v-if="loading">
                    <div class="preloader"></div>
                </div>


            </div>
        </div>

        <div class="space">&nbsp;</div>
    </div>
</template>
<script>
    import request from 'superagent';

    export default {
        data(){
            return {
                list1: [],
                list2: [],
                loading: false,
                maxItems: 1000,
                itemsPerLoad: 14,
                lastIndex: 14,
                searchText: '',
                show: false
            }
        },
        route: {
            data ({ to }) {
                let vm = this;
                vm.loading = false;
                vm.list1 = [];
                vm.list2 = [];
                vm.lastIndex = 14;


                vm.searchText = to.params.tel;
                //预先加载条
                vm.addItems(vm.itemsPerLoad, 0,vm.searchText);
                var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                if (myreg.test(vm.searchText)) {
                    vm.show = true;
                } else {
                    vm.show = false;
                }
            }
        },
        methods: {
            cancel: function () {
                let vm = this;
             //   vm.show = false;
                vm.searchText = '';
             //   vm.loading = false;
             //   vm.list1 = [];
               // vm.list2 = [];
                //vm.lastIndex = 14;
               // vm.addItems(vm.itemsPerLoad, 0, vm.searchText);
            },
            search: function (e) {
                let vm = this;
                setTimeout(function () {
                    vm.loading = false;
                    vm.list1 = [];
                    vm.list2 = [];
                    vm.lastIndex = 14;
                    vm.addItems(vm.itemsPerLoad, 0, vm.searchText);
                    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                    if (myreg.test(vm.searchText)) {
                        vm.show = true;
                    } else {
                        vm.show = false;
                    }
                },25)
            },
            zanT: function (id, num) {
                let vm = this;
                if (!localStorage.getItem("selfNum_" + id)) {
                    localStorage.setItem("selfNum_" + id, 0);
                }
                if (localStorage.getItem("selfNum_" + id) <= 0) {
                    localStorage.setItem("selfNum_" + id, ++num);

                    request.get('/?c=ajax&a=vote&id=' + id + '&random=' + Math.random()).end(function (err, res) {
                        if (err || !res.ok) {
                            $.alert('error');
                        } else {
                            var result = JSON.parse(res.text);
                            if (result.status == 1) {
                                vm.list1.map(function (v, index) {
                                    if (v.work_id == id) {
                                        v.zan++;
                                        return;
                                    }
                                });
                                vm.list2.map(function (v, index) {
                                    if (v.work_id == id) {
                                        v.zan++;
                                        return;
                                    }
                                });

                            } else {
                                $.alert(result.msg);
                            }
                        }
                    });
                } else {
                    $.alert("你已经赞过了");
                }

            },
            addItems: function (number, lastIndex, keyword) {
                let vm = this;
                let url = '/?c=index&a=works&offset=' + lastIndex + '&size=' + number + '&random=' + Math.random();
                if (keyword) {
                    url += '&keyword=' + keyword;
                }
                request.get(url).end(function (err, res) {
                    if (err || !res.ok) {
                        $.alert('error');
                    } else {
                        var result = JSON.parse(res.text);
                        if (result.status == 1) {
                            if (result.data) {
                                var i = 0;
                                for (; i < result.data.length; i += 2) {
                                    vm.list1.push(result.data[i]);
                                    if ((i + 1) < result.data.length) {
                                        vm.list2.push(result.data[i + 1]);
                                    }
                                }
                            } else {
                                vm.loading = false;
                            }
                        } else {
                            $.alert(result.msg);
                        }
                    }
                });

            }
        },
        ready(){
            $.init();
            let vm = this;

            // 注册'infinite'事件处理函数
            $('#content').on('infinite', function () {
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
                    vm.addItems(vm.itemsPerLoad, vm.lastIndex,vm.searchText);
                    // 更新最后加载的序号
                    //   $.alert($('.card').length)
                    vm.lastIndex = $('.cd').length + 14;
                    //  $.alert(lastIndex)
                    //容器发生改变,如果是js滚动，需要刷新滚动
                    $.refreshScroller();
                }, 1000);
            });
        }
    }
</script>
<style lang="less" scoped>
    .cd {
        background-color: white;
        margin-top: 0.5rem;
        border-radius: 0.1rem;
        position: relative;
    }

    .searchbar {
        margin-top: 0.1rem;
    }

    #list {
        margin-top: -0.5rem;
    }

    .card-cover {
        /*height: 9rem;*/
    }

    .space {
        width: 4rem;
        padding-bottom: 0.0rem;
    }

    /*.card {*/
    /*width: 100%;*/
    /*overflow: hidden;*/
    /*float: left;*/
    /*margin-right: 0;*/
    /*}*/

    .card-header {
        overflow: hidden;
    }

    .card-content-inner {
        padding: 0.4rem;
        font-weight: bold;
    }

    .card-footer {
        padding: 0.4rem;
    }

    .card-content-inner p {
        color: #333333;
        line-height: 0.8rem;
    }

    .re-bar {
        position: relative;
        background: none;
        top: 0.2rem;
        background: transparent;
        padding-left: 1.1rem;
        padding-right: 1.1rem;
    }

    .re-input {
        border-radius: 1rem;
        overflow: hidden;
        border: 0.05rem solid #00ffcc;
    }

    .re-input input {
        background-color: #244151;
        color: #307266;
    }

    .bar:after {
        background-color: transparent;
    }

    .re-cancel {
        font-size: 0.7rem;
    }

    a {
        color: #333333;
    }

    .card-footer a.link, .iconfont {
        font-size: 0.7rem;
    }
</style>
