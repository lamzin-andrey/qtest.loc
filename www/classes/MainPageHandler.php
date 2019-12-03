<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
class MainPageHandler extends CBaseHandler{
	
	protected $table= 'u_tests';
	
	public $aRows = [];
	
	public function __construct($app) {
		
		$this->left_inner = 'main_tasklist.tpl.php';
		if (!CApplication::userIsAuth()) {
			$this->right_inner = 'test_list.tpl.php';
		} else {
			utils_302(WEB_ROOT . '/sts');
		}
		$this->css[] = 'promo';
		parent::__construct();
		
		$this->aRows = query("SELECT `display_name`, `description`, `bgimage`, `reading_uri`, `info` FROM {$this->table} 
			WHERE is_published = 1 AND is_accepted = 1 AND is_deleted = 0
			ORDER BY id DESC");
	}
}
