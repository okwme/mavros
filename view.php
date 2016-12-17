<?
if(!isset($isAjax) && !(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
	$id = $_GET["id"];
	//echo "is not ajax";
	include("index.php");
	exit;
}else{
	//echo "is ajax";

}

$id = isset($id) ? $id : $_GET["id"];
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
	//ob_start();
	//print_r($_SERVER);
	$cachefile = "cache/view-".$id.".txt";
	$cachetime = (0.2) * 60 * 60; // 2 hours



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

$loadPath = "http://api.are.na/v2/channels/$id";
//echo $loadPath;
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
	//echo "pre>";print_r($item);echo "</pre>";
endif;
//$pr
	//echo"<pre>";print_r($item);echo"</pre>";
	echo "<span class='titleFont'>".$item->title."</span>";
	foreach($item->contents as $i):
		echo "<div class='block'>";
		//			echo "<pre>";print_r($i);echo"</pre>";

		switch($i->class){
			case("Text"):
				echo "<div class='subtitleFont blockTitle'>".$i->title."</div>";
				echo "<div class='blockText'>".$i->content_html."</div>";
			break;
			case("Image"):
				//echo "<h2 class='blockTitle'>".$i->title."</h2>";
				//echo"<pre>";print_r($i);echo "</pre>";
				echo "<img class='blockImage' src='".$i->image->original->url."'>";
				echo "<div class='blockText'>".$i->description_html."</div>";

			break;
			case("Channel"):
				echo "<a class='channelLink' href='view/".$i->slug."'>".$i->title."</a>";
			break;
			case("Media"):
				echo "<div class='subtitleFont blockTitle'>".$i->title."</div>";
				//echo "<pre>";print_r($i);echo"</pre>";
				echo "<div class='blockMedia'>";
				echo $i->embed->html;
				echo "</div>";
			break;
			case("Link"):
				echo "<div class='blockTitle subtitleFont'>".$i->title."</div>";
				//echo "<pre>";print_r($i);echo"</pre>";
				echo "<a class='channelLink' href='".$i->source->url."'><img src='".$i->image->display->url."'></a>";
			break;
			default:
				echo "<pre>";print_r($i);echo"</pre>";
		}
		echo "</div>";

	endforeach;

	//echo"<pre>";print_r($item);echo"</pre>";
	//print_r($item);
?>


<?
$fp = fopen($cachefile, 'w'); // open the cache file for writing
//fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file
fwrite($fp, json_encode($item)); // save the contents of output buffer to the file
fclose($fp); // close the file
//ob_end_flush(); // Send the output to the browser
?>


<?
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo $total_time.' seconds';
?>