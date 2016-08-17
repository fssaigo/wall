<template>
    <div>
        <div class="bar bar-header-secondary re-bar">
            <div class="searchbar">
                <a class="searchbar-cancel re-cancel">取消</a>
                <div class="search-input re-input">
                    <label class="icon icon-search" for="search"></label>
                    <input type="search" id='search' placeholder='输入您的手机号检索您的作品'/>
                </div>
            </div>
        </div>
        <div class="content-padded myfont">
            <div class="infinite-scroll infinite-scroll-bottom" data-distance="100" id="list">

                <div class="card demo-card-header-pic" v-for='item in list'>
                    <div valign="bottom" class="card-header color-white no-border no-padding">
                        <a v-link="'detail'">
                            <img class='card-cover' src={{item.picture}} />
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <p>{{item.title}}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="link">
                            <i class="iconfont">
                                &#xe607;
                                赞TA
                            </i>

                        </a>
                        <a href="#" class="link">更多</a>
                    </div>
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
                list: [],
                loading : false
            }
        },
        route: {
            data ({ to }) {
                this.loading = false;
            }
        },

        ready(){
            let vm = this;
            // 最多可加载的条目
            let maxItems = 1000;
            // 每次加载添加多少条目
            let itemsPerLoad = 10
            // 上次加载的序号
            let lastIndex = 10;


            function addItems(number, lastIndex) {
                request.get('/?c=index&a=works&offset=' + lastIndex + '&size=' + number + '&random=' + Math.random()).end(function (err, res) {
                    if (err || !res.ok) {
                        alert('error');
                    } else {
                        var result = JSON.parse(res.text);
                        if (result.status == 1) {
                            if (result.data) {
                                console.log(result.data);
                                result.data.map(function (v, index) {
                                    vm.list.push(v);
                                });
                            } else {
                                vm.loading = false;
                            }
                        } else {
                            alert(result.msg);
                        }
                    }
                });
            }

            //预先加载条
            addItems(itemsPerLoad, 0);
            // 注册'infinite'事件处理函数
            $(document).on('infinite', function () {
                // 如果正在加载，则退出
                if (vm.loading) return;
                // 设置flag
                vm.loading = true;
                // 模拟1s的加载过程
                setTimeout(function () {
                    // 重置加载flag
                    vm.loading = false;
                    if (lastIndex >= maxItems) {
                        // 加载完毕，则注销无限加载事件，以防不必要的加载
                        $.detachInfiniteScroll($('.infinite-scroll'));
                        // 删除加载提示符
                        $('.infinite-scroll-preloader').remove();
                        return;
                    }
                    // 添加新条目
                    addItems(itemsPerLoad, lastIndex);
                    // 更新最后加载的序号
                    //   alert($('.card').length)
                    lastIndex = $('.card').length + 10;
                    //  alert(lastIndex)
                    //容器发生改变,如果是js滚动，需要刷新滚动
                    $.refreshScroller();
                }, 1000);
            });
        }
    }
</script>
<style lang="less" scoped>
    .searchbar {
        margin-top: 0.1rem;
    }

    #list {
        margin-top: -0.5rem;
    }

    .card-cover {
        height: 9rem;
    }

    .space {
        width: 4rem;
        padding-bottom: 0.0rem;
    }

    .card {
        width: 46%;
        overflow: hidden;
        float: left;
        margin-right: 0;
    }

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
</style>
