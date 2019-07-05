<div data-role="page" id="map_main">
	<div data-role="header" data-position="inline">
		<h1 id="page_title">주변정보</h1>
		<a data-icon="home" data-theme="a" href="index.html" data-direction="reverse" >홈</a>
		<a id="open_search" data-role="actionsheet" class="ui-btn-right" data-icon="search" data-sheet='search_form' data-theme="b">검색</a>
		<form id='search_form'>
			<input id='keyword' type='text' placeholder='검색어를 입력하세요.'/>
			<a data-role='button' id="btn_search" data-mini="true">Search</a>
			<a data-role='button' data-rel='close' data-mini="true">Cancel</a>
		</form>
	</div>
	<div data-role="content" id="content">
		<div id="map_canvas"></div>
	</div>
</div>