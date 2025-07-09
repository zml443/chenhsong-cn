__sms_code_ = {
	/**
	 * 发送短信或者邮件
	 * @param {DOM} btn 发送按钮的节点对象
	 * @return {void}
	 */
	send: function(btn) {
		var thi = this;
		var time = btn.attr('data-time')||60,
			to = btn.attr('ly-code-sms');
		var val = $(to).val();
		var url = btn.attr('data-url') || '/api/sms/index.php';
		if (!btn.is('[data-send]')) btn.attr('data-send', btn.html());
		if (val) {
			if (btn.is('[go]')) return false;
			$.post(url, {sms:val, VCodeID:code}, function(data) {
				if (data.ret == 1) {
					btn.attr({go:time});
					thi.count(btn);
				} else {
					$.alert({
						str: data.msg,
						style: 'B',
						confirm: 1
					});
				}
			}, 'json');
		} else {
			$.alert({
				str: $.lang.notes.sms_null,
				style: 'B',
				confirm: 1
			});
		}
	},
	/**
	 * 倒计时
	 * @param {DOM} btn 发送按钮的节点对象
	 * @return {void}
	 */
	count: function(btn){
		var thi = this;
		var go = parseInt(btn.attr('go')) - 1;
		if (go<=0) {
			btn.html(btn.attr('data-send')||$.lang.notes.get_code).removeAttr('go');
		} else {
			btn.html((btn.attr('data-resend')||$.lang.notes.resend_sms).replace('{{time}}', go)).attr('go', go);
			setTimeout(function() {
				thi.count(btn);
			}, 1000);
		}
	}
};
$(document).on('click', '[ly-code-sms]', function() {
	__sms_code_.send($(this));
});