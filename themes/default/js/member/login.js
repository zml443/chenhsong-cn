// 
ly2.member.login = {
	/**
	 * 登录窗口
	 * @return {void}
	 */
	popup() {
		if (!this.popupEl) {
			this.popupEl = $('<div class="popup hidden"><div style="padding:0 0 30%">'+$.loading({color:'#000'})+'</div></div>');
			$('body').append(this.popupEl);
			$.async('POST', '/member/login_popup.html', {}, html=>{
				this.popupEl.html(html).popup();
			});
		} else {
			this.popupEl.popup();
		}
	}
}