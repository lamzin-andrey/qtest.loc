/**
 * @description Обработка успешной загрузки фонового изображения.
*/
function testSettingOnUploadFile(d) {
	if (d && d.status == 'ok') {
		$('#imgBgImage').attr('src', d.path);
		$('#bgimage').val(d.path);
	} else if(d.status == 'error' && isset(d, 'errors', 'chatfile') && String(d.errors.chatfile)){
		setMainError(String(d.errors.chatfile));
	}
}
function testSettingOnChangeColor(evt) {
	$('#hTextExample').css('color', evt.target.value);
}
/**
 * @description 
*/
function testSettingOnClickSetDefault() {
	var s = '/img/qtest/sea.jpg', 
		defColor = '#a62828';
	$('#imgBgImage').attr('src', s);
	$('#bgimage').val(s);
	$('#text_color').val(defColor);
	$('#hTextExample').css('color', defColor);
}
/**
 * @description Инициализация контролов связанных с загрузкой фонового изображения
*/
function testSettingOnUploadFileInit() {
	$('#bSetBgImageDefault').click(testSettingOnClickSetDefault);
	$('#text_color').change(testSettingOnChangeColor);
}
$(testSettingOnUploadFileInit);
