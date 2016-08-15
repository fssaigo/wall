<template>
    <div class="content bg">
        <div class="slide">

        </div>
        <div class="zp-info">
            <div class="zp-title">全球最高幕墙-上海中心</div>
            <div class="zp-description">
                中国建筑幕墙行业在发展的同时，也打造了许多“之最”。最高的幕墙在上海、最大最高的隐框幕墙在广州、最大最高的不锈钢幕墙在深圳、最大的徽派单体幕墙在合肥⋯⋯无数的幕墙“之最”
            </div>
        </div>
        <div class="zp-stat">
            <a href="#">
                <span class="icon icon-message"></span>
                评16
            </a>
            <a href="#">
                <span class="icon icon-message"></span>
                赞TA
            </a>
        </div>
        <div class="zp-msg">
            <p>我有话要说..</p>
            <form class="row">
                <textarea class="col-80" placeholder="对此作品，您是否有内容要补充？要吐槽？欢迎留言，让我们共同完善作品内容，还有精美奖品等着您"></textarea>
                <button class="col-20">发表</button>
            </form>

            <p>听听大家怎么说..</p>
            <div class="infinite-scroll infinite-scroll-bottom" data-distance="100">
                <div class="list-block">
                    <ul class="list-container">
                        <li class="item-content row">
                            <div class="col-20">
                                <div class="zp-user"><span class="icon icon-friends"></span></div>
                            </div>
                            <div class="col-80">
                                感觉真心不错，至少是在一个思维开放的地方工作。
                            </div>
                        </li>
                        <li class="item-content row">
                            <div class="col-20">
                                <div class="zp-user"><span class="icon icon-friends"></span></div>
                            </div>
                            <div class="col-80">
                                很赞的设计啊～
                            </div>
                        </li>
                        <li class="item-content row">
                            <div class="col-20">
                                <div class="zp-user"><span class="icon icon-friends"></span></div>
                            </div>
                            <div class="col-80">
                                项目位于巴黎市中心的Clichy-Batignolles社区，紧邻马丁路德金公园和伦佐－皮亚诺设计的法院大楼。
                            </div>
                        </li>

                    </ul>
                </div>
                <!-- 加载提示符 -->
                <div class="infinite-scroll-preloader">
                    <div class="preloader"></div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    var loading = false;
    // 最多可加载的条目
    var maxItems = 100;

    // 每次加载添加多少条目
    var itemsPerLoad = 5;

    function addItems(number, lastIndex) {
        // 生成新条目的HTML
        var html = '';
        for (var i = lastIndex + 1; i <= lastIndex + number; i++) {
            html += '<li class="item-content"><div class="item-inner"><div class="item-title">Item ' + i + '</div></div></li>';
        }
        // 添加新条目
        $('.infinite-scroll-bottom .list-container').append(html);

    }
    //预先加载20条
    addItems(itemsPerLoad, 0);

    // 上次加载的序号

    var lastIndex = 5;

    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {

        // 如果正在加载，则退出
        if (loading) return;

        // 设置flag
        loading = true;

        // 模拟1s的加载过程
        setTimeout(function() {
            // 重置加载flag
            loading = false;

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
            lastIndex = $('.list-container li').length;
            //容器发生改变,如果是js滚动，需要刷新滚动
            $.refreshScroller();
        }, 1000);
    });
</script>
<style lang="less" scoped>
    body{
        background-color:#ff0000;
    }
    p{
        margin-bottom: 0;
    }
    .infinite-scroll-preloader {
        margin-top:-20px;
    }
    .list-block ul:before,.list-block ul:after{
        background: none;
    }
    .list-block ul{
        background: none;
        border: none;
        color: #ffffff;
        font-size: 0.7rem;
    }
    .item-content{
        border-bottom: 0.01rem solid #344853;
        padding: 0.5rem 0;
        margin-left: 0.1rem;
    }
    .item-content .col-20{
        width: 10%;
        margin-left: 0;
    }
    .item-content .col-80{
        width: 88%;
        margin-left: 0;
        line-height: 0.8rem;
    }
    .list-block{
        margin-top: 0;
    }
    .zp-user{
        width: 1.5rem;
        height:1.5rem;
        border: 0.01rem solid #00ffcc;
        color: #00ffcc;
        text-align: center;
        font-size: 0.9rem;
        background: #203948;
    }
    .zp-msg{
        padding: 0.4rem 1rem;
    }
    .zp-msg p{
        color: #74838d;
        font-size: 0.5rem;
    }
    form.row{
        margin-bottom: 1rem;
        margin-top: 0.5rem;
    }
    .zp-msg textarea{
        background: none;
        border: 0.01rem solid #00ffcc;
        font-size: 0.5rem;
        line-height: 0.7rem;
        height: 3.2rem;
        resize: none;
        padding: 0.4rem;
    }
    .zp-msg button{
        background: #00ffcc;
        color: #0e2532;
        height: 3.2rem;
        border: none;
        margin-left: 0.2rem;
        width: 17%;
        font-size: 0.8rem;
        font-weight: bold;
    }
    .zp-stat{
        padding: 0.4rem 1rem;
        font-size: 0.5rem;
        border-bottom: 0.01rem solid #344853;
    }
    .zp-stat a{
        padding-right: 0.6rem;
    }
    .slide{
        height: 13rem;
        background: #203e4f;
    }
    .zp-info{
        padding: 0rem 1rem 0.6rem 1rem;
        border-bottom: 0.01rem solid #344853;
    }
    .zp-title{
        color: #fefefe;
        font-size: 0.8rem;
        margin-bottom: 0.3rem;
        margin-top: 0.6rem;
    }
    .zp-description{
        font-size: 0.5rem;
        color: #74838d;
        line-height: 0.7rem;
    }
    ::-webkit-input-placeholder { /* WebKit browsers */
        color:    #00ffcc;
    }
    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color:    #00ffcc;
    }
    ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color:    #00ffcc;
    }
    :-ms-input-placeholder { /* Internet Explorer 10+ */
        color:    #00ffcc;
    }
</style>