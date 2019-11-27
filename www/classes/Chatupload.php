<?php
require_once __DIR__ . '/../classes/chatlib.php';
//BaseApp тут из набора q

if (!defined('DOC_ROOT')) {
	define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);
}

class ChatUpload /*extends BaseApp*/ {
	
	/** @property _path */
	private $_path = '';
	
	/** @property _url Здесь ссылка на файл (или файловый путь) для чата */
	private $_url = '';
	
	/** @property bool _isImg  */
	private $_isImg = false;
	
	public function __construct() {
		sleep(3);
		$this->table = 'user_media';
		if (isset($_FILES['chatfile'])) {
			$this->_savePhoto($_FILES['chatfile']);
		}
	}
	
	private function _savePhoto($photo) {
		if ($this->_validateFile($photo, $errors)) {
			$success = move_uploaded_file($photo['tmp_name'], $this->_path);
			if ($success) {
				$s = str_replace(DOC_ROOT, '', $this->_path);
				$isAudio = ChatLib::isExistsAudio($s)->isExists;
				$isAudio ? $this->_saveAudioData($photo) : 0;
				/*var_dump($isAudio);
				var_dump($this->_isImg);
				die(__FILE__ . __LINE__);/**/
				if (!$this->_isImg && !$isAudio) {
					$this->_url = SCHEME . $_SERVER['HTTP_HOST'] . $this->_url;
				}
				global $dberror;
				json_ok('path', $this->_url, 'error', $dberror);
				return;
			}
		}
		if ($errors) {
			json_error_arr($errors);
			return;
		}
		json_error('msg', l('unable-upload-file'));
		//return;
	}
	
	private function _saveAudioData($photo) {
		$userId = Auth::getUid();
		if(!$userId) {
			$userId = Auth::createUid();
		}
		$time = now();
		$delta = dbvalue("SELECT max(delta) FROM {$this->table}");
		$photo['name'] = db_escape($photo['name']);
		$delta =  $delta ? ($delta + 1) : 1;
		query("INSERT INTO {$this->table} (`date_create`, `date_update`, `delta`, `name`, `user_id`, `path`) VALUES
		(
			'{$time}',
			'{$time}',
			'{$delta}',
			'{$photo['name']}',
			'{$userId}',
			'{$this->_url}'
		)");
	}
	
	private function _validateFile($photo, &$report = []/*{}*/) {
		
		$errors = [];
		if ($photo['error'] > 0) {
			$report['errors']['chatfile'] = l('file_too_big');
			return false;
		}
		$isImg = false;
		$this->_path = utils_getFilePath(DOC_ROOT . '/files', $photo['tmp_name'], $photo['name'], $isImg, false, false);
		$this->_url = str_replace(DOC_ROOT, '', $this->_path);
		$aInfo = pathinfo($this->_path);
		$k = $aInfo['extension']; 
		if ($k == 'php' || $k == 'html' || $k == 'sh') {
			$report['errors']['chatfile'] = l('file_is_executing_upload_denied');
			return false;
		}
		/*var_dump($photo);
		var_dump($this->_path);
		var_dump($this->_url);
		die(__FILE__ . __LINE__);/**/
		$this->_isImg = $isImg;
		return true;
	}
}
