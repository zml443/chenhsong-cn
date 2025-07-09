
// 点击弹出客服留言
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// $(document).on('click', '#float-win .online', function(){
//     // var pop = '<div class="popup hidden"><div class="contents"><iframe src="" frameborder="0"></iframe></div></div>';
//     var width = $(window).width(),
//         height = $(window).height(),
//         left = (width - 800) / 2,
//         top = (height - 630) / 2;
//     window.open('https://tb.53kf.com/code/client/10177290/1', 'ly2feedback', 'height=630, width=800, left='+left+', top='+top+', toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no');
// });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 回去顶部
$(document).on('click','#sidebar .backTop',function(){
	$('html,body').animate({scrollTop: 0}, 500);
});