<?php
require_once APP_ROOT . '/classes/quicktestlib.php';
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
require_once APP_ROOT . '/classes/user_tests/UserTestList.php';
class UserTestPageHandler extends CBaseHandler{
        private $_test_list;
        private $_is_test_metadata_page = false;
        private $_is_test_questions_page = false;
        private $_alien_test = false;
        private $_test_id;
        
        public $tests;
        public $paging;
        public $test;
	public function __construct($app) {
		$app->title($app->lang['User_test_form_title']);
		if (!CApplication::userIsAuth()) {
			utils_302('/');
		}
		$this->css[] = 'simple';
		$this->css[] = 'user_tests';
		$this->css[] = 'create_test';
		$this->js[] = 'simple';
		$this->right_inner = 'user_tests.tpl.php';
                
		parent::__construct();
                $id = intval(a($this->_a_url, 2));
                if ( $id && $this->_isAllowTest($id) ) {
                    if (a($this->_a_url, 3) == 'questions') {
                        $this->_is_test_questions_page = true;
                        
                    } else {
                        $this->_is_test_metadata_page= true;
                        $this->_test_id = $id;
                        $this->_test_list = new UserTestList($app);
                        $this->_test_list->setUpdateOwnerCondition($uid = sess('uid'), 'uid');
                        $fields = '*';
                        $list = $this->_test_list->getList("u_tests.id = {$id}", $fields, '', 1);
                        if (is_array($list)) {
                            $this->test = current($list);
                            if (a($this->test, 'options')) {
                                $this->test['options'] = json_decode($this->test['options'], true);
                                /*echo '<pre>';
                                print_r($this->test['options']);
                                echo '</pre>';
                                die('FILE ' . __FILE__ . ', LINE ' . __LINE__);/**/
                                $this->test['is_random'] = ( a($this->test['options'], 'is_random') ? a($this->test['options'], 'is_random') : 0);
                                $this->test['is_skip'] = ( a($this->test['options'], 'is_skip') ? a($this->test['options'], 'is_skip') : 0);
                                $this->test['show_answer'] = ( a($this->test['options'], 'show_answer') ? a($this->test['options'], 'show_answer') : 0);
                            }
                        }
                    }
                } else {
                    $this->_alien_test = true;
                }
                
                if (!$this->_is_test_questions_page) {
                    $this->_test_list = new UserTestList($app);
                    $this->_test_list->setUpdateOwnerCondition($uid = sess('uid'), 'uid');
                    $fields = 't_type, display_name, short_desc, u_tests.is_accepted, u_tests.is_published, reading_uri';
                    $this->tests = $this->_test_list->getList("u_tests.uid = {$uid}", $fields, '', 1);
                }
                $this->_processRequest();
		$this->_setInner();
	}
        /**
         * @desc Обработка форм
        */
	private function _processRequest() {
            /*if ($is_question_page && req('action') == 'save_question') {
                $this->_saveQuestion();
            }*/
            if (req('action') == 'update') {
                $this->_saveTestData($data);
                $this->_createTestFiles($this->_test_id, $data);
                if ( a($data, 'save_metadata_and_get_questions') ) {
                    utils_302('/my/' . $this->_test_id . '/questions');
                }
                utils_302('/my/' . $this->_test_id );
            }
        }
        /**
         * @desc Создать файлы теста
         * @param int $test_id
         * @param assoc_array $data
         * @param string $developer Если тест редактируется, можно создавать dev версию
        */
        private function _createTestFiles($test_id, $data, $developer = '') {
            $prefix = '';
            if (a($this->test, 'is_accepted') && a($this->test, 'is_published') ) {
                $prefix = 'dev';
            }
            createTestFiles($test_id, $data, $prefix);
        }
        /**
         * @desc Сохранить метаданные теста в базе
        */
        private function _saveTestData(&$data) {
            $data = db_mapPost('u_tests');
            $data['test_description'] = db_safeString($data['test_description']);
            //$data['reading_uri'] = $data['t_name'] = utils_translite_url($data['display_name']);
            //$data['folder'] = date('Y/m');
            $sql_query = db_createUpdateQueryExt($data, 'u_tests', "id = {$this->_test_id}", array(
                'test_description' => 'description'
            ), $options);
            unset($options['action']);
            unset($options['save_metadata']);
            unset($options['save_metadata_and_get_questions']);
            $json_opt = json_encode($options);
            $sql_query = str_replace('{EXT_PAIRS}', ', options = \'' . db_escape($json_opt) . '\'', $sql_query);
            /*echo $sql_query . '<pre>';
            print_r($data);
            print_r($options);
            echo '</pre>';
            die( 'FILE = ' . __FILE__ . ', LINE = ' . __LINE__);/**/
            $data['folder'] = $this->test['folder'];
            $data['uid'] = sess('uid');
            return query($sql_query);//TODO uncomment me!
        }
        /**
         * @desc Определение шаблона
        */
	private function _setInner() {
            $step = a($this->_a_url, 2);
            $folder = $default_step = 'user_tests';
            $step = $step ? $step : $default_step;
            
            if ($this->_is_test_metadata_page) {
                $folder = 'create_test';
                $step = 'select_test_type';
            }
            
            
            if (file_exists(APP_ROOT . '/tpl/'. $folder .'/' . $step . '.tpl.php')) {
                    $this->right_inner = $folder . '/' . $step . '.tpl.php';
            } else {
                    $this->right_inner = $folder . '/' . $default_step . '.tpl.php';
            }
	}
        /**
         * @desc Сохранить вопрос
        */
        private function _saveQuestion() {
            //check permission TODO ОЧЕНЬ ПОХОЖЕ НА ДЫРУ!
            $test_id = intval(a($this->_a_url, 2));
            $v = dbvalue("SELECT uid FROM u_tests WHERE id = {$test_id}");
            if ($v == sess('uid')) {
                $insert_id = $this->_question_list->writeData(array('u_tests_id' => $test_id));
                $id = $insert_id ? $insert_id : ireq('id');
                json_ok('ord', ireq('ord'), 'id', $id);
            }
            json_error($lang['Question_Permission_denied']);
        }
        
        private function _isAllowTest($test_id) {
            $v = dbvalue("SELECT uid FROM u_tests WHERE id = {$test_id}");
            if ($v == sess('uid')) {
                return true;
            }
            return false;
        }
}