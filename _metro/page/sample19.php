<?php include "../header.php";?>
<div>
<?php
$url = 'http://weather.yahooapis.com/forecastrss?w=1132599&u=c';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$g = curl_exec($ch);
		curl_close($ch);
		$smplxml = simplexml_load_string($g);
		$smplxml->registerXpathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0'); 
		$children = $smplxml->xpath('//channel/item/yweather:condition'); 
		print_r($children);
		
?>
<h1 class="fg-white ntm"><?php echo $children[0]['text']?>&deg;</h1>
<?php include "../footer.php";?>