/**
 * Базовая конфигурация теста на знание Symphony2
 * */
(function () {
	var testId = 4, //tpl
		lang = window.appLang;
	$(document).ready(init);
	function cover() {
		vp = getViewport();
		$(document.body).css('height', 'auto');
		if ( $(document.body).height() < vp.h ) {
			$(document.body).css('height', '100%');
		}
	}
	function init() {
		/** @var глобальный объект - экземпляр базового конфигуратора теста по паттернам*/
		window.UserTest = new TestEngine();
		//Конфигурация
		UserTest.configTime(120);
		UserTest.defaultScorePerAnswer = 5;
		UserTest.useSkipThershold = true;
UserTest.skipThershold = 15;

		//Вопросы
		$.ajax({
			dataType:'json',
			method:'get',
			url:WEB_ROOT + '/tests/questions/' + testId,
			success:function(data) {
				for (var i in data.list) {
					UserTest.quests.push({q:data.list[i].q, a:data.list[i].a});
				}
				if (UserTest.quests.length) {
					$('#ut_main_twaitQuestion').addClass('hide');
					$('#ut_main_tstartGame').removeClass('hide');
				} else {
					alert(lang['default_error']);
				}
			},
			error:function() {
				alert(lang['default_error']);
			}
		});

		//UserTest.randomize = true; //вопросы будут выводится случайным образом
		/** @desc Объект реализующий интерфейс представления данных теста, через него тест взаимодействует с DOM */
			UserTest.view = {
			setScore:function(v){
				$("#ut_main_tscore").text(v);
			},
			setTime: function(v){
				$("#ut_main_ttime_left").text(v);
			},
			clearPrevStatus: function() {
				$('#utMainTTPlayscreen').removeClass('hide');
				$('#utMainTTDonescreen').addClass('hide');
				$('#utMainTTFailscreen').addClass('hide');
			},
			setQuest: function(v, answers, rule) {
				if (v == '') {
					v = '&nbsp;';
				}
				$('#ut_main_tanswer').val('');
				if ( $('#ut_main_tanswer')[0] ) {
					$('#ut_main_tanswer')[0].focus();
				}
				$("#ut_main_tquest").html(v);
				cover();
				if (String(rule) == "undefined") {
					return;
				}
			},
			setBeginScreen: function(v){
				cover();
				$('#utMainTTFailscreen').addClass('hide');
				$('#utMainTTDonescreen').addClass('hide');
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTHelloScreen').removeClass('hide');
				$("#ut_main_tstartGame").prop('disabled', false);
				UserTest.state = 0;
			},
			setGameScreen: function(){
				$("#ut_main_tstartGame").prop('disabled', true);
				this.beginScreenSets = false;
				cover();
			},
			setLives: function(v) {
				$("#ut_main_tlives").text(v);
			},
			setDoneOneAnswerScreen: function(){
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTDonescreen').removeClass('hide');
				if (!$('#ut_main_tSuccessInfo').hasClass('hide')) {
					$('#ut_main_tSuccessInfo').addClass('hide');
				}
				$('#ut_main_tSuccess').html('Правильно!');
				cover();
				return 3;
			},
			setFailOneAnswerScreen: function(answer){
				$('#ut_main_tErr').text('Ошибка!');
				$('#ut_main_tRa').text(answer);
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTFailscreen').removeClass('hide');
				cover();
				return 5;
			},
			setGameOverScreen: function(){
				$('#ut_main_tErr').text('GAME OVER');
				if ( !this.beginScreenSets ) {
					this.beginScreenSets = true;
					var o = this;
					setTimeout(
						function () {
							o.setBeginScreen();
						},
						5
					);
				}
			},
			getAnswer: function(){
				return $('#ut_main_tanswer').val();
			},
			setWinScreen: function(){
				this.clearPrevStatus();
				var s = 'Очень хорошо!';
				if (UserTest.lives == 1) {
					s = 'Хорошо!';
				}
				$('#ut_main_tSuccess').html(s);
				$('#ut_main_tSuccessInfo').removeClass('hide');
				$('#utMainTTPlayscreen').addClass('hide');
				$('#utMainTTDonescreen').removeClass('hide');
				cover();
				var o = this;
				UserTest.state = 0;
				setTimeout(
					function () {
						o.setBeginScreen();
					},
					15
				);
			},
			setSkipButtonState: function(is_enabled) {
				$('#ut_main_tSkip').prop('disabled', !is_enabled);
			}
		};
		
		UserTest.init();		//Запуск
		var C = UserTest.C;		//для более быстрого доступа
		$("#ut_main_tstartGame").prop('disabled', false); //кнопку "Начать тест" сделаем пока ннедоступной
		
		
		/** @desc Взаимодействие пользователя с тестом*/
		$('#ut_main_tstartGame').click( function() {
			$("#utMainTTPlayscreen").removeClass('hide');
			$("#utMainTTHelloScreen").addClass('hide');
			UserTest.state = C.START_GAME;
			UserTest.tick();
		});
		$('#ut_main_tOK').click( function() {
			UserTest.state = C.CHECK_ONE_RESULT;
			UserTest.tick();
			UserTest.tick();
		});
		$('#ut_main_tSkip').click( function() {
			UserTest.state = C.SKIP_ONE_QUEST;
			UserTest.tick();
		});
	}
})()

