<?php
	$up_url = '/time-space/testingdata';
	$up_dir = '../testingdata';
	//DIALOG
	$funcNum = $_GET['CKEditorFuncNum'] ;
	$CKEditor = $_GET['CKEditor'] ;
	$langCode = $_GET['langCode'] ;

	if(isset($_FILES['upload']['tmp_name'])) {
		$file_name = $_FILES['upload']['name'];
		$ext = strtolower(substr($file_name, (strrpos($file_name, '.') + 1)));

		if ('jpg' != $ext && 'jpeg' != $ext && 'gif' != $ext && 'png' != $ext) {
			echo 'image only! Please Retry.';
			return false;
		}
		$file_name=date("YmdHms").".".$ext;//POST
		$save_dir = sprintf('%s/%s', $up_dir, $file_name);
		$save_url = sprintf('%s/%s', $up_url, $file_name);

			if (move_uploaded_file($_FILES["upload"]["tmp_name"],$save_dir)) {
				echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$save_url', 'Save Ok');</script>";
			}
	}
?>