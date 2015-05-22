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
				ta.height(newH);
			}
			setFontSize(qa, newH);
			setFontSize($('#'), newH);
			setFontSize($('#ut_short_desc'), newH);
			setFontSize($('#ut_main_tRa'), newH);
			$(document.body).css('height', 'auto');
			if ( $(document.body).height() < vp.h ) {
				$(document.body).css('height', '100%');
			}
			proc = 0;
		}
		function setFontSize(qa, newH) {
			qa.css('height', 'auto');
			qa.css('font-size', '');
			while (qa.height() > newH) {
				qa.css('font-size',  Math.floor( parseInt( qa.css('font-size') ) / 1.1 ) + 'px');
			}
			qa.height(newH);
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
				}, 50
			);
		}
	}
)()
