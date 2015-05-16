-- MySQL
DROP TABLE IF EXISTS `u_tests_content`;

CREATE TABLE IF NOT EXISTS `u_tests_content`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   u_tests_id INTEGER COMMENT '����� �����',
   question   TEXT COMMENT '����� �������',
   answer   TEXT COMMENT '����� �� ������, � json ������� ���� u_tests.t_type == 0',
   r_answer  INTEGER COMMENT '����� ����������� �������� ������ �� ������ ���� u_tests.t_type == 0',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���.',
   date_create DATETIME COMMENT '����� ��������',
   delta INTEGER COMMENT '�������. '
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
