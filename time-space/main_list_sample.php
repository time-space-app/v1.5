<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ja">
<title>:::Nagoya International School Of Japanese Language:::</title>
</head>
<body>
<div id="notice">
	<div id="mainnoticetop">
		<a href="board/list.php?BOARD_ID=notice">[Board More]</a>
	</div>
	<div id="mainnoticelist">
		<?php
       		 //셀렉트 
			$SQL = "SELECT";
			$SQL .= " SEQ,BOARD_ID,USER_ID,USER_NM,EMAIL,TITLE,CONTENT";
			$SQL .= " ,DATE_FORMAT(REGDATE, '%Y-%m-%d') AS CREATE_DT";
			$SQL .= " ,READCOUNT,FILECNT,STATE,POPUP,POPUP_W,POPUP_H,TOP_NEWS";
			$SQL .= " FROM T_BOARD";
			$SQL .= " WHERE BOARD_ID = 'notice'";
			$SQL .= " ORDER BY CREATE_DT DESC LIMIT 0 , 10";
			$result = $GPLdb5->GPLexcute_query($SQL);
	        if($result){
	        	while($row = mysqli_fetch_array($result)) {
      		?>
          <ul>
            <li>
            	<a href="board/view.php?BOARD_ID=notice&SEQ=<?php echo $row['SEQ']?>">
				<?php echo cut_str($row[TITLE],58,'...')?><span><?php echo $row[CREATE_DT]?></span>
				</a>
            </li>
          </ul>
		<?php
			          	}
			      }
          		?>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
    // <!-- 팝업쿠기
    function getCookie(name) {
        var nameOfCookie = name + "=";
        var x = 0;
        while (x <= document.cookie.length) {
            var y = (x + nameOfCookie.length);
            if (document.cookie.substring(x, y) == nameOfCookie) {
                if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
                    endOfCookie = document.cookie.length;
                return unescape(document.cookie.substring(y, endOfCookie));
            }
            x = document.cookie.indexOf(" ", x) + 1;
            if (x == 0)
                break;
        }
        return "";
    }
    // -->
</script>
<?php
//팝업창 띄우기
$SQL = "SELECT";
$SQL .= " SEQ, TITLE, CONTENT, FILECNT,POPUP, POPUP_W, POPUP_H";
$SQL .= " FROM T_BOARD";
$SQL .= " WHERE BOARD_ID='notice'";
$SQL .= " AND POPUP='on'";
$SQL .= " ORDER BY REGDATE";
$result = $GPLdb5->GPLexcute_query($SQL);
if($result){
	while($_popup = mysqli_fetch_array($result)) {
	$url = "popup.php?SEQ=".$_popup['SEQ'];
	$PopNm = "popup".$_popup['SEQ'];
	$PopWidth = $_popup['POPUP_W'];
	$PopHeight = $_popup['POPUP_H'];
	$PopupScript = "<script language=javascript>if (getCookie('POP".$_popup['SEQ']."') != 'done'){window.open('".$url."','".$PopNm."','toolbar=no,menubar=no,scrollbars=yes,resizable=no,width=".$PopWidth.",height=".$PopHeight.",left=".$LeftVal.",top=100')}</script>";
	echo $PopupScript;
	$LeftVal += 130;
	}
}
?>