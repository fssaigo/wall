<template>
    <div class="content-padded myfont">
        <ul>
            <li class="row">
                <div class="col-img">
                    <i><img src="../imgs/j1.jpg"></i>
                </div>
                <div class="col-info">
                    <div class="j-title">入围奖</div>
                    <div>每一个通过审核并入围的项目，都将获得1张“寻找中国幕墙之最”活动官方颁发的荣誉证书，提交者同时影拓数位板1个</div>
                </div>
            </li>
            <li class="row">
                <div class="col-img">
                    <i><img src="../imgs/j2.jpg"></i>
                </div>
                <div class="col-info">
                    <div class="j-title">最佳人气奖</div>
                    <div>根据最终截止时的点赞数量，评选出“最佳人气奖”并颁发证书及奖品，奖品为：IPAD一台</div>
                </div>
            </li>
            <li class="row">
                <div class="col-img">
                    <i><img src="../imgs/j3.jpg"></i>
                </div>
                <div class="col-info">
                    <div class="j-title">最佳评论奖</div>
                    <div>每周从评论者中抽取1-2条最佳评论，颁发“最佳评论员”奖，，奖品为：蓝牙音响一台</div>
                </div>
            </li>
            <li class="row" >
                <div class="col-img">
                    <i><img src="../imgs/j4.jpg"></i>
                </div>
                <div class="col-info">
                    <div class="j-title">转发有奖</div>
                    <div>转发活动至朋友圈并截屏发给活动组官方微信（扫码关注），活动结束时抽取10名（或每周抽取X名）发放奖品，奖品：智能手环</div>
                </div>
            </li>
        </ul>

    </div>
</template>
<style lang="less">
    ul{
        list-style:none;
        padding: 0 0 2rem 0;
        font-size: 0.5rem;
        margin-left: 0.9rem;
        color: #74838d;
    ;
    }
    li{
        border-bottom: 0.05rem dotted #6e7c84;
        padding: 0.5rem 0;

    }
    .row i img{
        /*display: block;*/
        width:3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        overflow: hidden;
    }
    .j-title{
        font-size: 0.7rem;
        color: #fff;
    }
    .col-img{
        width: 25%;
    }
    .col-info{
        width: 75%;
    }
</style>