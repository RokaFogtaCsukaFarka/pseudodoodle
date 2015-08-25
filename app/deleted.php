<!DOCTYPE>
<html>
	<head>
		<title> Pseudo Doodle - Törölt szavazás </title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- This is responsible for the mobile friendliness -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<!--
		<link rel="stylesheet" type="text/css" href="/bootstrap/dist/css/bootstrap.min.css">	
		<script type="text/javascript" src="/bootstrap/dist/js/bootstrap.js"></script>
		<script type="text/javascript" src="/bootstrap/dist/js/npm.js"></script>
		-->
	</head>
	
	<body>
		<?php
			print "Kedves " . $_GET["nev_deleted"] . "!";		
			
			$filename = "db.json";
			$file = fopen( $filename, "r" );
			if( $file == false )
			{
			  echo ( "Error in opening file" );
			   exit();
			}
			$filesize = filesize( $filename );
			$filetext = fread( $file, $filesize );
			fclose( $file );
			
			$db_info = json_decode($filetext,true);
			$kapcsolat=mysqli_connect($db_info["localhost"],$db_info["username"],$db_info["password"], $db_info["database_name"]);
			
			if(!$kapcsolat)
				die("Nem lehet kapcsolodni a MySQL kiszolgalohoz: ".mysqli_connect_error());
			$szid=1+$_GET["szavazas_id"]/3;
			mysqli_query($kapcsolat,"DELETE FROM szavazas WHERE id=$szid");
			mysqli_query($kapcsolat,"DELETE FROM szavazo WHERE szavazas_id=$szid");
			mysqli_query($kapcsolat,"DELETE FROM sz_idopont WHERE szavazas_id=$szid");
			mysqli_query($kapcsolat,"DELETE FROM valasztott_idopont WHERE szavazas_id=$szid");
			mysqli_close($kapcsolat);
		?>
		<br/>Szeretnénk megköszönni a Pseudo Doodle projectben való részvételedet!
		<br/>A kért szavazást töröltük!
	</body>
</html>
