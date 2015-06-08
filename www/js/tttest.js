/** ThemeTextTest*/
(
	function() {
		var ta, qa, hSpace = 210, proc = 0;
		$(init);
		function init() {
			ta = $('#ut_main_tanswer');
			qa = $('#ut_main_tquest');
			setTimeout(setTaHeight, 10);
			setInterval(setTaHeight, 500);
			ta.bind('focus',
				function() {
					animateOpacity('+');
				}
			);
			ta.bind('blur',
				function() {
					animateOpacity('-');
				}
			);
		}
		
		function setTaHeight() {
			if (proc !== 0) {
				return;
			}
			proc = 1;
			var vp = getViewport(), newH;
			
			if (ta.height() < vp.h || ta.height() > vp.h) {
				newH = vp.h  - hSpace;
				ta.height(newH + 32); //50 - padding quest area, 18  sum borders
			}
			setFontSize(qa, newH);
			setFontSize([$('#ut_title'), $('#ut_short_desc')], newH);
			setFontSize($('#ut_main_tRa'), newH);
			
			var ra = $('#ut_main_tRa');
			ra.css('margin-left', '0px').css('margin-right', '0px').css('width', '100%');
			var curW = ra.width();
			ra.css('margin-left', '0px').css('margin-right', '0px').css('display', 'inline').css('width', 'auto');
			while (ra.width() > curW) {
				ra.css('font-size',  Math.floor( parseInt( ra.css('font-size') ) / 1.5 ) + 'px');
			}
			ra.css('margin-left', '10%').css('margin-right', '10%').css('display', 'block');
			
			$(document.body).css('height', 'auto');
			if ( $(document.body).height() < vp.h ) {
				$(document.body).css('height', '100%');
			}
			proc = 0;
		}
		function setFontSize(qa, newH) {
			if (qa.constructor == Array) {
				var H = 0, i = 0;
				for (i = 0; i < qa.length; i++) {
					qa[i].css('height', 'auto');
					qa[i].css('font-size', '');
					H += qa[i].height();
				}
				while (H > newH) {
					H = 0;
					for (i = 0; i < qa.length; i++) {
						qa[i].css('font-size',  Math.floor( parseInt( qa[i].css('font-size') ) / 1.1 ) + 'px');
						H += qa[i].height();
					}
				}
			} else {
				qa.css('height', 'auto');
				qa.css('font-size', '');
				while (qa.height() > newH) {
					qa.css('font-size',  Math.floor( parseInt( qa.css('font-size') ) / 1.1 ) + 'px');
				}
				qa.height(newH);
			}
		}
		/**
		 * @description animate opacity
		 * @param dir '-' or '+'
		**/
		function animateOpacity(dir) {
			if (dir != '-' && dir != '+') {
				return;
			}
			animateOpacity.dr = dir;
			var int = setInterval(
				function() {
                                        if ($('#utMainTTPlayscreen').hasClass('hide')) {
                                            ta.css('opacity', 0.1 );
                                            clearInterval(int);
                                            return;
                                        }
					var n = 0.1, lim = 1;
					if (animateOpacity.dr == '-') {
						n *= -1;
						lim = 0.1;
					}
					if (Number(ta.css('opacity')) != lim) {
						ta.css('opacity', Number(ta.css('opacity')) + n );
					} else {
						clearInterval(int);
					}
                                        
				}, 10
			);
		}
	}
)()
