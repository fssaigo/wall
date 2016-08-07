<template>
  <div class="content">
    <div class="head">

    </div>

    <div class="buttons-tab fixed-tab" data-offset="44">
      <a href="#tab1" class="tab-link active button">活动说明</a>
      <a href="#tab2" class="tab-link button">活动规则</a>
      <a href="#tab3" class="tab-link button">奖项设置</a>
      <a href="#tab4" class="tab-link button">作品展示</a>
    </div>

    <div class="tabs">
      <div id="tab1" class="tab active">
        <div class="content-block">
            活动说明
        </div>
      </div>
      <div id="tab2" class="tab">
        <div class="content-block">
         活动规则
        </div>
      </div>
      <div id="tab3" class="tab">
        <div class="content-block">
         奖项设置
        </div>
      </div>
      <div id="tab4" class="tab">
        <div class="content-block">
          作品展示
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="less">
  @import "../lib/sui/less/sm.less";
  .head{
    height: 420px;
    max-height: 420px;
    background-color: #00ffcc;
  }
</style>


