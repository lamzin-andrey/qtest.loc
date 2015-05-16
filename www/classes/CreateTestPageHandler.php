<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
class CreateTestPageHandler extends CBaseHandler{
	public function __construct($app) {
		$app->title($app->lang['Create_test_form_title']);
		if (!CApplication::userIsAuth()) {
			utils_302('/');
		}
		$this->css[] = 'simple';
		$this->css[] = 'create_test';
		$this->js[] = 'simple';
		$this->right_inner = 'create_test.tpl.php';
		parent::__construct();
		$this->_setInner();
	}
	
	private function _setInner() {
		$step = a($this->_a_url, 2);
		$default_step = 'select_test_type';
		$step = $step ? $step : $default_step;
		if (file_exists(APP_ROOT . '/tpl/create_test/' . $step . '.tpl.php')) {
			$this->right_inner = 'create_test/' . $step . '.tpl.php';
		} else {
			$this->right_inner = 'create_test/' . $default_step . '.tpl.php';
		}
	}
}