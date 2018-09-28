
var logo = $(".logo");
logo.change(function () {
    img = this.files[0];
    var imgUrl = getObjectUrl(img);
    $(this).prev('.img_preview').remove()
    $(this).before('<img src="' + imgUrl + '" width="120" height="120" class="img_preview"></img>')
})

// 把图片转成一个字符串
function getObjectUrl(file) {
    var url = null;
    if (window.createObjectURL != undefined) {
        url = window.createObjectURL(file)
    } else if (window.URL != undefined) {
        url = window.URL.createObjectURL(file)
    } else if (window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file)
    }
    return url
}
