-- MySQL
DROP TABLE IF EXISTS `u_tests_content`;

CREATE TABLE IF NOT EXISTS `u_tests_content`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   u_tests_id INTEGER COMMENT 'Номер теста',
   question   TEXT COMMENT 'Текст вопроса',
   answer   TEXT COMMENT 'Ответ на вопрос, в json формате если u_tests.t_type == 0',
   r_answer  INTEGER COMMENT 'Номер правильного варианта ответа на вопрос если u_tests.t_type == 0',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет.',
   date_create DATETIME COMMENT 'время создания',
   delta INTEGER COMMENT 'Позиция. '
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
