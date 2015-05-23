<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
class SimplePageHandler extends CBaseHandler{
	public function __construct() {
            utils_302(WEB_ROOT . '/tests/test_po_symfony_2');
            $this->css[] = 'simple';
            $this->js[] = 'simple';
            $this->right_inner = 'simple.tpl.php';
            parent::__construct();
	}
}
