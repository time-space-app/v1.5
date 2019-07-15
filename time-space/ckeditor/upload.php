<?php
	$up_url = '/time-space/testingdata';
	$up_dir = '../testingdata';
	// 업로드 DIALOG 에서 전송된 값
	$funcNum = $_GET['CKEditorFuncNum'] ;
	$CKEditor = $_GET['CKEditor'] ;
	$langCode = $_GET['langCode'] ;

	if(isset($_FILES['upload']['tmp_name'])) {
		$file_name = $_FILES['upload']['name'];
		$ext = strtolower(substr($file_name, (strrpos($file_name, '.') + 1)));

		if ('jpg' != $ext && 'jpeg' != $ext && 'gif' != $ext && 'png' != $ext) {
			echo 'IMAGE ONLY UPLOAD';
			return false;
		}
		$file_name=date("YmdHms").".".$ext;//POST로 받은 File명 중복방지 코드
		$save_dir = sprintf('%s/%s', $up_dir, $file_name);
		$save_url = sprintf('%s/%s', $up_url, $file_name);
			
		if (move_uploaded_file($_FILES["upload"]["tmp_name"],$save_dir)) {		
			
			//이미지 크기 강제 조정시작
			// $destination : 이미지가 저장될 경로
			// $departure : 원본 이미지 경로
			// $size : _getimagesize() 의 return 값을 넣을 것
			// $quality : JPG 퀄리티
			// $ratio : 비율 강제설정		
			function resize_image($destination, $departure, $size, $quality='80', $ratio='false'){		
				if($size[2] == 1)    //-- GIF
					$src = imageCreateFromGIF($departure);
				elseif($size[2] == 2) //-- JPG
				$src = imageCreateFromJPEG($departure);
				else    //-- $size[2] == 3, PNG
					$src = imageCreateFromPNG($departure);	
				$dst = imagecreatetruecolor($size['w'], $size['h']);
				$dstX = 0;
				$dstY = 0;
				$dstW = $size['w'];
				$dstH = $size['h'];
				if($ratio != 'false' && $size['w']/$size['h'] <= $size[0]/$size[1]){
					$srcX = ceil(($size[0]-$size[1]*($size['w']/$size['h']))/2);
					$srcY = 0;
					$srcW = $size[1]*($size['w']/$size['h']);
					$srcH = $size[1];
				}elseif($ratio != 'false'){
					$srcX = 0;
					$srcY = ceil(($size[1]-$size[0]*($size['h']/$size['w']))/2);
					$srcW = $size[0];
					$srcH = $size[0]*($size['h']/$size['w']);
				}else{
					$srcX = 0;
					$srcY = 0;
					$srcW = $size[0];
					$srcH = $size[1];
				}
				@imagecopyresampled($dst, $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH);
				@imagejpeg($dst, $destination, $quality);
				@imagedestroy($src);
				@imagedestroy($dst);
				return TRUE;
			}
			
			// $img : 원본이미지
			// $m : 목표크기 pixel
			// $ratio : 비율 강제설정
			function _getimagesize($img, $m, $ratio='false'){
				$v = @getImageSize($img);
				if($v === FALSE || $v[2] < 1 || $v[2] > 3)
					return FALSE;
				$m = intval($m);
				if($m > $v[0] && $m > $v[1])
					return array_merge($v, array("w"=>$v[0], "h"=>$v[1]));
				if($ratio != 'false'){
					$xy = explode(':',$ratio);
					return array_merge($v, array("w"=>$m, "h"=>ceil($m*intval(trim($xy[1]))/intval(trim($xy[0])))));
				}elseif($v[0] > $v[1]){
					$t = $v[0]/$m;
					$s = floor($v[1]/$t);
					$m = ($m > 0) ? $m : 1;
					$s = ($s > 0) ? $s : 1;
					return array_merge($v, array("w"=>$m, "h"=>$s));
				} else {
					$t = $v[1]/intval($m);
					$s = floor($v[0]/$t);
					$m = ($m > 0) ? $m : 1;
					$s = ($s > 0) ? $s : 1;
					return array_merge($v, array("w"=>$s, "h"=>$m));
				}
			}
			$max_upload_width = 1020;//제한할 넓이
			$max_upload_height = 820;//제한할 높이
			chmod($save_dir,0707);
			// get width and height of original image
			list($image_width, $image_height) = getimagesize($save_dir);
			if($image_width>$max_upload_width || $image_height >$max_upload_height){
				$src = $save_dir;        //-- 원본 
				$dst = $save_dir;     //-- 저장 
				$quality = '100';    //-- jpg 퀄리티 
				$size = '1020';    //-- 줄일 크기 pixel (너비, 또는 높이에 적용) 
				//$ratio = '4:3';        //-- 이미지를 4:3 비율로 잘라냄 
				$ratio = 'false';        //-- 원본 이미지비율을 유지 
				$get_size = _getimagesize($src, $size, $ratio); 
				$result = resize_image($dst, $src, $get_size, $quality, $ratio); 
				//이미지 크기 강제조정 끝		
			}
			
				echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$save_url', 'UPLOAD OK');</script>";
			}
	}
?>