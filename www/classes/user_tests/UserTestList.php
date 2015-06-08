<?php
require_once APP_ROOT . '/classes/sys/CAbstractDbTree.php';
class UserTestList extends CAbstractDbTree{
	public function __construct($app) {
		$this->table('u_tests');
		//устанавливаю "неожиданные" ассоциации полей запроса и полей таблицы БД
		//ключ значения массива - имя поля в таблице,  значение - ключ в request
		/*$this->assoc(
			array(
				'parent_id' => 'parent',
				'part' => 'skey'
			)
		);*/
		//устанавливаю имена полей таблицы БД которые надо вставить
		//db fields
		$this->insert(
			array('question', 'answer', 'u_tests_id', 'date_create')
		);
		//устанавливаю имена полей таблицы БД которые надо обновить
		//db fields
		$this->update(
			array('question', 'answer', 'u_tests_id', 'date_create')
		);
		//устанавливаю имена полей в которые надо записать текущее время
		$this->timestamps(
			array('date_create')
		);
		//Устанавливаю необходимые для заполнения поля
		$this->required('question', $app->lang['Error_question_required']);
		$this->required('answer', $app->lang['Error_answer_required']);
		//Проверяю, владелиц ли пользователь редактируемого комментария
		//$auth_user_uid = sess('uid');
		//$field_owner_id = 'uid';
		//$this->setUpdateOwnerCondition($auth_user_uid, $field_owner_id);
		$this->is_deleted_table_alias = $this->_table . '.';
		parent::__construct($app);
	}
	protected function validate() {
		$lang = utils_getCurrentLang();
		/*if (!$this->_app->user_email) {
			json_error('msg', $lang['Error_Member_only']);
		}
		if (isset($this->_app->comm_captcha)) {
			$enter = req('commfstr');
			if ($enter != sess('capcode')) {
				json_error('msg', $lang['code_is_not_valid']);
			}
		}*/
		parent::validate();
	}
	
	protected function req($name) {
		/*if ($name == 'is_accept') {
			return '0';
		}*/
		$v = parent::req($name);
		/*if ($name == 'skey') {
			if (!$v) {
				json_error('msg', $this->_app->lang['default_error']);
			}
			$v = 'quick_start/' . $v;
		}*/
		/*$s = str_replace('[/code]', '</pre>', $v);
		$s = str_replace("[code]\n", '<pre>', $s);
		$v = str_replace('[code]', '<pre>', $s);*/
		return $v;
	}
        public function getPerPage() {
            return $this->_per_page;
        }
}
