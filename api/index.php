<?php

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/videos', 'getVideos');
$app->get('/videos/:video_id', 'getVideo');
$app->get('/videos/search/:query', 'searchVideoByName');
$app->post('/videos', 'addVideo');
$app->put('/videos/:video_id', 'updateVideo');
$app->delete('/videos/:video_id',	'deleteVideo');

$app->run();

function getVideos() {
	$sql = "select * FROM playlist1 ORDER BY video_id";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$videos = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"videos": ' . json_encode($videos) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getVideo($video_id) {
	$sql = "SELECT * FROM playlist1 WHERE video_id=:video_id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("video_id", $video_id);
		$stmt->execute();
		$video = $stmt->fetchObject();  
		$db = null;
		echo json_encode($video); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function addVideo() {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$video = json_decode($body);
	$sql = "INSERT INTO playlist1 (video_id, title, image_path, duration) VALUES (:video_id, :title, :image_path, :duration)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("video_id", $video->video_id);
		$stmt->bindParam("title", $video->title);
		$stmt->bindParam("image_path", $video->image_path);
		$stmt->bindParam("duration", $video->duration);
		$stmt->execute();
		$video->video_id = $db->lastInsertId();
		$db = null;
		echo json_encode($video); 
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateVideo($video_id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$video = json_decode($body);
	$sql = "UPDATE playlist1 SET video_id=:video_id, title=:title, image_path=:image_path, duration=:duration WHERE video_id=:video_id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("video_id", $video->video_id);
		$stmt->bindParam("title", $video->title);
		$stmt->bindParam("image_path", $video->image_path);
		$stmt->bindParam("duration", $video->duration);
		$stmt->execute();
		$db = null;
		echo json_encode($video); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteVideo($video_id) {
	$sql = "DELETE FROM playlist1 WHERE video_id=:video_id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("video_id", $video_id);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function searchVideoByName($query) {
	$sql = "SELECT * FROM playlist1 WHERE UPPER(title) LIKE :query ORDER BY title";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$videos = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"videos": ' . json_encode($videos) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getConnection() {
	header('content-type: application/json; charset=utf-8');
	header("access-control-allow-origin: *");
	$dbhost="localhost";
	$dbuser="admin_tarimsaltv";
	$dbpass="tarimsaltv.912";
	$dbname="admin_tarimsaltv";
	$db=new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}

?>