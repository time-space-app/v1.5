CREATE TABLE T_ATTACH_FILE (
  SEQ          INT(10)            NOT NULL,
  FILE_NM      VARCHAR(200)         DEFAULT NULL,
  FILE_SIZE    VARCHAR(20)          DEFAULT NULL,
  DOWN_CNT     INT(10)                UNSIGNED DEFAULT NULL,
  BOARD_SEQ    INT(10)            NOT NULL,
  BOARD_ID     VARCHAR(20)      NOT NULL,
  CREATE_DT    DATE                  DEFAULT NULL,
  CREATE_ID    VARCHAR(30)          DEFAULT NULL,
  UPDATE_DT    DATE                  DEFAULT NULL,
  UPDATE_ID    VARCHAR(30)          DEFAULT NULL,
  PRIMARY KEY(SEQ)
) ENGINE=MYISAM DEFAULT CHARSET=UTF8;