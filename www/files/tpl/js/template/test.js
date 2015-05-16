/**
 * @desc Инициализация окошка для показа теста на новые слова
 * */
(function () {
	$(document).ready(init);
	function init() {
		function reinitTest() {
			TestSymphony2.reset(1);
			$('.popup-content').removeClass('bgnone');
		}
		$('#symphony2TestRun').click(
			function() {
				appWindow('qs-test-symphony2-wrap', 'Проверь себя', reinitTest);
				$('.popup-content').addClass('bgnone');//TODO удалить класс при закрытии окна
				$('#qs-test-symphony2').css('background', 'url("' + WEB_ROOT + '/img/wordtest/bg3.png")');
			}
		);
	}
})()
