<?php
require 'medoo.php'; 

	$database = new medoo([
		'database_type' => 'mysql',
		'database_name' => 'admin_tarimsaltv',
		'server' => 'localhost',
		'username' => 'admin_tarimsaltv',
		'password' => '',
		'charset' => 'utf8'
	]);	

	if(isset($_GET['transaction']) && $_GET['transaction'] == "select")
	{
		$videos = $database->select("playlist1", "*");
		//shuffle($videos);
		
		$response='{ "videos" : [';
		foreach($videos as $v)
		{
			$response .= '{ "video_id":"'.$v["video_id"].'", "image_path":"'.$v["image_path"].'", "duration":"'.$v["duration"].'", "title":"'.$v["title"].'" },'; 
		}
		$response = substr($response, 0, -1);
		$response .= ']}';
		echo $response;
	}
	else
	{
		 header("Location:index.php");	
	}	 
		 
		 