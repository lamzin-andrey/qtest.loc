//============CHAT FILE ======================================
function chatOnSelectFile(evt) {
	console.log('Hello!');
	//if (!ppc.isConnected) {
		mcrOnSelectFile(evt);
		return;
	//}
	//P2pCreateFileMessage(e(evt.target.id));
}
function chatOnUploadProgress(a,b) {
	if (a < 100) {
		chatShowFileprogress(a);
	} else {
		chatHideFileprogress();
	}
}
function chatShowFileprogress(a) {
	var h = 'height', m = 'margin-top', l = 'margin-left',
		r = $('#chatUploadProcessRightSide'),
		L = $('#chatUploadProcessLeftSide');
	$('#chatUploadBtn').addClass('hide');
	chatUploadProcessView.style.display = null;
	r.css(h, '0px');
	L.css(h, '0px');
	L.css(m, '0px');
	r.css(l, '10px')
	var t = a, bar = a < 50 ? r : L,
		mode = a < 50 ? 1 : 2, v;
	a = a < 50 ? a : a - 50;
	a *= 2;
	v = (a / 5);
	bar.css(h, v + 'px');
	if (mode == 2) {
		bar.css(m, (20 - v) + 'px');
		r.css(h, '20px')
		r.css(l, '0px')
	}
	$('#chatUploadProcessText').text(t);
}
function chatHideFileprogress() {
	$('#chatUploadBtn').removeClass('hide');
	chatUploadProcessView.style.display = 'none';
}
function chatOnUploadFile(d) {
	if (d && d.status == 'ok') {
		chat.messageText.val(d.path);
		chatOnClickSend({preventDefault:new Function()});
	} else if(d.status == 'error' && isset(d, 'errors', 'chatfile') && String(d.errors.chatfile)){
		setMainError(String(d.errors.chatfile));
	}
}
function chatOnFailUploadFile() {
	setMainError(l('Default_error'));
}
