==========================================================================================================
1. CMS �޴� ���̺� ����
---------------------------------- db �߰����� -------------------------------------
- T_L_MENU(��޴�)
 CREATE TABLE T_L_MENU (
 SEQ               INT(5)         NOT NULL,
 SUN               INT(5)         NOT NULL,
 L_CODE            VARCHAR(10)    NOT NULL,
 L_NAME            VARCHAR(200)   DEFAULT NULL,
 L_URL             VARCHAR(255)   DEFAULT NULL,
 USE_YN            VARCHAR(2)     DEFAULT NULL,
 PRIMARY KEY(SEQ,SUN,L_CODE)
) ENGINE=MYISAM DEFAULT CHARSET=UTF8;

- T_M_MENU(�߸޴�)
CREATE TABLE T_M_MENU (
 SEQ               INT(5)         NOT NULL,
 SUN               INT(5)         NOT NULL,
 L_CODE            VARCHAR(10)    NOT NULL,
 M_CODE            VARCHAR(10)    NOT NULL,
 M_NAME            VARCHAR(200)   DEFAULT NULL,
 M_URL             VARCHAR(255)   DEFAULT NULL,
 USE_YN            VARCHAR(2)     DEFAULT NULL,
 PRIMARY KEY(SEQ,SUN,L_CODE,M_CODE)
) ENGINE=MYISAM DEFAULT CHARSET=UTF8;

- T_S_MENU(�Ҹ޴�)
CREATE TABLE T_S_MENU (
 SEQ               INT(5)         NOT NULL,
 SUN               INT(5)         NOT NULL,
 L_CODE            VARCHAR(10)    NOT NULL,
 M_CODE            VARCHAR(10)    NOT NULL,
 S_CODE            VARCHAR(10)    NOT NULL,
 S_NAME            VARCHAR(200)   DEFAULT NULL,
 S_URL             VARCHAR(255)   DEFAULT NULL,
 USE_YN            VARCHAR(2)     DEFAULT NULL,
  PRIMARY KEY(SEQ,SUN,L_CODE,M_CODE,S_CODE)
) ENGINE=MYISAM DEFAULT CHARSET=UTF8;
 ---------------------------------- db �߰����� -------------------------------------
2 CMS ������ ���̺� ����
------------------------------------------------------------------------------------------
 CREATE TABLE T_CMS (
	L_CODE       VARCHAR(10)    	NOT NULL,
	M_CODE       VARCHAR(10)    	NOT NULL,
	S_CODE       VARCHAR(10)    	NOT NULL,
    USER_ID      VARCHAR(20)        DEFAULT NULL,
    USER_NM      VARCHAR(20)        DEFAULT NULL,
    EMAIL        VARCHAR(200)       DEFAULT NULL,
    TITLE        VARCHAR(200)       DEFAULT NULL,
    CONTENT      TEXT               DEFAULT NULL,
    REGDATE      DATETIME           DEFAULT NULL,
    READCOUNT    INT(10)            UNSIGNED DEFAULT NULL,
	PRIMARY KEY(L_CODE,M_CODE,S_CODE)
) ENGINE=MYISAM DEFAULT CHARSET=UTF8;
