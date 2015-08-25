<!DOCTYPE>
<html>
	<head>
		<title>Pseudo Doodle - Köszönjük </title>
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

	<?php
	$adatb="pseudo_doodle";
	$kapcsolat=mysqli_connect("localhost","root","",$adatb);
	if(!$kapcsolat)
		die("Nem lehet kapcsolodni a MySQL kiszolgalohoz: ".mysqli_connect_error());

	/* szavazo tábla feltöltése */
	$nev=$_POST["nev"];
	$sz_id=$_POST["sz_id"];
	$email=$_POST["sz_email"];
	mysqli_query($kapcsolat,"INSERT INTO szavazo (nev, szavazas_id,szavazo_emailcim)
								VAULES ($nev, $sz_id, $email)");
							
	/* valasztott_idopont tábla feltöltése */
	$parancs="SELECT id,idopont_d,idopont_t FROM sz_idopont";
	$valasz=mysqli_query($kapcsolat,$parancs);
	while($row=mysqli_fetch_array($valasz)){
		$parancs="INSERT INTO valasztott_idopont (idopont_d,idopont_t,szavazas_id,idopont_id)
					VALUES ($row['idopont_d'],$row['idopont_t'],$_POST['sz_id'],$row['id'])";
		mysqli_query($kapcsolat,$parancs);
	}

	mysqli_close($kapcsolat);	
	?>

	<body>
		<p>
			<br/>Köszönjük <strong><?print $nev?></strong> a szavazat leadását!
		</p>
	</body>
</html>
