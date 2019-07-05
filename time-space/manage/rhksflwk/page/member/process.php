<?php
/////////////////////////////파일 업로드/////////////////////////////

	$filename = $_FILES['filename']['name'];//파일명
	$filesize = $_FILES['filename']['size'];//파일크기
	$file_extension = strtolower(array_pop(explode('.', $filename))) ;//확장자추출
	$path = "./temp";
	umask(0); 
	@mkdir($path, 0777); //업로드 임시디렉토리 생성
	
	$uploaddir = "./temp/". $filename;//실제업로드 위치
	move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddir);//실제 업로드
?>
출력내용이 정확합니까???
<a href="process2.php?filename=<?php echo $filename?>&mode=insert">디비에 입력하기</a> /   <a href="process2.php?filename=<?php echo $filename?>&mode=del">취소하고 파일을 다시업로드 합니다.</a>
<?php
/////////////////////////////파일 내용 출력/////////////////////////////

	$row = 1;//줄수 초기화
	$fp = fopen ("$uploaddir","r");//파일오픈
	while ($data = fgetcsv ($fp, 1000, ",")) {//csv파일열기
	$num = count ($data);//총 줄수카운드
	
	    print "<p><strong></strong> $row 라인에 $num 개의 필드: <br>";
	$row++;
		echo "<table border=1";
		echo "<tr>";		
		for($i=0;$i<$num+1;$i++){
		echo "<td>";
		echo $data[$i];
		echo "</td>";
		}
		echo "</tr>";		
		echo "</table>";
	}
	fclose ($fp); 
?>