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
    } else {
        alert("你已经赞过了");
    }
    const s = '<i class="iconfont" style="color:#00ffcc"> &nbsp;&nbsp;&#xe606;赞' + (num) + ' </i>';
    e.getElementsByTagName("span")[0].innerHTML = s;
}