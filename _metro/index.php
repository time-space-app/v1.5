<?php include "header.php";?>
<?php
$MENU_CODE= "001001000";
?>
<div class="">
<div data-role="scrollbox" data-scroll="horizontal" style=""><!--min-width: 1800px; height: 100%;-->
    <div class="tile-area tile-area-dark" style="background: url(/<?php echo $flugin_url ?>/image/main-bg.jpg) top left no-repeat; background-size: cover;">
        <h1 class="tile-area-title fg-white" style="padding-top:5px">
        <span style="font-size:40px;line-height:0px;padding-top:0px;margin-top:0px;"><i class="icon-sun-3 on-left fg-yellow"></i><a href="/" style="color:white">
        Time-Space<br/>& 웹 CMS툴</a></h1>
        <div class="user-id" style="margin-top:5px">
            <div class="user-id-image">
                <span class="icon-user no-display1"></span>
                <img src="/<?php echo $flugin_url ?>/image/small_logo.png" class="no-display">
            </div>
            <div class="user-id-name">
                <span class="first-name">Welcome</span>
                <span class="last-name"><?php echo empty($_SESSION['valid_name'])? Guest : $_SESSION['valid_name']?></span>
            </div>
        </div>
	<div class="tile-group six" style="padding-top:0px;">
	        <div class="row" style="padding-top:0px;margin-top:0px;border:solid yellow 1px;">
	            <div>
	                <div class="carousel" id="carousela">
	                    <div class="slide"><a href="#">
	                        <img src="image/alp1.jpg" class="cover1" /></a>
	                    </div>
	                    <div class="slide"><a href="#">
	                        <img src="image/alp2.jpg" class="cover1" /></a>
	                    </div>
	                    <div class="slide"><a href="#">
	                        <img src="image/alp3.jpg" class="cover1" /></a>
	                    </div>
			    <div class="slide"><a href="#">
	                        <img src="image/alp4.jpg" class="cover1" /></a>
	                    </div>
			    <div class="slide"><a href="#">
	                        <img src="image/alp5.jpg" class="cover1" /></a>
	                    </div>

	                    <a class="controls left"><i class="icon-arrow-left-3"></i></a>
	                    <a class="controls right"><i class="icon-arrow-right-3"></i></a>
	                
	                </div>
	                <script>
	                    $(function(){
	                        $("#carousela").carousel({
	                            height: 200,
                                    effect: 'fade',
                                    markers: {
                                        show: false,
                                        type: 'square',
                                        position: 'bottom-right'
                                    }
	                        });
	                    })
	                </script>
	            </div>
	        </div>
        </div>

        <div class="tile-group six" style="padding-top:10px;">
            <a class="tile double bg-lightBlue live" data-role="live-tile" data-effect="slideUp" href="/<?php echo $flugin_url ?>/board/list.html/MENU_CODE/<?php echo $MENU_CODE?>/BOARD_ID/notice">
		<!--[if lte IE 8 ]>
		<div id="carousel21" class="carousel bg-transparent no-overflow">
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
		        	while($row = mysqli_fetch_array($result)) { $i1++;
		?>
                <div class="tile-content email slide">
                    <div class="email-image">
                        <img src="<?php echo get_image_file_from_html($row[CONTENT],1)?>">
                    </div>
                    <div class="email-data">
                        <span class="email-data-title"><?php echo cut_str($row[TITLE],44,'...')?></span>
                        <span class="email-data-subtitle">Notice</span>
                        <span class="email-data-text"><?php echo cut_str($row[CONTENT],28,'...')?></span>
                    </div>
                </div>
                <?php
		          	}
		      }
		?>
		<div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="icon-mail"></span> Notice</h3></div>
                    <div class="badge"><?php echo $i1?></div>
                </div>
		<!--[if lte IE 8 ]>
		</div>
		<script>
		    $(function(){
		        $("#carousel21").carousel({
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
                        <h1 class="fg-white no-margin"><?php echo date("d", time());?></h1>
                        <p class="fg-white"><?php echo date("l", time());?></p>
                    </div>
                </div>
                <div class="brand">
                    <div class="label"><h3 class="no-margin fg-white"><span class="icon-calendar"></span> <?php echo date("Y", time());?> <?php echo date("F", time());?></h3></div>
                </div>
            </a> <!-- end tile -->

            <div class="tile double">
            	<a href="/<?php echo $flugin_url ?>/board/list.html/MENU_CODE/003001000/BOARD_ID/community">
                <div class="tile-content image-set">
            	<?php
			 //셀렉트 
				$SQL = "SELECT";
				$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
				$SQL .= " FROM T_BOARD";
				$SQL .= " WHERE BOARD_ID = 'community'";
				$SQL .= " ORDER BY SEQ DESC LIMIT 0 , 4";
				$result = $GPLdb5->GPLexcute_query($SQL);
				$i1=0;
		        if($result){
		        	while($row = mysqli_fetch_array($result)) { 
				$img_array[$i1] = get_image_file_from_html($row[CONTENT],1);
				$i1++;
		          	}
		        }
                    	for($line = 0; $line < 5; $line++){
	        		if(empty($img_array[$line]))$img_array[$line]="/<?php echo $flugin_url ?>/image/small_logo.png";
			?>
	                    <img src="<?php echo $img_array[$line]?>">
	                <?php 	} ?>
                </div>
                </a>
            </div>
            <!-- end small tiles -->
            
	   <!--<div class="tile-group double" style="padding-top:0px;margin-right:0px">-->
	   <?php
		 //셀렉트 
			$SQL = "SELECT DISTINCT";
			$SQL .= " BOARD_ID";
			$SQL .= " FROM T_BOARD";
			$SQL .= " WHERE BOARD_ID != 'notice'";
			$SQL .= " ORDER BY BOARD_ID ASC";
			$gresult = $GPLdb5->GPLexcute_query($SQL);
	        if($result){
	        	while($grow = mysqli_fetch_array($gresult)) { $cnt++;
			//메뉴 변수
			switch ($grow[BOARD_ID]) { //notice, qa, repair, pds, faq
				case 'community' : $class='bg-darkOrange'; $menu='002000000'; $title='COMMUNITY';break;
				case 'qa'  : $class='bg-darkPink'; $menu='002000000'; $title='Q/A';break;
				case 'pds'  : $class='bg-darkBlue'; $menu='002000000'; $title='PDS';break;
				default   : $class='bg-darkOrange'; $menu='002000000'; $title='COMMUNITY';break;
			}
	   ?>

           <a class="tile double double-vertical bg-steel" href="/<?php echo $flugin_url ?>/board/list.html/BOARD_ID/<?php echo $grow[BOARD_ID]?>/MENU_CODE/<?php echo $menu?>">
                <div class="tile double double-vertical live <?php echo $class?>" data-role="live-tile" data-effect="slideUpDown">
		<!--[if lte IE 8 ]>
		<div id="<?php echo $grow[BOARD_ID]?>" class="carousel bg-transparent no-overflow">
		<![endif]-->
	       	<?php
			 //셀렉트 
				$SQL = "SELECT";
				$SQL .= " SEQ,BOARD_ID,TITLE,CONTENT";
				$SQL .= " FROM T_BOARD";
				$SQL .= " WHERE BOARD_ID = '".$grow[BOARD_ID]."'";
				$SQL .= " ORDER BY TOP_NEWS DESC, SEQ DESC LIMIT 0 , 3";
				$result = $GPLdb5->GPLexcute_query($SQL);
		        if($result){
		        	while($row = mysqli_fetch_array($result)) { $i++;
		?>
                <div class="tile-content email slide" style="height:230px">
                    <div class="tile-content image">
                        <img src="<?php echo get_image_file_from_html($row[CONTENT],1)?>" style="width:250px">
                    </div>
                    <div class="brand <?php echo $class?>" style="margin:0px;padding:0px">
                        <span class="label"><?php echo cut_str($row[TITLE],46,'...')?></span>
                        <span class="label"><?php echo cut_str($row[CONTENT],46,'...')?></span>
                    </div>
                </div>
                <?php
		          	}
		      }
		?>
		<!--[if lte IE 8 ]>
		</div>
		<script>
		    $(function(){
		        $("#<?php echo $grow[BOARD_ID]?>").carousel({
		            height: 230,
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
                <div class="tile-status">
                    <div class="label" style="text-align:right"><i class="icon-home on-right on-left" style="background: red; color: white; padding: 3px; border-radius: 50%"></i> <?php echo $title?></div>
                </div>
            </a> <!-- end tile -->
	<?php
	          	}
	      }
	?>
      
        </div> <!-- End tile group --><!-- End group six -->

    </div>
</div>
<?php include "footer.php";?>