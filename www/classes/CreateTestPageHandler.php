<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
require_once APP_ROOT . '/classes/quicktestlib.php';
require_once APP_ROOT . '/classes/create_test/QuestionList.php';
class CreateTestPageHandler extends CBaseHandler{
        private $_question_list;
        private $_test_id;
        public $questions;
        public $test; //compatible
        public $paging;
        public $per_page;
	public function __construct($app) {
		$app->title($app->lang['Create_test_form_title']);
		if (!CApplication::userIsAuth()) {
			utils_302('/');
		}
                parent::__construct();
                $this->_test_id = $id = intval(a($this->_a_url, 2));
                if ($id) {
                    $v = dbvalue("SELECT uid FROM u_tests WHERE id = {$id}");
                    if ($v != sess('uid')) {
                        utils_302('/');
                    }
                }
		$this->css[] = 'simple';
		$this->css[] = 'create_test';
		$this->js[] = 'simple';
		$this->right_inner = 'create_test.tpl.php';
                
                $is_question_page = false;
                if (a($this->_a_url, 3) == 'questions' && $id ) {
                    $is_question_page = true;
                    $this->_question_list = new QuestionList($app);
                    $this->_question_list->setUpdateOwnerCondition($id, 'u_tests_id');
                    $uid = sess('uid');
                    $page = ireq('page') ? ireq('page') : 1;
                    $this->questions = $this->_question_list->getList("u_tests_content.u_tests_id = {$id}", 'question, answer', '', $page, '', '', false);
                    
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
            if ($is_question_page) {
                if ( req('action') == 'save_question' ) {
                    $this->_saveQuestion();
                }
                if ( req('action') == 'delete_question' ) {
                    $this->_deleteQuestion();
                }
                if ( req('action') == 'up_question' ) {
                    $this->_upQuestion();
                }
                if ( req('action') == 'down_question' ) {
                    $this->_downQuestion();
                }
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
            createTestFiles($test_id, $data);
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
            $var = json_encode($options);
            $json_opt = db_escape($var);
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
            //TODO Все таки очень тщательно попробовать отредактировать чужой вопрос!!
            $test_id = intval(a($this->_a_url, 2));
            $insert_id = $this->_question_list->writeData(array('u_tests_id' => $test_id));
            $id = $insert_id ? $insert_id : ireq('id');
            json_ok('ord', ireq('ord'), 'id', $id);
            
        }
        /**
         * @desc Удалить вопрос
        */
        private function _deleteQuestion() {
            if ($id = ireq('id')) {
                query("UPDATE u_tests_content SET is_deleted = 1 WHERE id = {$id}");
                json_ok('id', $id);
            } else {
                json_ok('id', 0);
            }
        }
        /**
         * @desc Переместить вопрос выше
        */
        private function _upQuestion() {
            if ($id = ireq('id')) {
                $test_id = $this->_test_id;
                $row2 = dbrow("SELECT id, delta FROM u_tests_content WHERE delta = 
                                (
                                        SELECT MAX(delta) FROM 
                                                (	
                                                        SELECT id, delta FROM u_tests_content WHERE u_tests_id = {$test_id} 
                                                                AND 
                                                                delta < (SELECT delta FROM u_tests_content WHERE id = {$id}) 
                                                ) AS t2

                                ) AND u_tests_id = {$test_id}"
                );
                if ($row2) {
                    $id2 = $row2['id'];
                    $delta2 = $row2['delta'];
                    $delta1 = dbvalue("SELECT delta FROM u_tests_content WHERE id = {$id}");
                    query("UPDATE u_tests_content SET delta = {$delta1} WHERE id = {$id2}");
                    query("UPDATE u_tests_content SET delta = {$delta2} WHERE id = {$id}");
                    
                    //debug code 
                    $rows = query("SELECT id, delta FROM u_tests_content WHERE u_tests_id = {$test_id}");
                    $map = array();
                    foreach ($rows as $row) {
                        if (isset($map[ $row['delta'] ])) {
                            json_ok('id', $id, 'id2', $id2, 'derror', 1);
                        }
                        $map[ $row['delta'] ] = 1;
                    }
                    json_ok('id', $id, 'id2', $id2);
                }
            }
            json_ok('id', 0);
        }
        /**
         * @desc Переместить вопрос выше
        */
        private function _downQuestion() {
            if ($id = ireq('id')) {
                $test_id = $this->_test_id;
                $row2 = dbrow("SELECT id, delta FROM u_tests_content WHERE delta = 
                                (
                                        SELECT MIN(delta) FROM 
                                                (	
                                                        SELECT id, delta FROM u_tests_content WHERE u_tests_id = {$test_id} 
                                                                AND 
                                                                delta > (SELECT delta FROM u_tests_content WHERE id = {$id}) 
                                                ) AS t2

                                )  AND u_tests_id = {$test_id}"
                );
                if ($row2) {
                    $id2 = $row2['id'];
                    $delta2 = $row2['delta'];
                    $delta1 = dbvalue("SELECT delta FROM u_tests_content WHERE id = {$id}");
                    query("UPDATE u_tests_content SET delta = {$delta1} WHERE id = {$id2}");
                    query("UPDATE u_tests_content SET delta = {$delta2} WHERE id = {$id}");
                    json_ok('id', $id, 'id2', $id2);
                }
            }
            json_ok('id', 0);
        }
}
