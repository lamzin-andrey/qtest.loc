ALTER TABLE  `u_tests` ADD COLUMN folder VARCHAR(7) COMMENT 'Каталог файлов от files';
ALTER TABLE  `u_tests` ADD COLUMN reading_uri VARCHAR(255) COMMENT 'Часть url которая транслитируется из display_name';
