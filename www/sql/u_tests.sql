-- MySQL
DROP TABLE IF EXISTS `u_tests`;

CREATE TABLE IF NOT EXISTS `u_tests`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT 'Первичный ключ.',
   uid INTEGER COMMENT 'Номер пользователя, загрузившего файл',
   t_type INTEGER COMMENT 'Тип теста - 0 - варианты ответа, 1 - ответ на вопрос текстовый',
   display_name    VARCHAR(128) COMMENT 'Имя теста для отображения',
   short_desc    TEXT COMMENT 'Краткое описание теста',
   description    TEXT COMMENT 'Полное описание теста',
   info    TEXT COMMENT 'Полезная информация о тесте, показывается на каждой странице, например информация о том, что все кавычки в ответах должны быть двойными',
   t_name VARCHAR(32) COMMENT 'Техническое имя теста',
   is_deleted INTEGER DEFAULT 0 COMMENT 'Удален или нет.',
   is_accepted INTEGER DEFAULT 0 COMMENT 'Модерирован или нет.',
   is_published INTEGER DEFAULT 0 COMMENT 'Опубликован или нет.',
   date_create DATETIME COMMENT 'время создания',
   delta INTEGER COMMENT 'Позиция. ',
   folder VARCHAR(7) COMMENT 'Каталог файлов от files',
   reading_uri VARCHAR(255) COMMENT 'Часть url которая транслитируется из display_name',
   UNIQUE KEY `idx_d_name` (`display_name`),
   UNIQUE KEY `idx_ruri` (`reading_uri`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
