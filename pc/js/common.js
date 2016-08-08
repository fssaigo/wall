function zanTa(e, id, num) {
    if (!localStorage.getItem("selfNum_"+id)) {
        localStorage.setItem("selfNum_"+id, 0);
    }
    if (localStorage.getItem("selfNum_"+id) <= 0) {
        localStorage.setItem("selfNum_"+id, ++num);
    } else {
        alert("你已经赞过了");
    }
    const s = '<i class="iconfont" style="color:#00ffcc"> &nbsp;&nbsp;&#xe606;赞' + (num) + ' </i>';
    e.getElementsByTagName("span")[0].innerHTML = s;
}