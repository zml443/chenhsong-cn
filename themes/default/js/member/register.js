// 
ly2.member.register = {
	url: {
		action: '/api/member/register',
	},
	/**
	 * 注册
	 * @param {dom} el 表单节点
	 * @return {void}
	 */
	action: function (el) {
		$.async('POST', this.url.action, $(el).serializeArray(), function (d) {
			if (d.ret==1) {
				location.href = "/member/";
			}
			else {
				$.alert(d.msg, 3000);
			}
		}, 'json');
	},
};
// 注册
$(document).on('submit', '[ly2-member^="register,"]', function () {
	ly2.member.register.action(this);
	return false;
});