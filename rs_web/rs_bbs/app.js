$(document).live("mobileinit", function() {

	/********************************************
	 * 기본 환경설정
	 ********************************************/
	$.extend($.mobile, {
		defaultPageTransition: "slide",
		defaultDialogTransition: "pop",
		loadingMessage: "페이지 로딩중입니다...",
		loadingMessageTextVisible: true,
		loadingMessageTheme: "a",
		pageLoadErrorMessage: "페이지를 불러올 수 없습니다.",
		pageLoadErrorMessageTheme: "e",
		allrowCrossDomainPages: true
	});
	/********************************************
	 * 글 쓰기 페이지
	 ********************************************/
	$("#write").live("pageinit", function() {
		/** 글 저장 버튼 처리 */
		$("#write #btn_write_save").tap(function() {
			var id	= $("#write #id");
			var user_name	= $("#write #user_name");
			var user_pass	= $("#write #user_pass");
			var subject		= $("#write #subject");
			var content		= $("#write #content");
			var SE_NUM		= $("#write #SE_NUM");
			var SE_NUM1		= $("#write #SE_NUM1");
			var SE_NUM2		= $("#write #SE_NUM2");

			if (!user_name.val()) {
				alert("이름을 입력하세요");
				user_name.focus();
				return false;
			}
			if (!user_pass.val()) {
				alert("비밀번호를 입력하세요");
				user_pass.focus();
				return false;
			}
			if (!subject.val()) {
				alert("글 제목을 입력하세요");
				subject.focus();
				return false;
			}
			if (!content.val()) {
				alert("내용을 입력하세요");
				content.focus();
				return false;
			}
			/*
			if (!SE_NUM.val()) {
				alert("더하기 답을 입력하세요");
				SE_NUM.focus();
				return false;
			}
			*/
			$.ajax({
				url: "write_ok.php",
				type: "post",
				data : {
					"user_name": user_name.val(),
					"user_pass": user_pass.val(),
					"subject": subject.val(),
					"content": content.val(),
					"id": id.val(),
					"SE_NUM1": SE_NUM1.val(),
					"SE_NUM2": SE_NUM2.val(),
					"SE_NUM": SE_NUM.val()
				},
				dataType: "json",
				timeout: 30000,
				success: function(json) {
					var num = json.num;
					if(num=="no_spam"){
						alert("스팸방지 숫자가 일치하지 않습니다.");
						return false;					
					}else{
						$.mobile.changePage("view.php", {
							data : {
								"id": id.val(),
								"num": num
							}
						});
					}
				},
				error: function(xhr, textStatus, errorThrown) {
					alert("글쓰기에 실패했습니다.\n" + textStatus + " (HTTP-" + xhr.status + " / " + errorThrown + ")");
				}
			});
		});
	});
	
	/********************************************
	 * 글 읽기 페이지
	 ********************************************/
	$("#view").live("pageinit", function() {
		/** 글 삭제 버튼 처리 */
		$("#view #delete_password #btn_delete").tap(function() {
			var pwd = $("#view #delete_password #password").val();
			checkPassword("delete", pwd);
		});

		/** 글 수정 버튼 처리 */
		$("#view #edit_password #btn_edit").tap(function() {
			var pwd = $("#view #edit_password #password").val();
			checkPassword("edit", pwd);
		});
	});
	
	/********************************************
	 * 글 수정 페이지
	 ********************************************/
	$("#edit").live("pageinit", function() {
		/** 글 저장 버튼 처리 */
		$("#edit #btn_edit_save").tap(function() {
			var id	= $("#edit #id");
			var num	= $("#edit #num");
			var user_name	= $("#edit #user_name");
			var subject		= $("#edit #subject");
			var content		= $("#edit #content");

			if (!user_name.val()) {
				alert("이름을 입력하세요");
				user_name.focus();
				return false;
			}
			if (!subject.val()) {
				alert("글 제목을 입력하세요");
				subject.focus();
				return false;
			}
			if (!content.val()) {
				alert("내용을 입력하세요");
				content.focus();
				return false;
			}

			$.ajax({
				url: "edit_ok.php",
				type: "post",
				data : {
					"user_name": user_name.val(),
					"subject": subject.val(),
					"content": content.val(),
					"num": num.val()
				},
				dataType: "text",
				timeout: 30000,
				success: function(json) {
					$.mobile.changePage("view.php", {
						data : {
							"id": id.val(),
							"num": num.val()
						},
						reverse: true,
						changeHash : false
					});
				},
				error: function(xhr, textStatus, errorThrown) {
					alert("글수정에 실패했습니다.\n" + textStatus + " (HTTP-" + xhr.status + " / " + errorThrown + ")");
				}
			});
		});
	});
});

function checkPassword(mode, pwd) {
	if (!pwd) {
		alert("비밀번호를 입력하세요");
		return false;
	}

	var num = $("#view > input#num").val();

	$.ajax({
		url: "password_ok.php",
		type: "post",
		data : {
			"num": num,
			"user_pass": pwd
		},
		dataType: "json",
		timeout: 30000,
		success: function(json) {
			if (!json.result) {
				alert("비밀번호가 맞지 않습니다.");
			} else {
				if (mode == "delete") {
					deleteArticle(num);
				} else {
					editArticle(num);
				}
			}
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("비밀번호 검사에 실패했습니다.\n" + textStatus + " (HTTP-" + xhr.status + " / " + errorThrown + ")");
		}
	});
}

function deleteArticle(num) {
	$.ajax({
		url: "delete_ok.php",
		type: "post",
		data : "num=" + num,
		dataType: "json",
		timeout: 30000,
		success: function(json) {
			var id = $("#view #id").val();
			$.mobile.changePage("list.php", {
				data: {"id":id},
				reverse: true,
				changeHash : false
			});
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("글 삭제에 실패했습니다.\n" + textStatus + " (HTTP-" + xhr.status + " / " + errorThrown + ")");
		}
	});
}

function editArticle(num) {
	var id = $("#view #id").val();
	$.mobile.changePage("edit.php#edit", {
		data: {"id":id, "num":num},
		type: "post",
		changeHash : false
	});
}