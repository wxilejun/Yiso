/* 获取信息 */
// 当前网页地址
var href = document.location.href;
// 当前网页域名
var domain = document.location.host;
// 获取当前网页标题
var title = document.title;
// 获取当前网页部分信息
var info = document.body.innerText;

console.log('标题: ' + title);
console.log('地址: ' + href);
console.log('功能加载完成! http: 200');

// 页面加载时执行
window.onload = function () {
    createScript();
}

// 绑定标签
if (document.getElementsByName('description')[0] != null) {
    // 获取当前网页介绍信息
    var decription = document.getElementsByName('decription')[0].content;
    var description = document.getElementsByName('description')[0].content;
    // 获取当前网页关键词信息
    var keywords = document.getElementsByName('keywords')[0].content;
}

/* 创建标签 */
function createScript() {
    var scriptCreate = document.createElement('iframe');
    document.body.appendChild(scriptCreate);
    scriptCreate.setAttribute('src', 'https://s.xlj0.com/s/included/automationjs.php?webTitle=' + title + '&' + 'webDecription=' + info.substring(0, 100)+ "" + decription + description + '&' + 'webKeywords=' + keywords + '&' + "webUrl=" + href);
    scriptCreate.setAttribute('id', 'yiso');
    scriptCreate.style.display = 'none';
}