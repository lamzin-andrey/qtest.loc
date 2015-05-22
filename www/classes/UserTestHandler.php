<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
class UserTestHandler extends CBaseHandler{
    public $metadata;

    public function __construct($app) {
        parent::__construct();
        if ($this->_testExists($this->_a_url)) {
            $webfile_a = $this->metadata['webfile_a'];
            $data = $this->metadata;
            //set param as innner
            $this->css[] = $webfile_a . 'css?v='  . STATIC_VERSION;
            $this->js[] = $webfile_a . 'js?v=' . STATIC_VERSION;
            if ($this->metadata['t_type'] == 1) {
                $this->js[] = WEB_ROOT . '/js/tttest.js?v=' . STATIC_VERSION;
            }
            $this->right_inner = APP_ROOT . $webfile_a . 'tpl.php';
        } else {
            //set screen test not found
            $this->css[] = WEB_ROOT . '/css/testnotfound.css?v=' . STATIC_VERSION;
            $this->right_inner = APP_ROOT . '/tpl/testnotfound.tpl.php';
        }
    }
    /**
     * @description Проверяет опубликован ли тест и существуют ли его файлы.
     * @param array $a_url массив с частями запрошенного url
     * @return bool true если тест доступен и файлы сущнествуют
    */
    private function _testExists($a_url) {
        // qtest.loc/tests/test_po_symfony_2
        $testuri = a($a_url, 2);
        $row = dbrow("SELECT id, t_type, folder, uid, display_name, short_desc, description, info, folder FROM u_tests WHERE reading_uri = '{$testuri}' AND is_deleted = 0 AND is_accepted = 1 AND is_published = 1" );
        if (a($row, 'folder')) {
            $filename_a = APP_ROOT . '/files/' . $row['folder'] . '/' . $row['uid'] . '.' . $row['id'] . '.';
            $webfile_a = '/files/' . $row['folder'] . '/' . $row['uid'] . '.' . $row['id'] . '.';
            if (file_exists("{$filename_a}js") && file_exists("{$filename_a}css") && file_exists("{$filename_a}tpl.php") ) {
                $this->metadata = $row;
                $this->metadata['filename_a'] = $filename_a;
                $this->metadata['webfile_a'] = $webfile_a;
                $user_info = dbrow("SELECT name, surname FROM users WHERE id = {$row['uid']}");
                $this->metadata['user_name'] = a($user_info, 'name');
                $this->metadata['user_last_name'] = a($user_info, 'surname');
                return true;
            }
        }
        return false;
    }
}