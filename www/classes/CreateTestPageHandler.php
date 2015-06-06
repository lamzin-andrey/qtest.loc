<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
require_once APP_ROOT . '/classes/create_test/QuestionList.php';
class CreateTestPageHandler extends CBaseHandler{
        private $_question_list;
        public $questions;
        public $paging;
        public $per_page;
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
                $is_question_page = false;
                if (a($this->_a_url, 3) == 'questions' && $id = intval(a($this->_a_url, 2))) {
                    $is_question_page = true;
                    $this->_question_list = new QuestionList($app);
                    $this->_question_list->setUpdateOwnerCondition(null, null);
                    $uid = sess('uid');
                    $this->questions = $this->_question_list->getList("u_tests_content.u_tests_id = {$id}", 'question, answer', '', 1, '', '', false);
                    
                    $this->per_page = $this->_question_list->getPerPage();
                    $this->paging = $this->_question_list->paging;
                }
                $this->_processRequest($is_question_page);
		$this->_setInner();
	}
        /**
         * @desc Обработка форм
        */
	private function _processRequest($is_question_page) {
            if ($is_question_page && req('action') == 'save_question') {
                $this->_saveQuestion();
            }
            if (req('action') == 'create') {
                $test_id = $this->_saveTestData($data);
                $this->_createTestFiles($test_id, $data);
                utils_302('/create_test/' . $test_id . '/questions');
            }
        }
        /**
         * @desc Создать файлы теста
        */
        private function _createTestFiles($test_id, $data) {
            if ($data['t_type'] == 1) {
                $js = file_get_contents(APP_ROOT . '/files/tpl/js/text/3.2.js');
                $css = file_get_contents(APP_ROOT . '/files/tpl/js/text/3.2.css');
                $php = file_get_contents(APP_ROOT . '/files/tpl/js/text/3.2.tpl.php');
                $js = str_replace('{{TESTID}}', $test_id, $js);
                if (ireq('is_skip') > 0) {
                    $js = str_replace('{{SKIP_BORDER}}', file_get_contents(APP_ROOT . '/files/tpl/js/text/skip.tpl.part.js'), $js);
                    $php = str_replace('{{INPUT_SKIP}}', file_get_contents(APP_ROOT . '/files/tpl/js/text/skip.tpl.part.php'), $php);
                } else {
                    $js = str_replace('{{SKIP_BORDER}}', '', $js);
                }
                foreach ($data as $key => $item) {
                    $js = str_replace('{{'. $key .'}}', $item, $js);
                }
                file_put_contents(APP_ROOT . '/files/' . $data['folder'] . '/' . $data['uid'] . '.' . $test_id . '.js', $js);
                file_put_contents(APP_ROOT . '/files/' . $data['folder'] . '/' . $data['uid'] . '.' . $test_id . '.css', $css);
                file_put_contents(APP_ROOT . '/files/' . $data['folder'] . '/' . $data['uid'] . '.' . $test_id . '.tpl.php', $php);
            } else {
                die('До вариантов еще как до Китая');
            }
        }
        /**
         * @desc Сохранить метаданные теста в базе
        */
        private function _saveTestData(&$data) {
            $data = db_mapPost('u_tests');
            $data['test_description'] = db_safeString($data['test_description']);
            $data['reading_uri'] = $data['t_name'] = utils_translite_url($data['display_name']);
            $data['folder'] = date('Y/m');
            $sql_query = db_createInsertQueryExt($data, 'u_tests', array(
                'test_description' => 'description'
            ), $options);
            unset($options['action']);
            unset($options['next_step_1']);
            $json_opt = json_encode($options);
            $sql_query = str_replace('{EXT_FIELDS}', ', options', $sql_query);
            $sql_query = str_replace('{EXT_VALUES}', ", '{$json_opt}'", $sql_query);
            /*echo $sql_query . '<pre>';
            print_r($data);
            print_r($options);
            echo '</pre>';
            die( 'FILE = ' . __FILE__ . ', LINE = ' . __LINE__);/**/
            return query($sql_query);//TODO uncomment me!
        }
        /**
         * @desc Определение шаблона
        */
	private function _setInner() {
            $step = a($this->_a_url, 2);
            $default_step = 'select_test_type';
            $step = $step ? $step : $default_step;
            
            if (a($this->_a_url, 3) == 'questions' && $id = intval($step)) {
                $uid = CApplication::getUid();
                $sql_query = "SELECT id FROM u_tests WHERE id = {$id} AND uid = {$uid}";
                //die( $sql_query  );
                $_id = dbvalue($sql_query);
                if ($_id == $id) {
                    $step = 'questions_form';
                } else {
                    $step = 'alien_test';
                }
            }
            
            if (file_exists(APP_ROOT . '/tpl/create_test/' . $step . '.tpl.php')) {
                    $this->right_inner = 'create_test/' . $step . '.tpl.php';
            } else {
                    $this->right_inner = 'create_test/' . $default_step . '.tpl.php';
            }
	}
        /**
         * @desc Сохранить вопрос
        */
        private function _saveQuestion() {
            //check permission
            $test_id = intval(a($this->_a_url, 2));
            $v = dbvalue("SELECT uid FROM u_tests WHERE id = {$test_id}");
            if ($v == sess('uid')) {
                $insert_id = $this->_question_list->writeData(array('u_tests_id' => $test_id));
                $id = $insert_id ? $insert_id : ireq('id');
                json_ok('ord', ireq('ord'), 'id', $id);
            }
            json_error($lang['Question_Permission_denied']);
        }
}