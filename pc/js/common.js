function getUrlParam(name) {
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r!=null) return unescape(r[2]); return null; //返回参数值
}

function zanTa(e, id, num) {
    if (!localStorage.getItem("selfNum_" + id)) {
        localStorage.setItem("selfNum_" + id, 0);
    }
    if (localStorage.getItem("selfNum_" + id) <= 0) {
        localStorage.setItem("selfNum_" + id, ++num);

        layer.alert('<div  style="width: auto; margin:5px -15px -15px">'+
            '<div ></div>'+
            '<div >'+
            '<div ><img src="http://www.zhuanti2016.wangziqing.cc/xiugai/code.jpg" height="150" style="display:block;margin-left: auto;margin-right: auto;">' +
            '<div style="text-align: center"><p style="margin-left:10px;margin-right:10px;font-size:12px;">感谢您的参与，扫描二维码（或长按进行识别），关注活动微信公众号，更多惊喜等着您</p>'+
            '<p style="margin-left:10px;margin-right:10px;font-size:12px;color:red;">转发活动并截屏发送到微信公众号，还可参与抽奖</p></div></div>'+
            '</div>'+
            '</div>', {
            skin: 'layui-layer-lan',
            title:'点赞成功'
            ,closeBtn: 0
            ,shift: 0 //动画类型
        });
    } else {
        alert("你已经赞过了");
    }
    const s = '<i class="iconfont" style="color:#00ffcc"> &nbsp;&nbsp;&#xe606;赞' + (num) + ' </i>';
    e.getElementsByTagName("span")[0].innerHTML = s;
}

function initPagination(pagehref,size) {
    let offset = getUrlParam("offset");

    let total = 1000;
    let array_lg = 10;
    let side = Math.round(array_lg / 2) - 1;

    let total_page = Math.round(total / (size));
    if (!offset) {
        offset = 0;
    }
    if (offset > (total_page - 1) * size) {
        offset = (total_page - 1) * size;
    }

    let page = Math.round(offset / size);

    let start = 0;

    if (page > array_lg - (page + 1)) {
        start = page - side;
    }
    let endside = total_page - (page + 1);
    if (endside < side) {
        endside = endside == 0 ? side : endside;
        start -= endside;
    }

    if (total_page < array_lg) {
        array_lg = total_page;
    }
    let end = start + array_lg;

    let jump_prev = size * (page - array_lg);
    if (jump_prev < 0) {
        jump_prev = 0;
    }

    let jump_next = size * (page + array_lg);
    if (jump_next > (total - size)) {
        jump_next = total - size;
    }

    var html = '<li><a class="pure-button prev" href="' + pagehref + '?size='+size+'&offset=' + jump_prev + '#list">&#171;</a></li>';
    for (let i = start; i < end; i++) {
        if (i == page) {
            html += '<li><a class="pure-button pure-button-active" href="' + pagehref + '?size='+size+'&offset=' + i * size + '#list">' + (i + 1) + '</a></li>';
        } else {
            html += '<li><a class="pure-button" href="' + pagehref + '?size='+size+'&offset=' + i * size + '#list">' + (i + 1) + '</a></li>';
        }
    }
    if (end < total_page) {
        html += '<li style="padding-top: 28px;color: white;padding-right: 10px;">...</li>';
        html += '<li><a class="pure-button" href="' + pagehref + '?size='+size+'&offset=' + (total - size) + '#list">' + (total_page) + '</a></li>';
    }
    html += '<li><a class="pure-button next" href="' + pagehref + '?size='+size+'&offset=' + jump_next + '#list">&#187;</a></li>';

    $('.pure-paginator')[0].innerHTML = html;

}