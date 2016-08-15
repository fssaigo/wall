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
        <div class="content-padded myfont ss">
            <div class="card demo-card-header-pic">
                <div valign="bottom" class="card-header color-white no-border no-padding">
                    <a v-link="'detail'">
                    <img class='card-cover'
                         src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg"
                         alt="">
                    </a>
                </div>
                <div class="card-content">
                    <div class="card-content-inner">
                        <p>全球最高的幕墙-上海中心</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="link">赞</a>
                    <a href="#" class="link">更多</a>
                </div>
            </div>
            <div class="card demo-card-header-pic">
                <div valign="bottom" class="card-header color-white no-border no-padding">
                    <a v-link="'detail'">
                    <img class='card-cover'
                         src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg"
                         alt="">
                    </a>
                </div>
                <div class="card-content">
                    <div class="card-content-inner">
                        <p>全球最高的幕墙-上海中心</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="link">赞</a>
                    <a href="#" class="link">更多</a>
                </div>
            </div>
            <div class="card demo-card-header-pic">
                <div valign="bottom" class="card-header color-white no-border no-padding">
                    <a v-link="'detail'">
                    <img class='card-cover'
                         src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg"
                         alt="">
                    </a>
                </div>
                <div class="card-content">
                    <div class="card-content-inner">
                        <p>全球最高的幕墙-上海中心</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="link">赞</a>
                    <a href="#" class="link">更多</a>
                </div>
            </div>
            <div class="card demo-card-header-pic">
                <div valign="bottom" class="card-header color-white no-border no-padding">
                    <a v-link="'detail'">
                    <img class='card-cover'
                         src="//gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg"
                         alt="">
                    </a>
                </div>
                <div class="card-content">
                    <div class="card-content-inner">
                        <p>全球最高的幕墙-上海中心</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="link">赞</a>
                    <a href="#" class="link">更多</a>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="less" scoped>
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
</style>
