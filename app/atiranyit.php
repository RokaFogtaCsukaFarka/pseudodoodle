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
	
		<script type="text/javascript">
			var nOfAdds = 2;

			function addNode(n){
	  			var divFG = $(#form_mails).add("div").addClass("form-group col-xs-4");
				var label1 = createElement("label");
				label1.setAttribute("for","name"+n);
				divFG.appendChild(label1);
				var ip1 = document.createElement("input");
				ip1.setAttribute("type","text");
				ip1.setAttribute("id","name"+n);
				ip1.setAttribute("name","name"+n);
				ip1.setAttribute("class","names form-control");
				divFG.appendChild(ip1);
				
				var label2 = createElement("label");
				label2.setAttribute("for","email"+n);
				divFG.appendChild(label2);
				var ip2 = document.createElement("input");
				ip1.setAttribute("type","text");
				ip1.setAttribute("id","email"+n);
				ip1.setAttribute("name","email"+n);
				ip1.setAttribute("class","emails form-control");
				divFG.appendChild(ip2);

				return 0;
			}
		</script>
		
	</head>

	<body onunload="<?php sessionEnd()?>">
	
		<h1>Köszönjük, hogy létrehozta ezt a szavazást!</h1>
			
		<h2>Szavazás link:</h2> <br/> 
		<a href="<?php print $link;?>"><?php print $link;?></a>

		<br/>

		Az alábbi űrlap kitöltésével levelet küldhetsz ismerőseidnek, hogy meghívd őket a szavazásra.
		
		<form id="form_mails" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<div class="form-group">
				<label for="name0">Név</label>
				<input type="text" class="names form-control" id="name0" name="name0"/> 
				<label for="email0">Email</label>
				<input type="text" class="emails form-control" id="email0" name="email0"/> 
			</div>
			<div class="form-group">
				<label for="name1">Név</label>
				<input type="text" class="names form-control" id="name1" name="name1"/> 
				<label for="email1">Email</label>
				<input type="text" class="emails form-control" id="email1" name="email1"/> 
			</div>
			<button type="button" value="Személy hozzáadása" onclick="addNode(nOfAdds++)"> </button>
			
			<textarea class="form-control" placeholder="Add meg itt az üzenetet!">
			
			</textarea>

			<button type="submit" value="Küldöm"> </button>
		</form>
		-->
	</body>
</html>
