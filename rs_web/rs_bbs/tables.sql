/** 인코딩 변경 */
SET NAMES utf8;

/** 데이터베이스의 생성 */
CREATE DATABASE `JQMDB` DEFAULT CHARACTER SET utf8;

/** 데이터베이스의 사용 */
use JQMDB;

/** 게시판 테이블의 생성 */
CREATE TABLE FREE_BOARD (
	NUM int(11) primary key auto_increment,
	BBS_ID int(11) not null default 1,
	SUBJECT varchar(256) not null,
	WRITER varchar(256) not null,
	PASSWORD varchar(256) not null,
	MEMO text not null,
	REG_DATE datetime not null
) DEFAULT CHARACTER SET utf8;