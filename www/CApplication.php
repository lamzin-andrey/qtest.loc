<?php
require_once dirname(__FILE__) . '/classes/sys/CBaseApplication.php';
class CApplication extends CBaseApplication {
	
	public function __construct() {
		@session_start();
		$lang = utils_getCurrentLang();
		$this->title($lang['Welcome'], $lang["More_tests_good_and_different"]);
		parent::__construct();
		
	}
	
	protected function _route($url) {
		$work_folder = WORK_FOLDER;
                if ( strpos($url, $work_folder . '/tests') !== false ) {
                    $this->layout = 'tpl/usertest.master.tpl.php';
                    $this->handler = $h = $this->_load('UserTestHandler');
                    return;
                }
                if ( strpos($url, $work_folder . '/create_test') !== false ) {
                    $this->layout = 'tpl/simple_page.master.tpl.php';
                    $this->handler = $h = $this->_load('CreateTestPageHandler');
                    return;
                }
		switch ($url) {
			case $work_folder . '/':
				$this->layout = 'tpl/simple_page.master.tpl.php';
				$this->handler = $h = $this->_load('SimplePageHandler');
				return;
			case $work_folder . '/create_test':
				$this->layout = 'tpl/simple_page.master.tpl.php';
				$this->handler = $h = $this->_load('CreateTestPageHandler');
				return;
		}
		parent::_route($url);
	}
}
