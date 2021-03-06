<?php

/**
 * Конвертит win1251 utf8 если строка в windows-1251
 * */
function utils_utf8($s) {
	return mb_convert_encoding($s, "UTF-8", "WINDOWS-1251");
	return $s;
}

/**/
function checkMail($mail)	 {
	 $reg = "#^[\w\.]+[^\.]@[\w]+\.[\w]{2,4}#";	 
	 $n = preg_match($reg, $mail, $m);
	 return $n;
 }
/**
 * выдает в поток данные в json формате
 * четные аргументы - ключи, нечетные - значения
 * в данных всегда присутствует status => ok 
*/
function json_ok() {
 $sz = func_num_args();
 $data['status'] = "ok";
 if ((int)@$_POST['reqi'] > 0) {
 	$data["reqi"]= $_POST['reqi'];
 }
 if ((int)@$_POST['dbfrts'] > 0) {
 	$data["dbfrts"]= $_POST['dbfrts'];
 }
 //"reqi", $_POST['reqi']
 for ($i = 0; $i < $sz; $i++) {
 	if ($i + 1 < $sz) {
 		$data[func_get_arg($i)] = func_get_arg($i + 1);
 		$i++;
 	}
 }
 die(json_encode($data));
}
/**
 * Добавляет в массив элемент 'status' => 'ok' и выдает в поток данные в json формате
*/
function json_ok_arr($data) {
	$data['status'] = 'ok';
	die(json_encode($data));
}
/**
 * выдает в поток данные в json формате
 * четные аргументы - ключи, нечетные - значения
 * в данных всегда присутствует status => error 
 * */
function json_error() {
	$sz = func_num_args();
	$data['status'] = "error";
 	for ($i = 0; $i < $sz; $i++) {
 		if ($i + 1 < $sz) {
 			$data[func_get_arg($i)] = func_get_arg($i + 1);
 			$i++;
 		}
 	}//mysql_close();
	die(json_encode($data));
}

/**
 * @desc Добавляет к корню слова окончание в зависимости от величины числа n
 * @param n - число
 * @param root корень слова
 * @param one окончание в ед. числе
 * @param less4 окончание при величине числа от 1 до 4
 * @param more19 окончание при величине числа более 19
 * @returString
 */
 function dbfr_getSuffix($n, $root, $one, $less4, $more19, $dbg = false) {
         $m = strval($n);
         if (strlen($m) > 1) {
             $m =  intval( $m[ strlen($m) - 2 ] . $m[ strlen($m) - 1 ] );
         }
         $lex = $root . $less4;
         if ($m > 20) {
             $r = strval($n);
             $i = intval( $r[ strlen($r) - 1 ] );
             if ($i == 1) {
                 $lex = $root . $one;
             } else {
                 if ($i == 0 || $i > 4) {
                    $lex = $root . $more19;
                 }
             }
         } else if ($m > 4 || $m == '00') {
             $lex = $root . $more19;
         } else if ($m == 1) {
             $lex = $root . $one;
         }
         return $lex;
 }

 /**
 * @descr 
 * @param
 * @param
 * @return
 **/
 function utils_cp1251($s) {
 	return mb_convert_encoding($s, "WINDOWS-1251", "UTF-8");
 }
 /**
 * @desc 
 * @param
 * @param
 * @return
 **/
 function utils_money($v) {
 	$v = str_replace('.', ',', $v);
 	$a = explode(',', $v);
 	$s = $a[0];
 	$q = array();
 	for ($i = strlen($s) - 1, $j = 1; $i > -1; $i--, $j++) {
 		$q[] = $s[$i];
 		if ($j % 3 == 0) $q[] = ' ';
 	}
 	$a[0] = join("", array_reverse($q));
 	if (@$a[1] == '00') return $a[0] . utils_utf8(' Руб.');
 	$v = join(",", $a);
 	return $v . utils_utf8(' Руб.');
 }
 
function now($ignore_summer_time = false) {
	@date_default_timezone_set('Europe/Moscow');
    $d = date("Y-m-d H:i:s");
    if ($ignore_summer_time) {
		return $d;
	}
    return date("Y-m-d H:i:s", strtotime($d) + SUMMER_TIME);
}
/**
 * @desc Функция ресайза png c сохранением прозрачности
 * @param string $srcFilename   - путь к файлу изображения в формате png
 * @param string $destFilename  - путь к файлу изображения в формате png
 * @param int   $destW - требуемая ширина изображения
 * @param int   $destH - требуемая высота изображения
 * @param array $defaultTransparentColor [0,0,0] - это значение цвета будет использоваться как прозрачное, если прозрачный цвет не удасться определить из исходного изображения 
 * */
function utils_pngResize($srcFilename, $destFilename, $destW, $destH, $compression = 9, $defaultTransparentColor = array(0, 0, 0)) {
	if (!$img = @imagecreatefrompng($srcFilename)) {
		throw new Exception('Ошибка формата изображения');
	}
	$sz = getImageSize($srcFilename);
	$srcW = $sz[0];
	$srcH = $sz[1];
	$output = imagecreatetruecolor($destW, $destH);
    imagealphablending($output, false); //чтобы не было непрозрачной границы по контуру
    imagesavealpha($output, true);
    $transparencyIndex = imagecolortransparent($img);
    if ($transparencyIndex >= 0) {
        $transparencyColor = imagecolorsforindex($img, $transparencyIndex);
    }
    $transparenctColor = imagecolorallocate($output, $defaultTransparentColor[0], $defaultTransparentColor[1], $defaultTransparentColor[2]);
    imagecolortransparent($output, $transparencyIndex);
    imagefill($output, 0, 0, $transparencyIndex);
    imagecopyresampled($output, $img, 0, 0, 0, 0, $destW, $destH, $srcW, $srcH);
	if (!@imagepng($output, $destFilename, $compression)) {
    	throw new Exception('Ошибка сохранения изображения');
	}
}
/**
 * @desc Функция ресайза png c сохранением прозрачности
 * @param string $srcFilename   - путь к файлу изображения в формате png
 * @param string $destFilename  - путь к файлу изображения в формате png
 * @param int   $destW - требуемая ширина изображения
 * @param int   $destH - требуемая высота изображения
 * @param array $defaultTransparentColor [0,0,0] - это значение цвета будет использоваться как прозрачное, если прозрачный цвет не удасться определить из исходного изображения 
 * */
function utils_gifResize($srcFilename, $destFilename, $destW, $destH, $defaultTransparentColor = array(0, 0, 0)) {
	if (!$img = @imagecreatefromgif($srcFilename)) {
		throw new Exception('Ошибка формата изображения');
	}
	$sz = getImageSize($srcFilename);
	$srcW = $sz[0];
	$srcH = $sz[1];
	$output = imagecreatetruecolor($destW, $destH);
    //imagealphablending($output, false); //чтобы не было непрозрачной границы по контуру
    //imagesavealpha($output, true);
    $transparencyIndex = imagecolortransparent($img);
    if ($transparencyIndex !== -1) {
        $transparencyColor = imagecolorsforindex($img, $transparencyIndex);
    }
    $transparenctColor = imagecolorallocate($output, $defaultTransparentColor[0], $defaultTransparentColor[1], $defaultTransparentColor[2]);
    imagecolortransparent($output, $transparencyIndex);
    imagefill($output, 0, 0, $transparencyIndex);
    imagecopyresampled($output, $img, 0, 0, 0, 0, $destW, $destH, $srcW, $srcH);
	if (!@imagegif($output, $destFilename)) {
    	throw new Exception('Ошибка сохранения изображения');
	}
}

function utils_jpgResize($srcFilename, $destFilename, $destW, $destH, $quality = 80) {
	if (!$img = @imagecreatefromjpeg($srcFilename)) {
		throw new Exception('Ошибка формата изображения');
	}
	$sz = getImageSize($srcFilename);
	$srcW = $sz[0];
	$srcH = $sz[1];
	$output = imagecreatetruecolor($destW, $destH);
    imagecopyresampled($output, $img, 0, 0, 0, 0, $destW, $destH, $srcW, $srcH);
	if (!@imagejpeg($output, $destFilename, $quality)) {
    	throw new Exception('Ошибка сохранения изображения');
	}
}

function utils_404($template = null, $masterTemplate = null) {
	header("HTTP/1.1 404 Not Found");
	if ($template && !$masterTemplate) {
		if (file_exists($template)) {
			include_once $template;
		}
	} elseif($masterTemplate && $template){
		if (file_exists($template) && file_exists($masterTemplate)) {
			$content = $template;
			include_once $masterTemplate;
		}
	}elseif($masterTemplate){
		if (file_exists($masterTemplate)) {
			include_once $masterTemplate;
		}
	}
}

function utils_302($location = "/") {
	header("location: $location");
	exit;
}

function utils_getExt($filename){
	if (strpos($filename, '.') === false) {
		return '';
	}
	$a = explode(".", $filename);
	$s = $a[ count($a) - 1 ];
	return $s;
}
function utils_getImageMime($path, &$w = null, &$h = null) {
	$sz = @getImageSize($path);
	if (is_array($sz) && count($sz)) {
		$w = $sz[0];
		$h = $sz[1];
		return $sz["mime"];
	}
}

function utils_translite_url ($string)  {
	$string = str_replace("ё","e",$string);
	$string = str_replace("й","i",$string);
	$string = str_replace("ю","yu",$string);
	$string = str_replace("ь","",$string);
	$string = str_replace("ч","ch",$string);
	$string = str_replace("щ","sh",$string);
	$string = str_replace("ц","c",$string);
	$string = str_replace("у","u",$string);
	$string = str_replace("к","k",$string);
	$string = str_replace("е","e",$string);
	$string = str_replace("н","n",$string);
	$string = str_replace("г","g",$string);
	$string = str_replace("ш","sh",$string);
	$string = str_replace("з","z",$string);
	$string = str_replace("х","h",$string);
	$string = str_replace("ъ","",$string);
	$string = str_replace("ф","f",$string);
	$string = str_replace("ы","y",$string);
	$string = str_replace("в","v",$string);
	$string = str_replace("а","a",$string);
	$string = str_replace("п","p",$string);
	$string = str_replace("р","r",$string);
	$string = str_replace("о","o",$string);
	$string = str_replace("л","l",$string);
	$string = str_replace("д","d",$string);
	$string = str_replace("ж","j",$string);
	$string = str_replace("э","e",$string);
	$string = str_replace("я","ya",$string);
	$string = str_replace("с","s",$string);
	$string = str_replace("м","m",$string);
	$string = str_replace("и","i",$string);
	$string = str_replace("т","t",$string);
	$string = str_replace("б","b",$string);
	$string = str_replace("Ё","E",$string);
	$string = str_replace("Й","I",$string);
	$string = str_replace("Ю","YU",$string);
	$string = str_replace("Ч","CH",$string);
	$string = str_replace("Ь","",$string);
	$string = str_replace("Щ","SH",$string);
	$string = str_replace("Ц","C",$string);
	$string = str_replace("У","U",$string);
	$string = str_replace("К","K",$string);
	$string = str_replace("Е","E",$string);
	$string = str_replace("Н","N",$string);
	$string = str_replace("Г","G",$string);
	$string = str_replace("Ш","SH",$string);
	$string = str_replace("З","Z",$string);
	$string = str_replace("Х","H",$string);
	$string = str_replace("Ъ","",$string);
	$string = str_replace("Ф","F",$string);
	$string = str_replace("Ы","Y",$string);
	$string = str_replace("В","V",$string);
	$string = str_replace("А","A",$string);
	$string = str_replace("П","P",$string);
	$string = str_replace("Р","R",$string);
	$string = str_replace("О","O",$string);
	$string = str_replace("Л","L",$string);
	$string = str_replace("Д","D",$string);
	$string = str_replace("Ж","J",$string);
	$string = str_replace("Э","E",$string);
	$string = str_replace("Я","YA",$string);
	$string = str_replace("С","S",$string);
	$string = str_replace("М","M",$string);
	$string = str_replace("И","I",$string);
	$string = str_replace("Т","T",$string);
	$string = str_replace("Б","B",$string);
	$string = str_replace(" ","_",$string);
	$string = str_replace('"',"",$string);
	$string = str_replace('.','',$string);
	$string = str_replace(',','',$string);
	$string = str_replace("'","",$string);
	$string = str_replace(",",'',$string);
	$string = str_replace('\\', '', $string);
	$string = str_replace('?', '', $string);
	$string = str_replace('/', '_', $string);
	$string = str_replace('&', 'and', $string);
	$allow = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
	$string =  strtolower($string);
	$sz = strlen($string);
	$r = '';
	for ($i = 0; $i < $sz; $i++) {
		$ch = $string[$i];
		if (strpos($allow, $ch) !== false) {
			$r .= $ch;
		}
	}
	return $r;
}



function utils_addScript($script, $code = '', $enc = '') {
	if ($script == "global" && strlen($code)) {
		$GLOBALS["javascriptglobal"][] = $code;
        return '';
	}
	if (strpos($script, "/") !== 0) {
	    $script = DBFR_HROOT . "/$script";
	}
	if ($enc) {
		$enc = 'charset="'.$enc.'"';
	}
    $s = '<script type="text/javascript" src="'.$script.'" '.$enc.'></script>'."\n";
    return $s;
}

function utils_javascript() {
	$s = '<script type="text/javascript">'.join("\n", @$GLOBALS["javascriptglobal"]).'</script>'."\n";
	$s .= @$GLOBALS["javascript"];
	return  $s;
}

function a($v, $k) {
	if ( (is_array($v) || is_string($v) ) && isset($v[$k])) {
		return $v[$k];
	}
	return null;
}
function o($v, $k) {
	if (is_object($v) && isset($v->$k)) {
		return $v->$k;
	}
	return null;
}
/**
 * @desc Работа с сессией
 * **/
function sess($key, $value = null, $default_value = null) {
	if ($value !== null) {
		$_SESSION[$key] = $value;
	}
	if (!a($_SESSION, $key) && $default_value) {
		return $default_value;
	}
	return a($_SESSION, $key);
}
/**
 * @desc Загрузка языков
 * */
function utils_getCurrentLang() {
	$lang = sess('current_lang');
	$file = APP_ROOT. '/lang/' . $lang . '.php';
	if (file_exists($file)) {
		include $file;
	} else {
		$file = APP_ROOT. '/lang/ru.php';
		include $file;
	}
	//print_r($lang);die;
	return $lang;
}
/**
 * @desc получить переменную из request
**/
function req($v, $varname = 'REQUEST') {
	$data = $_REQUEST;
	switch ($varname) {
		case 'POST':
		$data = $_POST;
			break;
		case 'GET':
			$data = $_GET;
			break;
	}
	if (isset($data[$v])) {
		return $data[$v];
	}
	return null;
}
/**
 * @desc получить переменную из request
**/
function is_ajax() {
	return (req('xhr') == '1');
}
/**
 * @desc Перевести первый символ в верхний регистр
**/
function utils_capitalize($s) {
	$enc = mb_detect_encoding($s, array('UTF-8', 'Windows-1251'));
	$us = mb_convert_case($s, 0, $enc);
	$first_char = mb_substr($us, 0, 1, $enc);
	$tail = mb_substr($s, 1, 1000000, $enc);
	return ($first_char . $tail);
}
function utils_createDir($sDir) {
	$a = explode('/', $sDir);
	$aB = ['/'];
	foreach ($a as $s) {
		$aB[] = $s;
		$sPath = join('', $aB);
		if (!file_exists($sPath)) {
			@mkdir($sPath, 755);
		}
		$aB[] = '/';
	}
}
/**
 * @desc строит дерево (структуру данных) с неограниченным уровнем вложенности,
 * @param array $raw_data - не ассоциативный массив с данными TODO разнести на две функции
 * @param int $id_field_name
 * @param int $parent_id_field_name
 * @return tree
**/
function utils_buildTree($raw_data, $id_field_name, $parent_id_field_name, $childs = 'childs') {
	$id = $id_field_name;
	$parent_id = $parent_id_field_name;

	$data = array();
	$search_tree = new SearchTree();
	$i = 0;
	foreach ($raw_data as $key => $item) {
		$data[$item[$id]] = $item;
		if ($i == 0) {
			$search_tree->first($item[$id], $item);
			$i++;
		} else {
			$search_tree->searchAdd($item[$id], true, $item);
		}
	}
	$result = array();
	foreach ($data as $key => $item) {
		$node = $search_tree->searchAdd($key, false);//new SearchTreeNode($key, $item);
		//$ctrl = 0;
		while (true) {
			if ($node->content[$parent_id] == 0 && !isset($result[$node->content[$id]])) {
				$result[$node->content[$id]] = $node->content;
			}
			if ($node->content[$parent_id] == 0) {
				break;
			}
			$parent_node = $search_tree->searchAdd($node->content[$parent_id], false);
			if ($parent_node === false){
				throw new Exception("Неожиданно не найден элемент с id {$node->content[$id]} в бинарном дереве поиска");
			}
			if (!isset($parent_node->content[$childs])) {
				$parent_node->content[$childs] = array();
			}
			$parent_node->content[$childs][$node->content[$id]] = $node->content;
			$success = $search_tree->replaceContent($parent_node->content[$id], $parent_node->content);

			$node = $parent_node;
			if ($node->content[$parent_id] == 0 ) {
				$result[$node->content[$id]] = $node->content;
			}
		}
	}
	if ($node->content[$parent_id] == 0) {
		$result[$node->content[$id]] = $node->content;
	}
	return $result;
}
/**
 * @desc Добавляет к корню слова окончание в зависимости от величины числа n
 * @param n - число
 * @param root корень слова
 * @param one окончание в ед. числе
 * @param less4 окончание при величине числа от 1 до 4
 * @param more19 окончание при величине числа более 19
 * @returString
*/
function utils_getSuffix($n, $root, $one, $less4, $more19, $dbg = false) {
        $m = strval($n);
        if (strlen($m) > 1) {
            $m =  intval( $m[ strlen($m) - 2 ] . $m[ strlen($m) - 1 ] );
        }
        $lex = $root . $less4;
        if ($m > 20) {
            $r = strval($n);
            $i = intval( $r[ strlen($r) - 1 ] );
           if ($i == 1) {
                $lex = $root . $one;
            } else {
                if ($i == 0 || $i > 4) {
                   $lex = $root . $more19;
                }
            }
        } else if ($m > 4 || $m == '00') {
            $lex = $root . $more19;
        } else if ($m == 1) {
            $lex = $root . $one;
        }
        return $lex;
}
/**
 * @desc Перобразовывает дату и з ан8глийского формата в российский
 * @param $date - Строка в  виде YYYY-mm-dd H:m:s (php Y-m-d H:i:s)
 * @param $deleteSeconds - удалять ли секунды
 * @return String
*/
function utils_dateE2R($date, $deleteSeconds = true) {
	if (!preg_match("#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}$#", $date, $m)) {
		return $date;
	}
	$a = explode(" ", $date);
	$b = explode("-", $a[0]);
	$b = join(".", array_reverse($b));
	if ($deleteSeconds) {
		$a[1] = preg_replace("#:[0-9]{2}$#", '', $a[1]);
	}
	$s = $a[1] . " $b";
	return $s;
}
/**
 * @desc
 * @param $app_root       - путь к корню приложения на веб сервере. По этому адресу должен быть каталог YYYY/mm
 * @param $tmp_file       - временный файл, попытаемся определить его расширение
 * @param $src_file_name - если не удастся определить расширение, берется из исходного имени файла
 * @param $is_image - true если это изображение
 * @param $dest_file_name - если задано, то оно и используется вместо md5.ext
 * @return $app_root/YYYY/mm/md5.ext
*/
function utils_getFilePath($app_root, $tmp_file, $src_file_name, &$is_image, $dest_file_name = false) {
	$is_image = false;
	$folder = $app_root . date('/Y/m/');
	if ($dest_file_name) {
		return "{$folder}{$dest_file_name}";
	}
	$a = @getimagesize($tmp_file);
	$ext = '';
	if (is_array($a) && a($a, 'mime')) {
		switch ($a['mime']) {
			case 'image/jpeg':
				$ext = 'jpg';
				$is_image = true;
				break;
			case 'image/png':
				$ext = 'png';
				$is_image = true;
				break;
			case 'image/gif':
				$ext = 'gif';
				$is_image = true;
				break;
			case 'application/x-shockwave-flash':
				$ext = 'swf';
				break;
		}
	} else {
		$ext = preg_replace("#.+\.([A-z0-9]+)$#", '$1', $src_file_name);
		switch ($ext) {
			case 'mp3':
			case 'ogg':
			break;
			default:
			$ext = '';
		}
	}
	if ($ext) {
		$md5 = md5('YmdHis'.$src_file_name);
		$sResult = "{$folder}{$md5}.{$ext}";
		utils_createDir($folder);
		return $sResult;
	}
	return false;
}
/**
* @desc Изменить значение переменной var в request_uri
* @param string $var
* @param string $val
* @return string
**/
function utils_setUrlVar($var, $val) {
	$a = explode("?", $_SERVER["REQUEST_URI"]);
	$base = $a[0];
	$data = array();
	$_GET[$var] = $val;
	if ($val == 1) {
		unset($_GET[$var]);
	}
	foreach ($_GET as $k => $i) {
		$data[] = "$k=$i";
	}
	if (count ($_GET)) {
		$base .= "?" . join('&', $data);
	}
	return $base;
}
function ireq($key, $scope = 'REQUEST'){
	return (int)req($key, $scope);
}
function ilistFromString($key, $separator = ',', $scope = 'REQUEST'){
	$arr = explode($separator, req($key));
	$buf = array();
	foreach ($arr as $item) {
		$n = (int)$item;
		if ($n) {
			$buf[] = $n;
		}
	}
	return $buf;
}
