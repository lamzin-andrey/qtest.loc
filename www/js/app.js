(function ($, undefined) {
	var guid = '';
	var lang = window.appLang;
	$(document).ready(
		function(){
			//std
			setHelloLoader();
			initGuid();
			initWinFunctions();
			initTooltipFunctions();
			initSigninButton();
			initSignupButton();
			initNumberFields();
			//custom
			initCreateTest();
			//initScrollSaver();
			//initResourcesPage();
			initMainPage();
			$('#firstLoaderId').remove();
			$('#firstImgId').remove();
			
			//fileUpload
			//	see also getToken(), setMainError, l()
			if (window.initFileInputs) {
				initFileInputs();
			}
		}
	);
	window.getToken = function(){
		return 'open';
	}
	window.setMainError = function(s, a, b) {
		console.log(s);
		console.log(a);
		console.log(b);
	}
	window.l = function(s) {
		return s;
	}
	function initNumberFields() {
		$('input[type=number]').each(
			function(j, i) {
				i.onkeydown = function(e) {
					e = e || window.event;
					var v = e.keyCode;
					if ( (v > 47 && v < 58) || (v > 95 && v < 106) || (v > 36 && v < 41) || v == 8 || v == 46 || v == 13 || v == 9 ) {
						return true;
					}
					return false;
				}
			}
		);
	}
	function setHelloLoader() {
		var W = window, D = document, body = D.getElementsByTagName('body')[0];
		if (!body) {
			return;
		}
		var back = D.createElement('div');
		back.id = "firstLoaderId";
		with (back.style) {
			background = 'url("' + WEB_ROOT + '/img/std/popup-bg.png")';
			zIndex = 600;
			position = 'fixed';
			left = '0px';
			top = '0px';
			width = body.offsetWidth + 'px';
			height = body.offsetHeight + 'px';
		}
		body.appendChild(back);
		
		var i = D.createElement('img');
		i.id = "firstImgId";
		i.src = '/img/std/ploader.gif';
		with (i.style) {
			zIndex = 599;
			position = 'fixed';
			left = ( (body.offsetWidth - 66) / 2) + 'px';
			top = ( (body.offsetHeight - 66) / 2) + 'px';
		}
		body.appendChild(i);
		clearInterval( W.helloLoaderInterval );
	}
	/**
	 * @desc Фильтр файлов в диалоге открытия файла редактора и диалоге выбора файлов решений
	*/
	function filesFilter() {
		function isFileItem(li) {
			if (li.hasClass('file_view template') || li.hasClass('no_file')) {
				return false;
			}
			return true;
		}
		
		var inp = this, prefix;
		
		switch (inp.id) {
			case 'searchFileFilter':
				prefix = '#ts-br';
				break;
			default:
				prefix = '#qs-br';
		}
		setTimeout(
			function() {
				var s = inp.value;
				if (s.length) {
					$(prefix + ' .js-br-files li').each(
						function (i, item) {
							item = $(item);
							if (!isFileItem(item)) {
								return;
							}
							var name = item.find('.js-file-title').text();
							if (name.indexOf(s) == -1) {
								item.addClass('hide');
							} else {
								item.removeClass('hide');
							}
						}
					);
				} else {
					$(prefix + ' .js-br-files li').each(
						function (i, item) {
							item = $(item);
							if (!isFileItem(item)) {
								return;
							}
							item.removeClass('hide');
						}
					);
				}
			}
			,10
		);
	}
//====== Тултипы
	/**
	 * @desc Уведомления в стиле ubuntu
	 * */
	function initTooltipFunctions() {
		//постановка в очередь сообщений
		if (window.infoMessages) {
			var data = infoMessages, i, k, back_done = 'bg-dark-blue', back_fail = 'bg-rose';
			if (data) {
				setInterval(
					function() {
						//console.log(window.infoMessages);
						if ($('#tooltip').css('opacity') > 0) {
							return;
						}
						for (i in data) {
							for (k in data[i]) {
								if (k.indexOf("_errors") != -1) {
									var css = 'bg-rose';
									if (data[i][k].length) {
										var msg = '<p>' + data[i][k].pop().replace(/\n/g, '<p>');
										
										$('#tooltip').css('opacity', 0.9).
											//css('top', window.scrollY + 'px').
											removeClass(back_done).
											removeClass(back_fail).
											addClass(back_fail)[0].innerHTML = msg;
										return;
									}
								}
								if (k.indexOf("_messages") != -1) {
									var css = 'bg-light-green';
									if (data[i][k].length) {
										var msg = '<p>' + data[i][k].pop().replace(/\n/g, '<p>');
										$('#tooltip').css('opacity', 0.9).
											//css('top', window.scrollY + 'px').
											removeClass(back_done).
											removeClass(back_fail).
											addClass(back_done)[0].innerHTML = msg;
										return;
									}
								}
								
							}
						}
					}, 1000
				);
			}
		}
		//анимация затухания
		var tooltip_show_delay = 10 * 1000,
				interval = 75,
				opacity = 0, counter = 0;
			setInterval(
				function () {
					if ($('#tooltip').css('opacity') > 0) {
						var int = setInterval(
							function () {
								if ($('#tooltip').css('opacity') == 0) {
									counter = opacity = 0;
								} else {
									if (opacity == 0) {
										counter += interval;
									}
									if (counter > tooltip_show_delay) {
										opacity = $('#tooltip').css('opacity');
									}
									if (opacity > 0) {
										opacity -= 0.02;
										if (opacity < 0) {
											opacity = 0;
										}
										$('#tooltip').css('opacity', opacity);
										if (opacity == 0) {
											counter = opacity = 0;
											clearInterval(int);
										}
									}
								}
							},
							interval
						);
					}
				}
				,2*1000
		);
	}
	/**
	 * Добавить предупреждение в очередь тултипа
	**/
	function addTooltipWarning(s)  {
		_addTooltipMsg(s, "errors");
	}
	/**
	 * Добавить сообщение об ошибке в очередь тултипа
	**/
	function addTooltipError(s)  {
		_addTooltipMsg(s, "errors");
	}
	/**
	 * Добавить сообщение в очередь тултипа
	**/
	function addTooltipMessage(s)  {
		_addTooltipMsg(s, "messages");
	}
	/**
	 * @desc Добавить сообщение в очередь тултипа
	 * @param s
	 * @param key "errors"|"messages"
	**/
	function _addTooltipMsg(s, key)  {
		key = "ajax_" + key;
		var data = {};
		data[key] = [s];
		window.infoMessages[parseInt(new Date().getTime()) + Math.random()] = data;
	}
//====== /Тултипы
	/**
	 * @desc Если пользователь неавторизован и у него нет guid надо его указать
	 * */
	function initGuid() {
		function onGuidSuccess(data) {
			window.guid = guid = data.guid;
			$.cookie('guest_id', guid, {expires:100, path: '/'});
		}
		function onGuidFail() {
			setTimeout(
				function () {
					initGuid();
				}, 15*1000
			);
		}
		if (!window.USE_GUID_SESSION) {
			return;
		}
		if (!$.cookie('guest_id')) {
			req({}, onGuidSuccess, onGuidFail, 'getGuid', WEB_ROOT + '/console/');
		} else {
			window.guid = guid = $.cookie('guest_id');
		}
	}
	/**
	 * @desc Инициализация вспомогательных функций управления всплывающим окном
	**/
	function initWinFunctions() {
		window.onWinClose = function() {
		}
	}
	/**
	 * Перегружено для шаблона simple_page
	*/
	function initMainPage() {
		setTimeout(
			function() {
				var footer = $(document).find('body > footer'),
					vH = getViewport().h,
					contentH = $('.simple_page_content').first().height(),
					tbarH = $('.toolbar').first().height(),
					footerH = $('body footer').last().height(),
					h,
					div = $('<div>&nbsp;</div>');
				if (vH > contentH && $('body footer')[0]) {
					//h = vH - contentH - footerH - tbarH;
					h = vH - $('body footer').last()[0].offsetTop  - footerH;
					$('body footer').last().before(div);
					div.height(h);
				}
				if (!window.onresize) {
					window.onresize = initMainPage;
				}
			},
			1
		);
		
	}
	/**
	 * @desc А здесь можно будет что-то красивое и эффектное сделать при желании
	*/
	function showError(s) {
		alert(s);
	}
	//================Авторизация=======================================
	/**
	 * @desc Формы логина и регистрации
	*/
	function initSigninButton() {
		$('#bSignin').click(
			function() {
				var o = $('#authForm');
				if (o.hasClass('hide')) {
					o.removeClass('hide');
					$('#login').focus();
				} else {
					o.addClass('hide');
				}
				return false;
			}
		);
		function _onSuccess(data) {
			if (data.success == 1) {
				if (window.location.href.indexOf('/remind') == -1) {
					window.location.reload();
				} else {
					window.location.href = '/';
				}
			} else {
				showError(lang['user_not_found']);
			}
		}
		function _loginAction() {
			req({email:$('#login').val(), password:$('#password').val()}, _onSuccess, defaultAjaxFail, 'login', WEB_ROOT + '/login');
			return false;
		}
		$('#aop').click(_loginAction);
		$('#password').keydown(
			function (evt) {
				if (evt.keyCode == 13 && $.trim($('#password').val()).length > 0) {
					_loginAction();
				}
			}
		);
	}
	function initSignupButton() {
		function _onSuccess(data) {
			if (data.status == 'ok') {
				showError(data.sError);
				//window.location.reload();
				appWindowClose();
			} else {
				showError(data.sError);
			}
		}
		function showRegForm() {
			$('#authForm').addClass('hide');
			appWindow('regFormWrapper', lang['SignUp']);
			return false;
		}
		$("#regLink").click(showRegForm);
		$("#regLink2").click(showRegForm);
		$("#breg").click(
			function () {
				var pwd = $('#rpassword').val(), pwdC = $('#password_confirm').val(), email = $('#rlogin').val(),
					name = $('#uname').val(), sname = $('#usname').val(), data;
				if (pwd == pwdC && pwd.length && email.length) {
					data = {email:email, password:pwd, pc:pwdC, name: name, sname: sname};
					if ($('#regfstr')[0]) {
						data.regfstr = $('#regfstr').val();
					}
					req(data, _onSuccess, defaultAjaxFail, 'signup', WEB_ROOT + '/login');
				} else {
					showError(lang['email_required'] + ' ' + lang['and_password_required']);
				}
				//appWindowClose();
			}
		);
		$("#refimg").click(
			function(){
				$("#refimg").prop('src', '/programming_fundamentals/img/random?r=' + Math.random());
			}
		);
		function _checkStrongPassword(s) {
			$('#password_validate').removeClass('hide');
			if (/[A-Za-z]+/.test(s) && /[0-9A-Za-z]{6,111}/.test(s) && /[0-9]+/.test(s)) {
				$('#password_validate').removeClass('password_no_equ').addClass('password_equ').text(lang['strong_password']);
			} else {
				$('#password_validate').removeClass('password_equ').addClass('password_no_equ').text(lang['easy_password']);
			}
		}
		function _checkEquivPassword(s) {
			$('#password_equ').removeClass('hide');
			if (s == $('#rpassword').val()) {
				$('#password_equ').removeClass('password_no_equ').addClass('password_equ').text(lang['password_match']);
			} else {
				$('#password_equ').removeClass('password_equ').addClass('password_no_equ').text(lang['password_not_match']);
			}
		}
		$('#rpassword').keydown(
			function(){
				var o = this;
				setTimeout(
					function(){
						_checkStrongPassword(o.value);
					}
					,100
				);
			}
		);
		$('#password_confirm').keydown(
			function(){
				var o = this;
				setTimeout(
					function(){
						_checkEquivPassword(o.value);
					}
					,100
				);
			}
		);
	}
	//================/Авторизация======================================
	
	function initCreateTest() {
            //мета данные теста
            function _setGreenBg(div) {
                    $('.j-v_type, .j-t_type').removeClass('bg-light-green');
                    $(div).addClass('bg-light-green');
            }
            $('.j-v_type').click(
                    function() {
                            $('#variantTest').prop('checked', true);
                    }
            ).hover(
                    function(evt) {
                            _setGreenBg('.j-v_type');
                    }
            );
            $('.j-t_type').click(
                    function() {
                            $('#textTest').prop('checked', true);
                    }
            ).hover(
                    function(evt) {
                            _setGreenBg('.j-t_type');
                    }
            );
            //страница вопросов
            function _questionBlockSaveListener(evt){
                function _onSuccess(data) {
                   $('input[data-ord=' + data.ord + ']').val(data.id);
                   //TODO зеленый back
                }
                var o = $(evt.target).parent(),
                     h = o.find('input[type=hidden]').first();
                var data = {
                    question: o.find('.j-question').first().val(),
                    answer: o.find('.j-answer').first().val(),
                    ord: h.data('ord'),
                    id: h.val()
                };
                req(data, _onSuccess, defaultAjaxFail, 'save_question');
            }
            function _questionBlockDeleteListener(evt){
                function _onSuccess(data) {
                   if (data.id) {
                       $('input[value=' + data.id + ']').parent().remove();
                   } else {
                       showError(lang['default_error']);
                   }
                }
                var o = $(evt.target).parent(),
                     h = o.find('input[type=hidden]').first();
                var data = {
                    id: h.val()
                };
                req(data, _onSuccess, defaultAjaxFail, 'delete_question');
            }
            function _onSuccessSwapQuery(data) {
                if (data.id && data.id2) {
                    var inp_1 = $('input[value=' + data.id + ']') ,
                        block_1 = inp_1.parent(),
                        ta_1_1 = block_1.find('textarea').first(),
                        ta_1_2 = block_1.find('textarea').last(),
                        buf_1 = ta_1_1.val(),
                        buf_2 = ta_1_2.val(),
                        inp_2 = $('input[value=' + data.id2 + ']') ,
                        block_2 = inp_2.parent(),
                        ta_2_1 = block_2.find('textarea').first(),
                        ta_2_2 = block_2.find('textarea').last();
                    inp_1.val( data.id2 );
                    inp_2.val(data.id);
                    ta_1_1.val( ta_2_1.val() );
                    ta_1_2.val( ta_2_2.val() );
                    ta_2_1.val( buf_1 );
                    ta_2_2.val( buf_2 );
                } else if (data.id) {
                    $('input[value=' + data.id + ']').parent().remove();
                    showError(lang['Moved']);
                }else {
                    showError(lang['default_error']);
                }
                if (data.derror) {
                    showError('Ppc');
                }
            }
            function _sendSwapQuery(evt, action){
                var o = $(evt.target).parent(),
                     h = o.find('input[type=hidden]').first();
                var data = {
                    id: h.val()
                };
                req(data, _onSuccessSwapQuery, defaultAjaxFail, action);
            }
            function _questionBlockUpListener(evt){
                _sendSwapQuery(evt, 'up_question');
            }
            function _questionBlockDownListener(evt){
                _sendSwapQuery(evt, 'down_question');
            }
            $('.question-save-button').click(_questionBlockSaveListener);
            $('.question-delete-button').click(_questionBlockDeleteListener);
            $('.question-up-button').click(_questionBlockUpListener);
            $('.question-down-button').click(_questionBlockDownListener);
            $('#addNewQuest').click(
                function () {
                    var css_v = '.question-area', lastItem = $(css_v).last(),
                        last = lastItem.html(),
                        newBlock = $('<div class="' + css_v + '">' + last + '</div>');
                    
                    newBlock.find('input[type=hidden]').first().attr('data-ord',  +newBlock.find('input[type=hidden]').first().attr('data-ord') + 1).val(0);
                    newBlock.find('textarea').val('');
                    newBlock.insertAfter(lastItem);
                    newBlock.find('.question-save-button').first().click(_questionBlockSaveListener);
                    newBlock.find('.question-delete-button').first().click(_questionBlockDeleteListener);
                    newBlock.find('.question-up-button').first().click(_questionBlockUpListener);
                }
            );
	}
	
	function initScrollSaver() {
		var current = window.location.href, key = 'savedUrl', saved = localStorage.getItem(key), n, url;
		if ( current.indexOf('?') > current.indexOf('#') ) {
			n = '?';
		} else {
			n = '#';
		}
		url = current.split(n)[0];
		if (current == saved) {
			n = localStorage.getItem(url);
			if (n) {
				$('#article').prop('scrollTop', n);
			}
		}
		localStorage.setItem(key, current);
		if ($('#article')[0]) {
			$('#article')[0].onmousewheel = function () {
				localStorage.setItem(url, $('#article').prop('scrollTop') );
			}
		}
	}
	//ajax helper
	function req(data, success, fail, id, url, method) {
		if (!method) {
			method = 'post';
		}
		data.xhr = 1;
		data.action = id;
		$.ajax({
			dataType:'JSON',
			data:data,
			method:method,
			url:(url ? url : window.location.href),
			success:success,
			error:fail
		});
	}
	function defaultAjaxFail() {
		hideLoader();
		showError(lang['default_error']);
	}
	//====================Ресурсы=======================================
	function initResourcesPage() {
		if ( $('#uploadResShowForm')[0] ) {
			$('#uploadResShowForm').click(
				function() {
					appWindow('addResourceFormWrapper', lang['upload_resource_title']);
				}
			);
			
			$('#btnSearchRes').click(
				function() {
					$('#resFormFilter')[0].submit();
				}
			);
			$('.j-upres').click(
				function() {
					var id = $(this).data('id'),
						name = $(this).data('name');
					$('#res_edit_id').val(id);
					$('#resDisplayName').val(name);
					appWindow('addResourceFormWrapper', lang['update_resource_title']);
				}
			);
			function _onSuccesDelete() {
				window.location.reload();
			}
			$('.j-remres').click(
				function() {
					var id = $(this).data('id');
					if (confirm(lang['confirm_removal_resource'])) {
						req({id:id}, _onSuccesDelete, defaultAjaxFail, 'delete');
					}
				}
			);
			$('.j-taselall').click(
				function() {
					$(this).select();
				}
			);
			$('#addResourceForm')[0].onsubmit = function() {
				if ($('#resFile')[0].files[0].size > 5 * 1024*1024) {
					showError(lang['file_too_big']);
					return false;
				}
			}
		}
	}
	//====================/Ресурсы======================================
	
	
})(jQuery)
