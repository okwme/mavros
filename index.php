<?php
error_reporting(E_ALL & ~E_NOTICE);

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
	ob_start();
	//print_r($_SERVER);
	$cachefile = "cache/".basename($_SERVER['SCRIPT_NAME']);
	$cachetime = 2 * 60 * 60; // 2 hours


	if ($_SERVER['QUERY_STRING']!='') {
	$cachefile .= '_'.($_SERVER['QUERY_STRING']);
	}
	if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {
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



$slug = "mavros";

	
	$loadPath = "http://api.are.na/v2/channels/$slug";
	$token = file_get_contents("token");
	
	if(!isset($item)):
	if (function_exists("curl_version")):
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $loadPath);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));

	    $raw = curl_exec($curl);
	    curl_close($curl);
	elseif (file_get_contents(__FILE__) && ini_get("allow_url_fopen")):
	    $raw = file_get_contents($loadPath);
	else:
	    echo "Could neither find cURL, nor allow_url_fopen is available!";
	endif;
	$item = json_decode($raw);
	endif;
	//echo"<pre>";print_r($item);echo"</pre>";
	//die();
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

	<style>
		*, html, body{
			padding:0;
			margin:0;
			font-family:arial, sans-serif;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			word-wrap:break-word;
		}
		body{
			background-color:yellow;
		}
		a, a:hover, a:active, a:visited{
			color:black;
			text-decoration:none;
		}
		.menu{
			z-index:2;
			position:fixed;
			top:0px;
			left:0px;
			background-color:green;
			padding:25px;
		}
		.menu a{
			display:block;
		}

		.content{
			width:100%;
			overflow:hidden;
			background-color:yellow;
		}
		.menuNav{
			padding:25px;
			position:fixed;
			background-color:blue;
			float:left;
			width:100%;
			margin-left:-100%;
			padding-top:100px;
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
			background-color:pink;
			float:left;
			padding:25px;
			padding-top:100px;
			margin-left:0%;
			width:100%;
			-webkit-transition: all 1s ease-in-out;
			-moz-transition: all 1s ease-in-out;
			-o-transition: all 1s ease-in-out;
			transition: all 1s ease-in-out;
		}
		.body.visible{
			margin-left:100%;
		}

		.block{
			margin:100px auto;
			max-width:768px;
		}
		.blockImage{
			max-width:100%;
			margin:auto;
			display:block;
		}
		@media only screen and (max-width : 768px){
			.block{
				margin:10px;
			}
		}
	</style>
  </head>
  <body>
<?//die();?>

	
<div class="menu">	
	<a class="menuTitle" id="header" href="/">Mavros</a>	
</div>
<div class="content">
	<div class="menuNav">
		<?php
		print_r($items);
		die();
		//$item->contents = $item->channels;
		$items = new ArrayObject($item->contents);
		foreach($items as $i):
			if($i->class == "Channel"):
				echo "<a class='channelLink menuLink' href='http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."/view/".$i->slug."'>".$i->title."</a>";
				$subItems = new ArrayObject($i->contents);
				foreach($subItems as $ii):
					if($ii->class == "Channel"):
						echo "<a class='channelLink menuLink subLink' href='http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."/view/".$ii->slug."'>".$ii->title."</a>";
					endif;
				endforeach;
			endif;
		endforeach;	
?>
	</div>	
	<div class="body">
	<?//echo"<pre>";print_r($item);echo"</pre>";?>
	<?
	if(isset($id)){
		$isAjax = true;
		include("view.php");
	}else{
		print_r($item);
	}
?>
	</div>
</div>		

  </body>

	<script src="http://<?= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>jquery-1.9.0.min.js"></script>
	
<script>


$(document).ready(function(){
	$("#header").click(function(e){
		e.preventDefault();
		$(".menuNav").add(".body").toggleClass("visible");
	})

	$("body").on("click", ".channelLink", function(e){
		e.preventDefault();
		if($(this).hasClass("menuLink")){
			$(".menuNav").add(".body").toggleClass("visible");
		}
		$(".body").html("loading...");
		$.post($(this).attr("href"), function(result){
			$(".body").html(result);
		});
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