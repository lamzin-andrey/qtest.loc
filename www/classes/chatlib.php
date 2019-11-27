<?php
//require_once __DIR__  .  '/../q/utils.php'; TODO add new utils if need
require_once __DIR__  .  '/sys/utils.php'; 

class ChatLib {
	/**
	 * @property int $mode 1 - режим  легкий, то есть добавляет только цифровые типы, как надо обернуть path
	 *                     2 - режим  "тяжелый", то есть parseMessage вернет в каждом элементе
	 * type => int
	 * substr => string
	 * Этот результат можно передать buildMessage
	*/
	static public $mode = 1;
	/**
	 * @description затирает types в элементах  $resData своими значениями
	 * @param array $resData @see результат работы parseMessage при $mode == 2
	 * @param array $priorityTypes @see результат работы parseMessage при $mode == 1
	 * @return array
	*/
	static private function _setPriorityTypes($resData, $priorityTypes) {
		$sz = count($priorityTypes);
		for ($i = 0; $i < $sz; $i++) {
			if (isset($resData[$i]['type'])) {
				$resData[$i]['type'] = $priorityTypes[$i];
			}
		}
		return $resData;
	}
	/**
	 * @description Проходит по тексту сообщения и заменяет все пути на "обертки" в соответствии с $resData
	 * @param array $resData @see результат работы parseMessage при $mode == 2
	 * @param array $priorityTypes @see результат работы parseMessage при $mode == 1 Если передан, затирает types в элементах  $resData своими значениями
	 * @return string
	*/
	static public function buildMessage($message, $resData, $priorityTypes = false) {
		if (is_array($priorityTypes)) {
			$resData = self::_setPriorityTypes($resData, $priorityTypes);
		}
		$resultTail = $result = '';
		foreach ($resData as $info) {
			$aParts = explode($info['substr'], $message);
			if (count($aParts) > 1) {
				//echo("Ye!\n");
				$result .= $aParts[0] . self::_wrapByType($info['substr'], $info['type']);
				array_shift($aParts);
				//array_shift($aParts);
				if (count($aParts)) {
					$message = join($info['substr'], $aParts);
					if (count($aParts) == 1) {
						$resultTail = $aParts[0];
					}
				} else {
					$message = $aParts[1];
				}
			}
		}
		if (!$result) {
			$result = $message;
		} else if($resultTail) {
			$result .= $resultTail;
		}
		$result = self::_setSmiles($result);
		$result = str_replace("\n", "<br>", $result);
		return $result;
	}
	/**
	 * @description
	 * @param array $resData
	 * @return string
	*/
	static public function _wrapByType($s, $type) {
		$type = intval($type);
		switch ($type) {
			case 1:
				return '<a href="' . $s . '" target="_blank">' . $s . '</a>';
			case 2:
				return '<div><a href="' . $s . '" target="_blank">' . '<img src="' . $s . '"></a></div>';
			case 3:
				return '<div><audio controls>
  <source src="' . $s . '" type="audio/mpeg">
Your browser does not support the audio element.
</audio></div>';
			case 4:
				$youLink = self::_getYoutubeLink($s);
				return '<div style="position:relative;height:0;padding-bottom:56.25%"> <iframe src="' . $youLink . '" width="640" height="360" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen></iframe></div>';
		}
		return $s;
	}
	/**
	 * @description Проходит по тексту сообщения и ищет в нем количество файловых путей,
	 *  содержащих /. Все подстроки со слешем содержащие расширения png, jpg, gif 
	 * проверяются на существование.
	 * Возвращает массив едениц и нулей, где 0 говорит о том, что подстрока не ведет
	 * 	к реальному файлу.
	 * Для http всегда возвращает 1
	 * @return array
	*/
	static public function parseMessage($message) {
		$s = $message;
		$offset = 0;
		$res = [];
		do {
			$pos = strpos($s, '/', $offset);
			if ($pos !== false) {
				$oData = self::_checkString($s, $pos);
				$pos = $oData->pos;
				$isExists = $oData->isExists;
				$offset = $pos;
				$res[] = $isExists;
			} else {
				break;
			}
		} while(true);
		return $res;
	}
	/**
	 * @description Ищет границы ссылки, содержащей / в позиции. Устанавливает $isExists в 
	 * 	1 если полученная строка это гиперссылка,
	 *  2 если путь к существующему изображению на сервере,
	 *  3  если путь к существующему аудио на сервере,
	 * @return {pos:int позицию первого разрва подстроки содержащей / или длину строки, isExists:int}
	*/
	static private function _checkString($s, $pos) {
		$oData = self::_getSubstr($s, $pos);
		$str = $oData->subs;
		$pos = $oData->pos;
		$isExists = 0;
		if ($str) {
			if (self::_isYoutubeLink($str)) {
				$isExists = 4;
			}
			if (self::_isExistsImage($str)) {
				$isExists = 2;
			}
			$oData = self::_isExistsAudio($str);
			if ($oData->isExists) {
				$isExists = 3;
			}
			if (self::_isTextHiperlink($str)) {
				$isExists = 1;
			}
			if (self::$mode == 2) {
				$isExists = ['type' => $isExists, 'substr' => $str];
			}
		}
		$result = new StdClass();
		$result->pos = $pos;
		$result->isExists = $isExists;
		return $result;
	}
	/**
	 * @description На удаленном сервере существования audio  не проверяет
	 * @return bool true Если это гиперссылка или путь от корня сервера к audio file
	*/
	static private function _isExistsAudio($str) {
		$extensions = ['.mp3', '.ogg', '.wav'];
		return self::_isExistsResource($str, $extensions);
	}
	/**
	 * @description На удаленном сервере существования изображения не проверяет
	 * @return bool true Если это гиперссылка или путь от корня сервера к изображению
	*/
	static private function _isExistsImage($str) {
		$extensions = ['.png', '.jpg', '.jpeg', '.jpe', '.gif'];
		$file = false;
		$result = self::_isExistsResource($str, $extensions);
		$file = $result->filePath;
		$r = $result->isExists;
		if ($r && $file) {
			$data = getImageSize($file);
			if (!isset($data['mime'])) {
				return false;
			}
		}
		return $r;
	}
	/**
	 * @description На удаленном сервере существования медиа файла не проверяет. 
	 * @param string $str - строка вида [http[s]://]/a/bc/def/ghjk[/file.extension]
	 * @param array $extensions - массив добустимых расширений изображения
	 * @return StdClass {isExists: bool, filePath:string} 
	 *    filePath  - сюда запишется абсолютный путь к файлу в том случае, если он находится на нашем сервере
	 *    isExists - true Если это гиперссылка или путь от корня сервера к медиа файлу (медиа включает в себя по идее и изображения)
	*/
	static private function _isExistsResource($str, $extensions) {
		$filePath = null;
		$isExists = null;
		$result = new StdClass();
		$su = strtolower($str);
		$isTargetLink = 0;
		foreach ($extensions as $ext){
			//echo "'$su', '$ext'\n";
			if (strpos($su, $ext) !== false) {
				$isTargetLink = 1;
				//echo "???\n";
				break;
			}
		}
		if (!$isTargetLink) {//die('HERE');
			$result->isExists = false;
			$result->filePath = '';
			return $result;
		}
		$isHttp = strpos(trim($str), 'http') === 0;
		if ($isHttp) {
			$a = parse_url($str);
			if ($a['host'] == $_SERVER['HTTP_HOST']) {
				$str = $_SERVER['DOCUMENT_ROOT'] . $a['path'];
				//echo "will serach $str\n";
			} else {
				$result->isExists = true;
				$result->filePath = '';
				return $result;
			}
		} else {
			$str = $_SERVER['DOCUMENT_ROOT'] . $str;
		}
		
		if (file_exists($str)) {
			$filePath = $str;
			$result->isExists = true;
			$result->filePath = $filePath;
			return $result;
			return true;
		} else {
			$result->isExists = false;
			$result->filePath = '';
			return $result;
			return false;
		}
	}
	/**
	 * @return bool true Если это гиперссылка не ведущая на аудио или изображение
	*/
	static private function _isTextHiperlink($str) {
		if (self::_isYoutubeLink($str)) {
			return false;
		}
		if (self::_isExistsImage($str)) {
			return false;
		}
		$oData = self::_isExistsAudio($str);
		$isExists = $oData->isExists;
		if ($isExists) {
			return false;
		}
		$isHttp = strpos(trim($str), 'http') === 0;
		return $isHttp;
	}
	/**
	 * @description Устанавливает позицию первого разрва подстроки содержащей / или длину строки
	 * @return StdClass {pos:int, subs:string}
	 * string Возвращает подстроку, содержащую / в позиции $pos
	*/
	static private function _getSubstr($s, $pos) {
		$oResult = new StdClass();
		$breaks = ["\n", "\r", "\t", ' '];
		$start = $pos;
		$end = -1;
		$isStartFound = false;
		for ($i = $pos; $i > -1; $i--) {
			$ch = charAt($s, $i);
			if (in_array($ch, $breaks)) {
				$start = $i;
				$isStartFound = true;
				break;
			}
		}
		if (!$isStartFound) {
			$start = 0;
		}
		$sz = strlen($s);
		for ($i = $pos; $i < $sz; $i++) {
			$ch = charAt($s, $i);
			//echo "$ch\n";
			if (in_array($ch, $breaks)) {
				$pos = $end = $i;
				break;
			}
		}
		if ($end == -1) {
			//die("End not found!" . __LINE__);
			$pos = $sz;
			$oResult->pos = $pos;
			$oResult->subs = trim(substr($s, $start));
			return $oResult;
		}
		$result = trim(substr($s, $start, ($end - $start)));
		$oResult->pos = $pos;
		$oResult->subs = $result;
		return $oResult;
	}
	/**
	 * @description Преобразовать ссылку на youtube в ссылку iframe на hjkbr
	*/
	static  private function _getYoutubeLink($s) {
		$aUrl = parse_url($s);
		$sQuery = isset($aUrl['query']) ? $aUrl['query'] : '';
		$aPairs = explode('&', $sQuery);
		$sz = count($aPairs);
		$v = null;
		
		for ($i = 0; $i < $sz; $i++) {
			$aVar = explode('=', $aPairs[$i]);
			$sName = trim($aVar[0]);
			$sVal = isset($aVar[1]) ? trim($aVar[1]) : null;
			if ($sName == 'v') {
				$v = $sVal;
				break;
			}
		}
		if ($v) {
			$s = "https://www.youtube.com/embed/{$v}?ecver=2";
		}
		return $s;
	}
	/**
	 * @return bool если это ссылка на youtube
	*/
	static private function _isYoutubeLink($str) {
		$aUrl = parse_url($str);
		if (isset($aUrl['host']) && ($aUrl['host'] == 'youtube.com' || $aUrl['host'] == 'www.youtube.com')) {
			return true;
		}
		return false;
	}
	/**
	 * @return string Строка в которой известные символы смайлов заменены на <s id="smileid"> </s>
	*/
	static private function _setSmiles($str) {
		$a = self::getSmileMap();//TODO
		//$sizing = self::getSmileSizing();//TODO
		foreach ($a as $subs => $key) {
			$tpl = "<s id=\"{$key}\"> </s>";
			$str = str_replace($subs, $tpl, $str);
		}
		return $str;
	}
	/**
	 * @return array массив, в котором ключи - это подстроки - обозначения смалов, а значения - css селекторы соотв. смайлов.
	 *  Значения также являются ключами массива getSmileSizing
	*/
	static private function getSmileMap() {
		return [
		':D' => 'laught',
		'(cool)' => 'cool',
		':)' => 'smile',
		';)' => 'GGG',
		'(handshake)' => 'handshake',
		'(ninja)' => 'ninja',
		'(flex)' => 'forge',
		'(y)' => 'like',
		'(n)' => 'dislike',
		'(bandit)' => 'bandit',
		'(movember)' => 'movember',
		'(santa)' => 'santa',
		'(rofl)' => 'rolf'
		];
	}
	/**
	 * @return array массив, в котором ключи - это css селекторы соотв. смайлов, а значения - размер смайла по вертикали.
	*/
	static private function getSmileSizing() {
		return [
		'cool'=>540,
		'bandit'=>1540,
		'dislike'=>1080,
		'forge'=>1160,
		'GGG'=>700,
		'handshake'=>840,
		'laught'=>1520,
		'like'=>780,
		'movember'=>2180,
		'ninja'=>1880,
		'rolf'=>1600,
		'santa'=>1780,
		'smile'=>1040
		];
	}
	/**
	 * @description На удаленном сервере существования audio  не проверяет
	 * @return bool true Если это гиперссылка или путь от корня сервера к audio file
	*/
	static public function isExistsAudio($str) {
		return self::_isExistsAudio($str);
	}
	/**
	 * @description На удаленном сервере существования изображения не проверяет
	 * @return bool true Если это гиперссылка или путь от корня сервера к изображению
	*/
	static public function isExistsImage($str) {
		return self::_isExistsImage($str);
	}
}
