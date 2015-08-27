<!DOCTYPE>
<?php
		session_start();
		
		/*Session valuables initialized: not working as shows up eg. in the next page!*/
		$_SESSION['sz_id']=0;
		$_SESSION['nDates']=0;	
		$_SESSION['nTime']=0;
		
		/*I decided to pass the SID in a cookie, as the POST method is used in passing through the form*/
		ini_set('session.use_only_cookies','1');  
?>
	<!-- Only accepts three dates on the other side!-->
<html>
	<head>
		<title>Pseudo Doodle - Napok</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
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

		<script type="text/javascript">
				
			/**
			* This addOnClick() function creates a new datepicker type input element in the   	
			* "new_dates" <div> with JS preparing the HTML DOM tree. 
			**/
			function addOnClick(n)
			{  
				var newDev = document.createElement("dev");
				newDev.setAttribute("class","form-group col-xs-4");

				var inputText=document.createElement("input");	
				inputText.setAttribute("type","text");
				inputText.setAttribute("data-provide","datepicker");
				inputText.setAttribute("data-date-format","yyyy/mm/dd");
				inputText.setAttribute("data-today-btn","true");
				inputText.setAttribute("class","form-control col-xs-4");
				inputText.setAttribute("name",n);   //Why doesn't it work??
				inputText.setAttribute("value",n);
				var newSpan=document.createElement("span");
				newSpan.setAttribute("class","glyphicon glyphicon-calendar");
				newSpan.setAttribute("aria-describerdby","form-control col-xs-4");
				var newln=document.createElement("br");			
				var element=document.getElementById("new_dates");
				element.appendChild(newDev);
				newDev.appendChild(inputText);
				newDev.appendChild(newln);
				newDev.appendChild(newln);
				newDev.appendChild(newln);
				return 0;
			}

			/**
			*	The goal of this function is to avoid date collision, 
			*       so that each date would be selected only once, and to avoid empty inputs!
			*	The function is triggered at the submission of the form, 
			*	and checks all the text type inputs with the proper Name attributes.
			**/
			function checkByName(n)
			{
				for(var i=1;i<=n;i++)
					for(var j=2;j<=n;j++){						
						if(document.getElementsByName('i').name===document.getElementsByName('j'.name)
						{
							alert("Legalább két kiválasztott elem neve megegyezik egymással!");
							return false;     
						}
					}
				return true;
			}
			function checkTheForm(n)  // Doesn't work 
			{
				if(checkByName(n))
					for(var i=1;i<=n;i++)
						for(var j=2;j<=n;j++){
							if(document.getElementsByName('i').value===document.getElementsByName('j').value)
							{
								alert("Legalább két kiválasztott elem megegyezik egymással!");
								return false;     
							}
						}
				else return false;
				return true;
			}
		</script>
	</head>

	<body>
		<?php 
			//Default number of the datepicker type inputs
			$n=3;
			
			$filename = "db.json";
			$file = fopen( $filename, "r" );
			if( $file == false )
			{
			  echo ( "Error in opening file: 'db.json'." );
			   exit();
			}
			$filesize = filesize( $filename );
			$filetext = fread( $file, $filesize );
			fclose( $file );
			
			$db_info = json_decode($filetext,true);
			
			$cim=$_POST["cim"];
			$hely=$_POST["hely"];
			$leiras=$_POST["leiras"];
			$nev=$_POST["nev"];
			$email=$_POST["email"];
			//$inditas_idopont=time();
			$kapcsolat=mysqli_connect($db_info["localhost"],$db_info["username"],$db_info["password"], $db_info["database_name"]);
			if(!$kapcsolat)
				die("Nem lehet kapcsolodni a MySQL kiszolgalohoz: ".mysqli_connect_error());

			/*The datas that come through php are to be uploaded into "szavazas" table*/
			$parancs="INSERT INTO szavazas (cim,hely,leiras,nev,letrehozo_emailcim) 
						VALUES ('$cim','$hely','$leiras','$nev','$email')";  
			if(!mysqli_query($kapcsolat,$parancs))
				echo "Nem lehet query-t menedzselni az adatbázison: ".mysqli_error($kapcsolat);


			/*The ID of the current poll is required from the table*/
			$szavazas_id=mysqli_query($kapcsolat,"SELECT id FROM pseudo_doodle.szavazas ORDER BY id DESC LIMIT 1");
			$sz_id_f=mysqli_fetch_row($szavazas_id);
			if(isset($_SESSION['sz_id']))
				$_SESSION['sz_id']=$sz_id_f[0];

			mysqli_close($kapcsolat);

			/**
			*	This function gives data to the hidden input of no_dates, and it adds to the $_SESSION array. 
			*	Ie. the value is 'n'!
			**/
			function onSubmitFC($no)
			{
				if(isset($_SESSION['nDates']))
					$_SESSION['nDates']=$no;
			}
		?>

		<h2>Napok</h2>

		<p>Adjon meg időpontokat alább!</p>

		<form class="form-inline" id="idopont" action="idopontok.php" method="POST" onsubmit="<?php global $n; onSubmitFC($n); echo 'return checkTheForm('.$n.')'; ?>">     
			<div class="form-group col-xs-4 ">	
				<div class="input-group">	
					<input type="text" id=datepicker" class="form-control col-xs-4" data-provide="datepicker-inline" data-date-format="yyyy/mm/dd" data-today-btn="true" name="1" />
					<span class="glyphicon glyphicon-calendar" aria-describerdby="form-control col-xs-4"></span>
				</div>
			</div>
			<br/>	
			<br/>	
			<br/>	
			<div class="form-group col-xs-4">		
				<div class="input-group">	
					<input type="text" id=datepicker" class="form-control col-xs-4" data-provide="datepicker-inline" data-date-format="yyyy/mm/dd" data-today-btn="true" name="2" />
					<span class="glyphicon glyphicon-calendar" aria-describerdby="form-control col-xs-4"></span>
				</div>
			</div>
			<br/>	
			<br/>	
			<br/>	
			<div class="form-group col-xs-4 ">		
				<div class="input-group">	
					<input type="text" id=datepicker" class="form-control col-xs-4" data-provide="datepicker-inline" data-date-format="yyyy/mm/dd" data-today-btn="true" name="3" />
					<span class="glyphicon glyphicon-calendar" aria-describerdby="form-control col-xs-4"></span>
				</div>
			</div>
			<br/>	
			<br/>	
			<br/>	
			<div id="new_dates">
			</div>
			<br/>	
			<br/>	
			<br/>	
			<button type="button" class="btn btn-default" id="date_add" onclick="<?php echo('addOnClick('.++$n.')');?>">Dátumot hozzáad</button> <br/> <br/>	<!--Még a name property nem változik meg $n++; hatására! -->
			<button type="button"class="btn btn-primary" onclick="window.location.replace('altalanos.php')">Előző</button>	
			<input type="submit" class="btn btn-primary" id="ment" value="Következő" />
		</form>
	</body>
</html>
