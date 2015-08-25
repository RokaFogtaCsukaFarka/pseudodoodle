<!DOCTYPE>

<?php
	session_start();
	if(isset($_SESSION["sz_id"]))
		$sz_id=$_SESSION["sz_id"];
	else $sz_id=0;
	if(isset($_SESSION["nTime"]))
		$_SESSION["nTime"]=$_POST['nTime'];
	else
		$_SESSION["nTime"]=0;
?>

<html>
	<head>
		<title>Pseudo Doodle - Beállítások</title>
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

		<script>
			function changeNextInput(inputValue)   				//Jelenleg nem működik!
			{
				if(inputValue==true)
				{
					document.getElementsByName('perparticipant')[0].disabled=true;
					document.getElementsByName('perdate')[0].disabled=true;
				}
				else 
				{
					document.getElementsByName('perparticipant')[0].disabled=false;
					document.getElementsByName('perdate')[0].disabled=false;
				}
			}
		</script>
		<?php 
			function countIdopontok($idopontok)
			{
				$acc=0;
				for($i=1;$i<=$_SESSION['nDates'];$i++)
					for($j=1;$j<$_SESSION['nTime'];$j++)
						if($idopontok["".$i.".".$j.""]!==NULL)	
							$acc++;
				return $acc;
			}

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

			$idopontokszama=countIdopontok($_POST);
			
			/**
			*	Notification: You use countIdopontok() as if there'd be 3-3 time values for each date value in the previous page!
			**/

			for($i=1;$i<=$idopontokszama;$i++)
			{
				$j=1;
				foreach($_POST["$i.$j"] as $ip)		    //HIBA: hogyan határozzam meg az adott time-hoz a hozzátartozó date-et, majd illesszem a datebase-be
				{	
					$parancs="INSERT INTO sz_idopont (szavazas_id, idopont_t)  
								VALUES ('$sz_id','$ip')";   
					if(!mysqli_query($parancs))
						echo "Nem lehet query-t menedzselni az adatbázison: ".mysqli_error($kapcsolat);
					$j++;
				}
			}

			mysqli_close($kapcsolat);
		?>
	</head>

	<body>
		 <h2> Egyszerű szavazás </h2>
		 <p>Egy egyszerű szavazás létrehozásához lépjen nyugodtan tovább.
		 <br/>Ha szeretne bonyolultabb felületet kialakítani, állítsa be ezeket a lehetséges opcióknál.</p>
		 
		 <h2>Beállítások</h2>
		<form id="beallitas" action="atiranyit.php" method="POST">
			<div class="checkbox">	
			<label>		
				<input type="checkbox" name="YesNoIfNeedBe" onchange="changeNextInput(this.value)" />Igen - Nem - Talán opciók felvétele a szavazáshoz<br/>  <!-- Js doesn't work -->
			</label>
			</div>
			<div class="checkbox">			
			<label>			
				<input type="checkbox" name="perparticipant"/>Egyetlen szavazat egy résztvevőnek<br/>
			</label>
			</div>	
			<div class="checkbox">			
			<label>
				<input type="checkbox" name="perdate"/>Egy szavazat egy dátumra<br/>   
			</label>
			</div>
			<div class="checkbox">			
			<label>
				<input type="checkbox" name="email"/>Érvényes emailcím kérése<br/><br/>
			</label>
			</div>
			
			<input type="submit" class="btn btn-primary" value="Következő"/>		
		</form>
	</body>
</html>
