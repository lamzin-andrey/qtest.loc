//=================AJAX HELPERS=========================================
function  _map(data, read) {
	var $obj, obj, i;
	for (i in data) {
		$obj = $(i);
		if (!$obj[0]) {
			$obj = $('#' + i);
		}
		obj = $obj[0];
		//obj = $obj;
		if (obj) {
			if (obj.tagName == 'INPUT' || obj.tagName == 'TEXTAREA') {
				if (!read) {
					obj.value = data[i];
				} else {
					if (obj.type == 'checkbox') {
						data[i] = obj.checked;
					} else {
						data[i] = obj.value;
					}
				}
			} else {
				if (!read) {
					if (obj.type == 'checkbox') {
						var v = data[i] == 'false' ? false: data[i];
						v = v ? true : false;
						obj.checked = v;
					} else {
						obj.innerText = data[i];
					}
				} else {
					data[i] = obj.innerText;
				}
			}
		}
	}
}
function _get(onSuccess, url, onFail) {
	_restreq('get', {}, onSuccess, url, onFail)
}
function _delete(onSuccess, url, onFail) {
	_restreq('post', {}, onSuccess, url, onFail)
}
function _post(data, onSuccess, url, onFail) {
	var t = getToken();
	if (t) {
		data._token = t;
		_restreq('post', data, onSuccess, url, onFail)
	}
}
function _patch(data, onSuccess, url, onFail) {
	_restreq('patch', data, onSuccess, url, onFail)
}
function _put(data, onSuccess, url, onFail) {
	_restreq('put', data, onSuccess, url, onFail)
}
function _restreq(method, data, onSuccess, url, onFail) {
	/*$('#preloader').show();
	$('#preloader').width(screen.width);
	$('#preloader').height(screen.height);
	$('#preloader div').css('margin-top', Math.round((screen.height - 350) / 2) + 'px');
	*/
	if (!url) {
		url = window.location.href;
	} else {
		url = W.root + url;
	}
	if (!onFail) {
		onFail = defaultFail;
	}
	switch (method) {
		case 'put':
		case 'patch':
		case 'delete':
			break;
	}
	/*$.ajax({
		method: method,
		data:data,
		url:url,
		dataType:'json',
		success:onSuccess,
		error:onFail
	});*/
	pureAjax(url, data, onSuccess, onFail, method);
}


/**
 * @desc Аякс запрос к серверу, использует JSON
*/
function pureAjax(url, data, onSuccess, onFail, method) {
	var xhr = new XMLHttpRequest();
	//подготовить данные для отправки
	var arr = []
	for (var i in data) {
		arr.push(i + '=' + encodeURIComponent(data[i]));
	}
	var sData = arr.join('&');
	//установить метод  и адрес
	//console.log("'" + url + "'");
	xhr.open(method, url);
	//console.log('Open...');
	//установить заголовок
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	//обработать ответ
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
			var error = {};
			if (xhr.status == 200) {
				try {
					var response = JSON.parse(String(xhr.responseText));
					onSuccess(response, xhr);
					return;
				} catch(e) {
					console.log(e);
					error.state = 1;
					error.info = 'Fail parse JSON';
				}
			}else {
				error.state = 1;
			}
			if (error.state) {
				onFail(xhr.status, xhr.responseText, error.info, xhr);
			}
		} else if (xhr.readyState > 3) {
			onFail(xhr.readyState, xhr.status, xhr.responseText, 'No ok', xhr);
		}
	}
	//отправить
	//console.log('bef send');
	xhr.send(sData);
	//console.log('aft send');
}
/**
 * @description Инпут с соответствующими атрибутами будет при выборе файла отправлять данные на data-url
 * Передаются опционально:
 * data-onselect - обработка выбора файла, если передать функцию, не будет немедленной отправки.
 * В этом случае надо вызвать sendFile(iFile, url, onSuccess, onFail,  onProgress) когда надо отправить файл
 * onProgress будет вызвана с аргументами loadedPercents, loadedButes, total
 * onFail будет вызвана с аргументами status, arguments  - оригинальные параметры
*/
function initFileInputs() {
	W.iFiles = {};
	var ls = ee(D, 'input'), i, j, attrs = {}, k, isValid = 1, onSelect, url;
	for (i = 0; i < ls.length; i++) {
		j = ls[i];
		if (j.type == 'file') {
			url = attr(j, 'data-url' );
			attrs.success    = attr(j, 'data-success');
			attrs.fail       = attr(j, 'data-fail');
			attrs.progress   = attr(j, 'data-progress');
			//не обязательные атрибуты
			onSelect   = attr(j, 'data-select');
			for (k in attrs) {
				if (!(attrs[k] && (window[attrs[k]] instanceof Function)) ) {
					isValid = 0
				}
			}
			if (isValid && j.id) {
				attrs.url = url;
				iFiles[j.id] = attrs;
				initFileInput(j, onSelect);
			}
		}
	}
}
/**
 * @see initFileInputs
*/
function initFileInput(iFile, onSelect) {
	if (window[onSelect] instanceof Function) {
		iFile.onchange = window[onSelect];
		return;
	}
	iFile.onchange = mcrOnSelectFile;
}
/**
 * @see initFileInputs
*/
function mcrOnSelectFile(evt) {
	if(iFiles[evt.target.id]) {
		var o = iFiles[evt.target.id];
		sendFile(e(evt.target.id), o.url, W[o.success], W[o.fail],  W[o.progress]);
	}
}
/**
 * @see initFileInputs
*/
function sendFile(iFile, url, onSuccess, onFail,  onProgress) {
	var xhr = new XMLHttpRequest(), form = new FormData(), t;
	form.append(iFile.id, iFile.files[0]);
	//form.append("isFormData", 1);
	form.append("path", url);//TODO ??
	t = getToken();
	if (t) {
		form.append("_token", t);
	}
	xhr.upload.addEventListener("progress", function(pEvt){
		var loadedPercents, loadedBytes, total;
		if (pEvt && pEvt.lengthComputable) {
			loadedPercents = Math.round((pEvt.loaded * 100) / pEvt.total);
		}
		onProgress(loadedPercents, loadedBytes, total);
	});
	xhr.upload.addEventListener("error", onFail);
	xhr.onreadystatechange = function () {
		t = this;
		if (t.readyState == 4) {
			if(this.status == 200) {
				var s;
				try {
					s = JSON.parse(t.responseText);
				} catch(e){;}
				onSuccess(s);
			} else {
				onFail(t.status, arguments);
			}
		}
    };
    xhr.open("POST", url);
    xhr.send(form);
}
function defaultFail(data) {
	W.requestSended = 0;
	error('Не удалось обработать запрос, попробуйте снова');
}
