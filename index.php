<?php

if(!isset($_GET["secret"])){
	die("coming soon : )");
}

$notIndexReqest = isset($id) ? str_replace("/", "",trim($id)) : false;

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);


$resetCache = isset($_GET["cache"]) ? true: false;

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
	ob_start();
	//print_r($_SERVER);
	$cachefile = "cache/".basename($_SERVER['SCRIPT_NAME']);
	$cachetime = 9999999999999999;//(0.2) * 60 * 60; // 2 hours


	if ($_SERVER['QUERY_STRING']!='') {
	$cachefile .= '_'.($_SERVER['QUERY_STRING']);
	}
	if (file_exists($cachefile) && !$resetCache){//(time() - $cachetime < filemtime($cachefile))) {
		$stuff = file_get_contents($cachefile);
		if( strpos($stuff,'<b>Warning</b>') === false){
			//include($cachefile); // include the cache file
			$item = file_get_contents ($cachefile); // include the cache file
			$item = json_decode($item);
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$finish = $time;
			$total_time = round(($finish - $start), 4);
			//echo $total_time.' seconds';
			//exit;
		}
	}

//$pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};



$slug = "mavra";

	
	$loadPath = "http://api.are.na/v2/channels/$slug";
	$token = file_get_contents("token");
	if(!isset($item)):
		if (function_exists("curl_version")):

		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $loadPath);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));

		    $raw = curl_exec($curl);
		   // $info = curl_getinfo($curl);

		    curl_close($curl);
		elseif (file_get_contents(__FILE__) && ini_get("allow_url_fopen")):
			echo "funciotn doesn't exist";
		    $raw = file_get_contents($loadPath);
		else:
		    echo "Could neither find cURL, nor allow_url_fopen is available!";
		endif;
		$item = json_decode($raw);
	else:
		//echo "item is set";
	endif;

	//echo"<pre>";print_r($item);echo"</pre>";

//$credits = $arena->get_block($credits_id);
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Mavros</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script src="http://<? echo $_SERVER["SERVER_NAME"]; ?>/jquery-1.9.0.min.js"></script>
<?
if($item):
		$items = new ArrayObject($item->contents);
		foreach($items as $i):
			if($i->class == "Text"):
					$foo = explode(",", $i->content);
					$first = isset($foo[0]) ? $foo[0] : "white";
					$second = isset($foo[1]) ? $foo[1] : "white";
					$third = isset($foo[2]) ? $foo[2] : "white";
					$fourth = isset($foo[3]) ? $foo[3] : "white";
					$fifth = isset($foo[4]) ? $foo[4] : "grey";
					$sixth = isset($foo[5]) ? $foo[5] : "black";

				break;
			endif;
		endforeach;
	endif;


	$transition = ".1s";
?>
	<style>
		*, html, body{
			padding:0;
			margin:0;
			font-family:"Futura", Futura, arial, sans-serif;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			word-wrap:break-word;
		}
		
		html, body, .content, .body{
			background-color:<? echo $first;?>;
			min-height:100%;
		}
		a, a:hover, a:active, a:visited{
			color:black;
			text-decoration:none;
		}
		 a:hover{
			text-decoration:underline;
		 }
		.menu{
			-webkit-border-radius:0 0 100% 0;
			-moz-border-radius:0 0 100% 0;
			border-radius:0 0 100% 0;
			cursor:pointer;
			z-index:2;
			position:fixed;
			top:0px;
			left:0px;
			background-color:<? echo $second;?>;
			padding:25px;
			padding-left:14px;
			width:179px;
			height:133px;
			border-right:0px solid grey;
			border-bottom:0px solid black;

	-webkit-transition: all <?=$transition;?> linear;
    -o-transition: all <?=$transition;?> linear;
    -moz-transition: all <?=$transition;?> linear;
    -ms-transition: all <?=$transition;?> linear;
    -kthtml-transition: all <?=$transition;?> linear;
    transition: all <?=$transition;?> linear;
		}

		.menu:hover{
			background-color: <?=$fifth;?>;
			/*border-right:5px solid grey;
			border-bottom:5px solid black;
			margin-top:-5px;
			margin-left:-5px;
			-webkit-transition: all <?=$transition;?> linear;
		    -o-transition: all <?=$transition;?> linear;
		    -moz-transition: all <?=$transition;?> linear;
		    -ms-transition: all <?=$transition;?> linear;
		    -kthtml-transition: all <?=$transition;?> linear;
		    transition: all <?=$transition;?> linear;*/
		}

		.menu.click{
/*
			border-right:0px solid grey;
			border-bottom:0px solid black;
			margin-top:0px;
			margin-left:0px;
			-webkit-box-shadow: 0px 0px 0px #888888;
			-moz-box-shadow: 0px 0px 0px #888888;
			box-shadow: 0px 0px 0px #888888;
	-webkit-transition: all <?=$transition;?> linear;
    -o-transition: all <?=$transition;?> linear;
    -moz-transition: all <?=$transition;?> linear;
    -ms-transition: all <?=$transition;?> linear;
    -kthtml-transition: all <?=$transition;?> linear;
    transition: all <?=$transition;?> linear;
*/
		}

		.menu img.logo{
			width:125px;
		}
		.menu .border-menu{
			margin-top:10px;
			font-size:29px;
		}

.border-menu {
  position: relative;
  padding-left: 1.25em;
}
.border-menu:before {
  content: "";
  position: absolute;
  top: 0.25em;
  left: 0;
  width: 1em;
  height: 0.125em;
  border-top: 0.375em double <?=$sixth;?>;
  border-bottom: 0.125em solid <?=$sixth;?>;
}
		.menu{
			text-align:left;
		}


		.menu a{
			display:block;
		}

		.content{
			width:100%;
			overflow:hidden;
			background-color:<? echo $first;?>;
		}
		.menuNav{
			padding:25px;
			position:fixed;
			background-color: <? echo $third;?>;
			float:left;
			width:100%;
			margin-left:-100%;
			padding-top:179px;
			padding-left:0px;
			-webkit-transition: all 1s ease-in-out;
			-moz-transition: all 1s ease-in-out;
			-o-transition: all 1s ease-in-out;
			transition: all 1s ease-in-out;
		}
		.menuLink{
			display:block;
		}
		.menuLink.subLink{
			margin-left:25px;
		}
		.menuNav.visible{
			margin-left:0;
		}
		.body{
			background-color: <? echo $fourth;?>;
			float:left;
			padding:25px;
			padding-top:179px;
			margin-left:0%;
			width:100%;
			min-width:320px;
			min-height:90%;
			-webkit-transition: all 1s ease-in-out;
			-moz-transition: all 1s ease-in-out;
			-o-transition: all 1s ease-in-out;
			transition: all 1s ease-in-out;
		}
		.titleFont{
			font-size:1.8em;
		}
		.subtitleFont{
			font-size:1.4em;
		}
		.body.visible{
			margin-left:100%;
		}

		.block{
			margin-top:100px;
			//margin:100px auto;
			max-width:1280px;
		}
		.block:nth-of-type(1){
			margin-top:4px;
		}
		.block * {
			//margin:auto;
			display:block;
		}
		.channelLink *{
			max-width:100%;
		}
		.blockImage{
			max-width:100%;
			//margin:auto;
			display:block;
		}
		.blockMedia *{
			max-width:100%;
		}
		@media only screen and (max-width : 768px){
					.menu{

			border-right:5px solid grey;
			border-bottom:5px solid black;
			margin-top:-5px;
			margin-left:-5px;
			-webkit-transition: all <?=$transition;?> linear;
		    -o-transition: all <?=$transition;?> linear;
		    -moz-transition: all <?=$transition;?> linear;
		    -ms-transition: all <?=$transition;?> linear;
		    -kthtml-transition: all <?=$transition;?> linear;
		    transition: all <?=$transition;?> linear;
		}

			.block{
				margin:10px;
				margin-top:100px;
			}
		}
		@media only screen and (max-width : 768px) and (orientation : landscape) {

			.menu{
				position:absolute;
			}
		}
	</style>
  </head>
  <body>
<?//die();?>

	
<div class="menu">	
	<a class="menuTitle" id="header" href="http://<? echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];?>">

	<?
	//if(isset($items->contents->))


	if($item):
		$items = new ArrayObject($item->contents);
		foreach($items as $i):
			if($i->class == "Image"):
				echo "<img class='logo' src='".$i->image->original->url."'>";
				break;
			endif;
		endforeach;
	endif;
	?><br>
  <div class="border-menu"></div>
	</a>	
</div>
<div class="content">
	<div class="menuNav">
		<?php
		echo "<a class='titleFont channelLink menuLink subLink' href='http://".$_SERVER["SERVER_NAME"]."/info/'>Info</a>";
		echo"<br>";
		//echo "<pre>"; print_r($item); echo "</pre>";// = $item->channels;
	if($item):
		$items = new ArrayObject($item->contents);

		foreach($items as $i):
			switch($i->class){
				case("Channel"):
					//echo "<a class='channelLink menuLink' href='http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."/view/".$i->slug."'>".$i->title."</a>";
					$subItems = new ArrayObject($i->contents);
					foreach($subItems as $ii):
						if($ii->class == "Channel"):
							$id = isset($id) ? $id : $ii->slug;
							//echo $id;
							echo "<a class='titleFont channelLink menuLink subLink' href='http://".$_SERVER["SERVER_NAME"]."/view/".$ii->slug."'>".$ii->title."</a>";
						endif;
					endforeach;
				break;
				default:
			}
		endforeach;	
	endif;
?>
	</div>	
	<div class="body">
	<?//echo"<pre>";print_r($item);echo"</pre>";?>
	<?
	if(isset($id)){
		//echo $id;
		//$foo = $item;
		unset($item);
		$isAjax = true;
		if($notIndexReqest == "info"){
			include("info.php");
		}else{

			include("view.php");	
		}
		//$item = $foo;
	}else{
		echo "<pre>";print_r($item);echo "</pre>";
	}
?>
	</div>
</div>		

  </body>

	
<script>


$(document).ready(function(){
	$(".menu").click(function(e){
		e.preventDefault();
		$(".menu").addClass("click");
		$(".menuNav").add(".body").toggleClass("visible");
		setTimeout(function(){
			$(".menu").removeClass("click");
		}, 200);
	})
	
	var hash = window.location.hash
	if(hash){
		$.post(hash, function(result){
			$(".body").html(result);
		});	
	}

	$("body").on("click", ".channelLink", function(e){
		e.preventDefault();
		if($(this).hasClass("menuLink")){
			$(".menuNav").add(".body").toggleClass("visible");
		}
		var foo = $(this).attr("href").split("/");
		bar = foo[foo.length-2];
		foo = foo[foo.length-1];
		//window.location.hash = "!/"+foo;
		history.pushState(null, null, $(this).attr("href"));
		$(".body").html("loading...");
		var href = $(this).attr("href");
		setTimeout(function(){
		$.post(href, function(result){
			$(".body").html(result);
		});
		},1000);
	})


});


</script>

</html>
<?
$fp = fopen($cachefile, 'w'); // open the cache file for writing
//fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file
fwrite($fp, json_encode($item)); // save the contents of output buffer to the file
fclose($fp); // close the file
ob_end_flush(); // Send the output to the browser
?>


<?
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo $total_time.' seconds';
?>
