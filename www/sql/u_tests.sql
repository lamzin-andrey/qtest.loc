-- MySQL
DROP TABLE IF EXISTS `u_tests`;

CREATE TABLE IF NOT EXISTS `u_tests`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   uid INTEGER COMMENT '����� ������������, ������������ ����',
   t_type INTEGER COMMENT '��� ����� - 0 - �������� ������, 1 - ����� �� ������ ���������',
   display_name    VARCHAR(128) COMMENT '��� ����� ��� �����������',
   short_desc    TEXT COMMENT '������� �������� �����',
   description    TEXT COMMENT '������ �������� �����',
   info    TEXT COMMENT '�������� ���������� � �����, ������������ �� ������ ��������, �������� ���������� � ���, ��� ��� ������� � ������� ������ ���� ��������',
   t_name VARCHAR(32) COMMENT '����������� ��� �����',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���.',
   is_accepted INTEGER DEFAULT 0 COMMENT '����������� ��� ���.',
   is_published INTEGER DEFAULT 0 COMMENT '����������� ��� ���.',
   date_create DATETIME COMMENT '����� ��������',
   delta INTEGER COMMENT '�������. ',
   folder VARCHAR(7) COMMENT '������� ������ �� files',
   reading_uri VARCHAR(255) COMMENT '����� url ������� ��������������� �� display_name',
   UNIQUE KEY `idx_d_name` (`display_name`),
   UNIQUE KEY `idx_ruri` (`reading_uri`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
