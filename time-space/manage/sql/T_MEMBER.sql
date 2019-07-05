CREATE TABLE T_MEMBER (
  LOGIN_ID VARCHAR(20) NOT NULL,
  LOGIN_PWD VARCHAR(256) DEFAULT NULL,
  USER_NM VARCHAR(50) DEFAULT NULL,
  USER_LEVEL INT(10) UNSIGNED DEFAULT NULL,
  USE_YN VARCHAR(1) DEFAULT NULL,
  USER_EMAIL VARCHAR(100) DEFAULT NULL,
  EMAIL_YN VARCHAR(4) DEFAULT NULL,
  AGREE_YN VARCHAR(4) DEFAULT NULL,
  CREATE_DT DATETIME DEFAULT NULL,
  UPDATE_DT DATETIME DEFAULT NULL,
  PRIMARY KEY  (LOGIN_ID)
) ENGINE=MYISAM DEFAULT CHARSET=UTF8;

--
-- 테이블의 덤프 초기데이터 `T_MEMBER`
--

INSERT INTO T_MEMBER (LOGIN_ID, LOGIN_PWD, USER_NM, USER_LEVEL, USE_YN, EMAIL_YN, AGREE_YN, CREATE_DT, UPDATE_DT) VALUES
('admin', '7b902e6ff1db9f560443f2048974fd7d386975b0', '관리자', 1, 'Y', 'on', 'on', '2013-05-25 15:59:29', '2013-06-01 23:40:58')