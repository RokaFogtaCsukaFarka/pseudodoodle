<!DOCTYPE>
<?php
	session_start();
	if(isset($_SESSION["sz_id"]))
			$sz_id=$_SESSION["sz_id"];
?>

<html>
	<head>
		<title> Pseudo-Doodle átirányító lap </title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- This is responsible for the mobile friendliness -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<!--<link rel="stylesheet" type="text/css" href="/bootstrap/dist/css/bootstrap.min.css">	
		<script type="text/javascript" src="/bootstrap/dist/js/bootstrap.js"></script>
		<script type="text/javascript" src="/bootstrap/dist/js/npm.js"></script>-->

		<?php
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
		
			$kapcsolat=mysqli_connect($db_info["localhost"],$db_info["username"],$db_info["password"],$db_info["database_name"]);
			if(!$kapcsolat)
				die("Nem lehet kapcsolodni a MySQL kiszolgálóhoz: ".mysqli_connect_error());

			/* beallitasok mező update */
			$beallitas=0;	
			if(isset($_POST["YesNoIfNeedBe"]))
				$beallitas+=1;
			if(isset($_POST["perparticipant"]))
				$beallitas+=2;
			if(isset($_POST["perdate"]))
				$beallitas+=4;
			if(isset($_POST["email"]))
				$beallitas+=8;

			$parancs="UPDATE szavazas SET beallitasok='$beallitas' WHERE id='$sz_id'";
			if(!mysqli_query($kapcsolat,$parancs))
				echo "Nem lehet query-t menedzselni az adatbázison: ".mysqli_error($kapcsolat);
			
			
			//A bit of an encoder 
			$sz_enc=$sz_id*2-3; 
			$link="http://".$SERVER["HTTP_HOST"]."/pseudodoodle/app/szavazas.php?szid=".$sz_enc;
		
			function sessionEnd()
			{
				session_unset();
				session_destroy();
			}
			
			if(isset($_POST['submit'])) 
			{
				while($_POST[$var]!=NULL)
				{
					mail($_POST[$var],"Invitation for a Pseudo Doodle Poll","Dear Mr./Mrs./Ms.,<br><br>you become this email to take part in a poll of mine.");
				}
			}
			
			mysqli_close($kapcsolat);
		?>
		
	</head>

	<body onunload="<?php sessionEnd()?>">
	
		<h1>Köszönjük, hogy létrehozta ezt a szavazást!</h1>
		
		<div id="udvozlet">
			A szavazás az alábbi linken tekinthető meg! Ezt küldd tovább ismerőseidnek a szavazásban való részvételhez!
		</div>
			
		Szavazás link: <a class="btn btn-default" href="<?php print $link;?>"><?php print $link;?></a>
		<!-- Mailto: -->
		<br/>
		<!--
		Az alábbi űrlap kitöltésével levelet küldhetsz ismerőseidnek, hogy meghívd őket a szavazásra.
		
		<form id="form_idopontok" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="text" class="emails" name="1"/> 
			<input type="text" class="emails" name="2"/>
			
			<button type="button" value="Cím hozzáadása" onclick="addNode()"/>
			<button value="Küldöm" />
		</form>
		-->
	</body>
</html>
