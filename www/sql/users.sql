-- MySQL
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users`
(
   id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL COMMENT '��������� ����.',
   pwd VARCHAR(32) COMMENT '������',
   email    VARCHAR(64) COMMENT 'email',
   guest_id VARCHAR(32) COMMENT 'md5( ip datetime) ���������� ������������ ������������ ����',
   last_access_time DATETIME COMMENT '����� ���������� ��������� � �����',
   is_deleted INTEGER DEFAULT 0 COMMENT '������ ��� ���. ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������',
   date_create DATETIME COMMENT '����� ��������',
   delta INTEGER COMMENT '�������.  ����� ���������� �� �������, �� ����� � cdbfrselectmodel ���� �������, ��� ������'
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;
