<?php include "header.php";?>
<div class="">
<div data-role="scrollbox" data-scroll="horizontal" style=""><!--min-width: 1800px; height: 100%;-->
    <div class="tile-area tile-area-dark" style="background: url(/_metro/image/main-bg.jpg) top left no-repeat; background-size: cover;">
        <h1 class="tile-area-title fg-white" style="padding-top:5px">Notebook,LCD Repairs<br/>& Homepage Service</h1>
        <div class="user-id" style="margin-top:5px">
            <div class="user-id-image">
                <span class="icon-user no-display1"></span>
                <img src="/_metro/image/small_logo.png" class="no-display">
            </div>
            <div class="user-id-name">
                <span class="first-name">Welcome</span>
                <span class="last-name"><?=empty($_SESSION['valid_name'])? Guest : $_SESSION['valid_name']?></span>
            </div>
        </div>

        <div class="tile-group six" style="padding-top:0px;">
            <a class="tile double bg-lightBlue live" data-role="live-tile" data-effect="slideUp" href="/_metro/board/list.html?BOARD_ID=notice">
<!--[if lte IE 8 ]>
<div id="carousel2" class="carousel bg-transparent no-overflow">
<![endif]-->
                <?php
			 //셀렉트 
				$SQL = "SELECT";
				$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
				$SQL .= " FROM T_BOARD";
				$SQL .= " WHERE BOARD_ID = 'notice'";
				$SQL .= " ORDER BY TOP_NEWS DESC, SEQ DESC LIMIT 0 , 3";
				$result = $GPLdb5->GPLexcute_query($SQL);
		        if($result){
		        	while($row = mysql_fetch_array($result)) { $i1++;
		?>
                <div class="tile-content email slide">
                    <div class="email-image">
                        <img src="<?=get_image_file_from_html($row[CONTENT],1)?>">
                    </div>
                    <div class="email-data">
                        <span class="email-data-title"><?=cut_str($row[TITLE],44,'...')?></span>
                        <span class="email-data-subtitle">Notice</span>
                        <span class="email-data-text"><?=cut_str($row[CONTENT],28,'...')?></span>
                    </div>
                </div>
                <?php
		          	}
		      }
		?>
		<div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="icon-mail"></span></h3></div>
                    <div class="badge">3</div>
                </div>
<!--[if lte IE 8 ]>
</div>
<script>
    $(function(){
        $("#carousel2").carousel({
            height: 120,
            width: 250,
            period: 3000,
            duration: 500,
            effect: 'fade',
            markers: {
                show: false
            }
        });
    })
</script>
<![endif]-->
            </a>
            <!-- end tile -->

            <a class="tile double bg-violet" style="overflow: visible">
                <div class="tile-content" style="overflow: visible">
                    <div class="input-control text span2 place-left margin10" style="margin-left: 10px" data-role="datepicker">
                        <input type="text" name="sel_date">
                        <button class="btn-date"></button>
                    </div>
                    <div class="text-right padding10 ntp">
                        <h1 class="fg-white no-margin"><?=date("d", time());?></h1>
                        <p class="fg-white"><?=date("l", time());?></p>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="icon-calendar"></span> <?=date("Y", time());?> <?=date("F", time());?></h3></div>
                </div>
            </a> <!-- end tile -->

            <div class="tile">
                <?php
			 //셀렉트 
			$SQL = "SELECT";
			$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
			$SQL .= " FROM T_BOARD";
			$SQL .= " WHERE BOARD_ID = 'notice'";
			$SQL .= " ORDER BY SEQ DESC LIMIT 1 , 1";
			$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
			$img_array = get_image_file_from_html($row[CONTENT],1);
		?>
		<a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row[SEQ]?>">
                <div class="tile-content image">
                    <img src="<?=$img_array?>">
                </div>
                <div class="brand">
                    <div class="label no-margin"><span class="bg-dark"><?=cut_str($row[TITLE],20,'...')?></span></div>
                </div>
            </a>
            </div> <!-- end tile -->

            <!-- small tiles -->
            <a href="#" class="tile half bg-darkRed">
                <div class="tile-content icon">
                    <span class="icon-camera"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-darkOrange">
                <div class="tile-content icon">
                    <span class="icon-headphones"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-green">
                <div class="tile-content icon">
                    <span class="icon-steering-wheel"></span>
                </div>
            </a>

            <a href="#" class="tile half bg-darkPink">
                <div class="tile-content icon">
                    <span class="icon-pictures"></span>
                </div>
            </a>
            <!-- end small tiles -->
           <a class="tile double double-vertical bg-steel" href="http://weather.yahoo.com/" target="_new">
                <div class="tile double double-vertical live bg-darkBlue" data-role="live-tile" data-effect="slideUpDown" style="background: url(/_metro/image/weather.png)">
<!--[if lte IE 8 ]>
<div id="carousel3" class="carousel bg-transparent no-overflow">
<![endif]-->
                <?php
                //지명위치Url http://query.yahooapis.com/v1/public/yql?q=select * from geo.places where text="london"&format=xml
		$xml = array('Seoul' => 1132599, 'Tokyo' => 1118370, 'Beijing' => 2151330);
		foreach($xml as $city => $code) {
			$url = 'http://weather.yahooapis.com/forecastrss?w='.$code.'&u=c';
			$ch = @curl_init();
			$timeout = 5;
			@curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			@curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$yahooxml = @curl_exec($ch);
			@curl_close($ch);
			if (@simplexml_load_string($yahooxml))
			{
			$smplxml = @simplexml_load_string($yahooxml);
			@$smplxml->registerXpathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0'); 
			@$children = $smplxml->xpath('//channel/item/yweather:condition');  
			}
			else 
			{
			$city = "Reload!";
			$children[0]['text'] = "http://weather.yahoo.com";
			$children[0]['date'] = "Traffic jam!";
			}
		?>
		<div class="tile-content slide"> 
                    <div class="padding10" style="background: url(http://us.i1.yimg.com/us.yimg.com/i/us/we/52/<?=$children[0]['code']?>.gif) no-repeat top right;">
                        <h1 class="fg-white ntm"><?=$children[0]['temp']?>&deg;</h1>
                        <h1 class="fg-white no-margin"><?=$city?></h1>
                        <h5 class="fg-white no-margin"><?=$children[0]['text']?></h5>
                        <p class="tertiary-text fg-white no-margin">Today</p>
                        <h4 class="fg-white no-margin"><?=$children[0]['date']?></h4>
                    </div>
                </div>
		<?php } ?>
                </div>
<!--[if lte IE 8 ]>
</div>
<script>
    $(function(){
        $("#carousel3").carousel({
            height: 240,
            width: 250,
            period: 3000,
            duration: 500,
            effect: 'fade',
            markers: {
                show: false
            }
        });
    })
</script>
<![endif]-->
                <div class="tile-status">
                    <div class="label">Weather.yahoo.com</div>
                </div>
            </a> <!-- end tile -->

            <div class="tile double">
                <?php
			 //셀렉트 
			$SQL = "SELECT";
			$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
			$SQL .= " FROM T_BOARD";
			$SQL .= " WHERE BOARD_ID = 'notice'";
			$SQL .= " ORDER BY SEQ DESC LIMIT 2 , 2";
			$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
			$img_array = get_image_file_from_html($row[CONTENT],1);
		?>
		<a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row[SEQ]?>">
                <div class="tile-content image">
                    <img src="<?=$img_array?>">
                </div>
                <div class="brand">
                    <div class="label no-margin"><span class="bg-dark"><?=cut_str($row[TITLE],50,'...')?></span></div>
                </div>
                </a>
            </div> <!-- end tile -->

            <?php
		 //셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE BOARD_ID = 'notice'";
		$SQL .= " ORDER BY SEQ DESC LIMIT 3 , 3";
		$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
		$img_array = get_image_file_from_html($row[CONTENT],1);
	    ?>
	    <a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row[SEQ]?>" class="tile bg-lightBlue">
                <div class="tile-content image">
                    <img src="<?=$img_array?>">
                </div>
                <div class="brand">
                    <div class="label no-margin"><span class="bg-dark"><?=cut_str($row[TITLE],20,'...')?></span></div>
                </div>
            </a>

             <?php
		 //셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE BOARD_ID = 'notice'";
		$SQL .= " ORDER BY SEQ DESC LIMIT 4 , 4";
		$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
		$img_array = get_image_file_from_html($row[CONTENT],1);
	     ?>
		<a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row[SEQ]?>" class="tile bg-darkOrange">
                <div class="tile-content image">
                    <img src="<?=$img_array?>">
                </div>
                <div class="brand">
                    <div class="label no-margin"><span class="bg-dark"><?=cut_str($row[TITLE],20,'...')?></span></div>
                </div>
            </a>

            <?php
		 //셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE BOARD_ID = 'notice'";
		$SQL .= " ORDER BY SEQ DESC LIMIT 5 , 5";
		$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
		$img_array = get_image_file_from_html($row[CONTENT],1);
	    ?>
	    <a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row[SEQ]?>" class="tile double bg-lightBlue">
                <div class="tile-content image">
                    <img src="<?=$img_array?>">
                </div>
                <div class="brand">
                    <div class="label"><span class="bg-dark"><?=cut_str($row[TITLE],44,'...')?></span></div>
                </div>
            </a>

            <?php
		 //셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE BOARD_ID = 'notice'";
		$SQL .= " ORDER BY SEQ DESC LIMIT 6 , 6";
		$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
		$img_array = get_image_file_from_html($row[CONTENT],1);
	    ?>
	    <a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row[SEQ]?>" class="tile double bg-darkGreen">
                <div class="tile-content image">
                    <img src="<?=$img_array?>">
                </div>
                <div class="brand">
                    <div class="label"><span class="bg-dark"><?=cut_str($row[TITLE],44,'...')?></span></div>
                </div>
            </a>
        </div> <!-- End group six -->

        <div class="tile-group">
            <div class="tile-group-title">Office</div>
            <a class="tile half bg-darkBlue">
                <div class="tile-content icon">
                    <img src="/_metro/images/word.png">
                </div>
            </a>
            <a class="tile half bg-darkGreen">
                <div class="tile-content icon">
                    <img src="/_metro/images/excel.png">
                </div>
            </a>
            <a class="tile half bg-darkPink">
                <div class="tile-content icon">
                    <img src="/_metro/images/onenote.png">
                </div>
            </a>
            <a class="tile half bg-orange">
                <div class="tile-content icon">
                    <img src="/_metro/images/powerpoint.png">
                </div>
            </a>
            <a class="tile half bg-lightBlue">
                <div class="tile-content icon">
                    <img src="/_metro/images/outlook.png">
                </div>
            </a>
            <a class="tile half bg-darkRed">
                <div class="tile-content icon">
                    <img src="/_metro/images/access.png">
                </div>
            </a>
        </div> <!-- End tile group -->

        <div class="tile-group double">
            <div class="tile-group-title">Posts</div>
            <?php
		 //셀렉트 
			$SQL = "SELECT";
			$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
			$SQL .= " FROM T_BOARD";
			$SQL .= " WHERE BOARD_ID = 'notice'";
			$SQL .= " ORDER BY SEQ DESC LIMIT 0 , 4";
			$result = $GPLdb5->GPLexcute_query($SQL);
	        if($result){
	        	while($row = mysql_fetch_array($result)) { $i1++;
	    ?>
	    <a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row['SEQ']?>">
            <div class="tile bg-dark">
                <div class="tile-content icon">
                    <img src="<?=get_image_file_from_html($row[CONTENT],1)?>">
                </div>
                <div class="brand">
                    <div class="label"><?=cut_str($row[TITLE],18,'...')?></div>
                </div>
            </div>
            </a>
             <?php
	          	}
	      }
	    ?>
        </div> <!-- End group -->

        <div class="tile-group double">
            <div class="tile double">
            	<a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=9">
                <div class="tile-content image-set">
            	<?php
			 //셀렉트 
			$SQL = "SELECT";
			$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
			$SQL .= " FROM T_BOARD";
			$SQL .= " WHERE BOARD_ID = 'notice'";
			$SQL .= " AND SEQ = 9";
			$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
			$img_array = get_image_file_from_html($row[CONTENT],2);
	        	for($line = 0; $line < 5; $line++){
	        		if(empty($img_array[$line]))$img_array[$line]="/_metro/image/small_logo.png";
		?>
                    <img src="<?=$img_array[$line]?>">
                <?php } ?>
                </div>
                </a>
            </div>
<!--[if lte IE 8 ]>
<div id="carousel4" class="carousel bg-transparent no-overflow">
<![endif]-->
            <div class="tile double live" data-role="live-tile" data-effect="slideUpDown">
               <?php
			 //셀렉트 
				$SQL = "SELECT";
				$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
				$SQL .= " FROM T_BOARD";
				$SQL .= " WHERE BOARD_ID = 'notice'";
				$SQL .= " ORDER BY SEQ DESC LIMIT 0 , 5";
				$result = $GPLdb5->GPLexcute_query($SQL);
		        if($result){
		        	while($row = mysql_fetch_array($result)) { $i1++;
		?>
                <div class="tile-content image slide">
                    <a href="/_metro/board/view.html?BOARD_ID=notice&SEQ=<?=$row['SEQ']?>">
                    <img src="<?=get_image_file_from_html($row[CONTENT],1)?>"></a>
                </div>
                 <?php
		          	}
		      }
		?>

                <div class="tile-status">
                    <span class="label">Images</span>
                </div>
            </div>
<!--[if lte IE 8 ]>
</div>
<script>
    $(function(){
        $("#carousel4").carousel({
            height: 120,
            width: 250,
            period: 3000,
            duration: 500,
            effect: 'fade',
            markers: {
                show: false
            }
        });
    })
</script>
<![endif]-->

        </div>
    </div>
</div>
<?php include "footer.php";?>