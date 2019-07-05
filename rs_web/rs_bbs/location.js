var zoomlevel = 16;
var map = null;
var address = "";
// 마커에 사용할 데이터
var subject = "타임스페이스";
var description = "홈페이지 제작,LCD수리";
var telephone = "041-568-5935";
var address = "회사상세주소";
	
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

	$("#map_main").live({
		/********************************************
		 * 메인 페이지 초기화 이벤트
		 ********************************************/
		"pageinit": function() {
			// 페이지 초기화시 add버튼 이벤트 등록
			// --> 검색어를 받아서 주변 정보를 조회한다.
			$("#map_main #btn_search").tap(function() {
				var keyword = $("#map_main #keyword").val();
				if (!keyword) {
					alert("검색어를 입력하세요");
					return false;
				}
				// 주변정보 조회 함수 호출
				searchInfo(keyword);
			});
		},
		
		/********************************************
		 * 기본 환경설정
		 ********************************************/
		"pageshow": function() {
			$.mobile.showPageLoadingMsg();

			// 최초 화면로딩시 지도를 표시한다.
			showMap(36.84053472539974, 127.1826334297657);
		}
	});
});

/********************************************
 * 위도와 경도를 표시하도록 지도를 화면에 출력한다.
 ********************************************/
function showMap(x, y) {
    var latlng = new google.maps.LatLng(x, y);
    var myOptions = {
      zoom: zoomlevel,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	google.maps.event.trigger(map, 'resize');
	
	// 주소를 검색하여 HeaderBar에 표시한다.
	$("#map_main h1#page_title").html(address);
	addMarker(subject, address, description, telephone, x, y);
	$.mobile.hidePageLoadingMsg();
}
/********************************************
 * 검색어를 사용하여 구글지도 표시 및 위도/경도를 추출
 ********************************************/
function getLatLng(place) {
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			address: place,
			region: 'ko'
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var bounds = new google.maps.LatLngBounds();
				for (var r in results) {
					if (results[r].geometry) {
						var latlng = results[r].geometry.location;
						bounds.extend(latlng);
						var address = results[0].formatted_address.replace(/^日本, /, '');
						new google.maps.InfoWindow({
							content: address + "<br>(Lat, Lng) = " + latlng.toString()
						}).open(map, new google.maps.Marker({
							position: latlng,
							map: map
						}));
					}
				}
				map.fitBounds(bounds);
				var zoom = map.getZoom();
				map.setZoom(zoom > 6 ? 16 : zoom);
				// 주소를 검색하여 HeaderBar에 표시한다.
				$("#map_main h1#page_title").html(address);
			} else if (status == google.maps.GeocoderStatus.ERROR) {
				alert("서버 통신에러！");
			} else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
				alert("리퀘스트에 문제발생！geocode()에 전달하는GeocoderRequest확인요！");
			} else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
				alert("단시간에 쿼리 과다송신！");
			} else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
				alert("이 페이지에서는 지오코더 이용불가! 왜?");
			} else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
				alert("서버에 문제 발생한거 같아요.다시 한번 해보세요.");
			} else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
				alert("못찾겠어요");
			} else {
				alert("えぇ～っと・・、バージョンアップ？");
			}
		});
}
/********************************************
 * 검색어를 사용하여 위도/경도를 추출한 후,
 * 각 건별로 화면에 표시한다.
 ********************************************/
function searchInfo(keyword) {
	// 로딩 메시지 보이기
	$.mobile.showPageLoadingMsg();
	
	getLatLng(keyword);
	
	$.mobile.hidePageLoadingMsg();
}

/********************************************
 * 지도상에 마커를 표시한다.
 ********************************************/
function addMarker(subject, address, desc, phonenumber, x, y) {
	var myLatlng = new google.maps.LatLng(x, y);
	var marker = new google.maps.Marker({
		position: myLatlng, 
		title: subject
	});
	marker.setMap(map);

	var infowindow = new google.maps.InfoWindow({
		content: getInfoWindowTag(subject, address, desc, phonenumber)
	});

	// 마커를 탭 하였을 때 동작할 이벤트 등록
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});
}

/********************************************
 * 문자열에서 HTML태그를 제거한 후 리턴한다.
 ********************************************/
function stripHTMLtag(string) {
   var objStrip = new RegExp();
   objStrip = /[<][^>]*[>]/gi;
   return string.replace(objStrip, "");
} 

/********************************************
 * 마커를 탭했을 때 표시될 오버레이에 삽입시킬 정보를
 * 표시할 HTML태그를 생성한다.
 ********************************************/
function getInfoWindowTag(title, address, desc, phonenumber) {
	var contentString = "<div><div class='ui-bar ui-bar-b'>" + title + "</div>";
	contentString += "<div class='ui-body ui-body-e'>" + desc + "(" + address + ")<br/><a href='tel:" + phonenumber + "'>전화걸기</a></div>";
	contentString += "</div>";
	return contentString;
}