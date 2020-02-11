<!DOCTYPE html>
<html class="no-js" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Tarımsal Tv - Video Portalı</title>
	<meta name="description" content="Tarımsal Tv - Video Portalı">
	<meta name="author" content="Recep Dur">		
	<meta charset="utf-8">
	<link href="./asset/font-awesome.css" rel="stylesheet">
	<link href="http://www.321youtube.com/css/main.css" rel="stylesheet">
	<script src="./asset/jquery.min.js"></script>
</head>
<body>
	<div class="header">
		<div class="container">
			<h1><a href="index.php">Tarımsal TV</a></h1>				
			<form action="search.php" method="POST">
				<span class="twitter-typeahead" style="position: relative; display: inline-block; direction: ltr;">
					<input type="text" value="" class="tt-hint"  style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
					<input type="text" value="<?php echo $_POST["q"]; ?>" placeholder="Arama" name="q" class="tt-input"  style="position: relative; vertical-align: top; background-color: transparent;">		
				</span>
				<button type="submit"><i class="icon-search"></i></button>
			</form>
		</div>
	</div>
	<?php
		require  'medoo.php';
		$database = new medoo([
			'database_type' => 'mysql',
			'database_name' => 'admin_tarimsaltv',
			'server' => 'localhost',
			'username' => 'admin_tarimsaltv',
			'password' => 'tarimsaltv.912',
			'charset' => 'utf8'
		]);		
	?>
	<div id="search">
		<div id="search-results" class="search-results">		
		<?php					
			$q = $_POST["q"];
			$videos = $database->select("playlist1", "*", ["title[~]" => "$q"]);
			shuffle($videos);
			foreach($videos as $v)
			{
				echo '<div class="entry">
						<a href="watch.php?v='.$v["video_id"].'" class="image">
							<img src="'.$v["image_path"].'">
						</a>
						<div class="duration badge">'.$v["duration"].'</div>
						<a href="watch.php?v='.$v["video_id"].'" class="title">'.$v["title"].'</a>
					</div>';
			}
		?>	
		</div>
		
	</div>

	<div class="footer">		
		<div class="copyright-container">
			<div class="copyright">
				<span>© Tarımsal TV</span>
				<div class="contact">
					<a href="index.php">Anasayfa</a>
					<a href="#"><i class="icon-twitter"></i></a>
					<a href="#"><i class="icon-facebook"></i></a>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>