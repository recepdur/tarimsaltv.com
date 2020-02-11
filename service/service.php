
<?php

	require 'vendor/autoload.php';
	use Madcoda\Youtube;
	

if(isset($_POST["servicePass"]))
{		
    require  '../medoo.php';
    $database = new medoo([
        'database_type' => 'mysql',
        'database_name' => 'admin_tarimsaltv',
        'server' => 'localhost',
        'username' => 'admin_tarimsaltv',
        'password' => 'tarimsaltv.912',
        'charset' => 'utf8'
    ]);

    $servicePass = $_POST["servicePass"];
    if($servicePass == "Rd5790,,")
    {
        $database->delete("playlist1", [ "video_id[!]" => "xxx" ]); // flush table
    
        $youtube = new Youtube(array('key' => 'AIzaSyDOwvm4ygbaMeSU_xhmALiD_ou35VtJFSo'));
        $playList = $youtube->getPlaylistItemsByPlaylistId('PL93T4Xx7SrRNpAFI9PPorvICRGacqWuQ9');
		
        foreach($playList as $item)
        {
			$response = $youtube->getVideoInfo($item->snippet->resourceId->videoId);				
			$date = new DateTime('1970-01-01');
			$date->add(new DateInterval($response->contentDetails->duration));
			
            $database->insert("playlist1", 
				["video_id" => $item->snippet->resourceId->videoId,
                "title" => $item->snippet->title, 
				"duration" => $date->format('i:s'),
				"publish_at" => $item->snippet->publishedAt,
				"image_path" => $item->snippet->thumbnails->high->url]);
        }	
	
		echo '<script>window.location.href = "http://www.tarimsaltv.com";</script>';
    }	    
    else
    {	
        echo '<script>window.location.href = "http://www.tarimsaltv.com";</script>';
    }	
}
else
{	
    echo '<script>window.location.href = "http://www.tarimsaltv.com";</script>';

}


?>
