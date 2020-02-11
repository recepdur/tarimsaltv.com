<?php
//require 'medoo.php'; 

		/*
	$database = new medoo([
		'database_type' => 'mysql',
		'database_name' => 'admin_tarimsaltv',
		'server' => 'localhost',
		'username' => 'admin_tarimsaltv',
		'password' => 'tarimsaltv.912',
		'charset' => 'utf8'
	]);	


		//$videos = $database->select("playlist1", "*", ["LIMIT" => 2]);
		//shuffle($videos);
		
		$response='{ "videos":[';
		foreach($videos as $v)
		{
			$response .= ' {"video_id":"'.$v["video_id"].'","image_path":"'.$v["image_path"].'","duration":"'.$v["duration"].'","title":"'.$v["title"].'"},'; 
		}
		$response = substr($response, 0, -1);
		$response .= ' ] }';
		echo $response;
		
		*/
		
		$connection = mysqli_connect("localhost","admin_tarimsaltv","tarimsaltv.912","admin_tarimsaltv") or die("Error " . mysqli_error($connection));
		$sql = "select * from playlist1";
		$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
		
		$json_response = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$row_array['Name'] = $row['video_id'];
			array_push($json_response,$row_array);
		}
		
		//header('Content-type: application/json');
		header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

		echo '{"records":'.json_encode($json_response).'}';		
				
		mysqli_close($connection);
				