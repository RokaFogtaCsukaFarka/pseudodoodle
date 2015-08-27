<!DOCTYPE>
<?php
	session_start();
	
	if(isset($_SESSION["sz_id"]))
		$sz_id=$_SESSION["sz_id"];	
	else $sz_id=0;
	if(isset($_SESSION["nDates"]))
		$nodates=$_SESSION["nDates"];
	else
		$nodates=3;
?>
	<!-- Doesn't transmit and get data to the other side at all: prototype.js: ajax.googleapis.com bug-->
<html>
	<head>
		<title>Pseudo Doodle - Időpontok</title>

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
		<script type="text/javascript" src="/bootstrap/dist/js/bootstrap-timepicker.js"></script>
		
		<style>
			.new_values
			{
				float: left;
			}
		</style>

		<script type="text/javascript">
			
			/* Doesn't work properly */
			/*
			* addOnClick() function creates a new timepicker type input element in the "new_dates" <div> by preparing the HTML DOM tree. 
			*/
			
			function addOnClick(j,k,nc)			//j: the number of rows; k: the number of columns to be added; nc: the number of previous columns already existing;
			{  								
				for(var i1=0;i1<=j;i1++)  							//It's zero for the header
				{
					var element=document.getElementById("new_time"+i1);  //Looks up the place, ie. the row for the new timepicker object
					for(var i2=1;i2<=k;i2++)						//Creates the new objects
					{
						if(i1==0)
						{
							var tableData=document.createElement("th");
							tableData.setAttribute("class","new_values");
							var timpckr=document.getElementsById("timepicker");
							tableData.setAttribute("width",timpckr[0].width);		//Width is set here to be as wide as the .timepicker objects
							tableData.innerHTML=(nc+1+i2)+" .időpont";				//A new variable like in the previous page 'n' was could be used to add to the number of headers
							element.appendChild(tableData); 	
						}
						else 
						{
							var tableData=document.createElement("td");					//Initiates only one cell!!
							var newDev = document.createElement("dev");
							newDev.setAttribute("class","input-group bootstrap-timepicker timepicker col-xs-4");

							tableData.setAttribute("class","new_values");
							var inputText=document.createElement("input");
							inputText.setAttribute("type","text");
							inputText.setAttribute("id","timepicker");
							inputText.setAttribute("name",i1+"."+i2);
							inputText.setAttribute("class","form-control");
							inputText.setAttribute("data-template","modal");
							inputText.setAttribute("data-minute-step","1");
							inputText.setAttribute("data-modal-backdrop","true");
							inputText.setAttribute("data-minute-step","1");
							newDev.appendChild(inputText);
							tableData.appendChild(newDev);
							element.appendChild(tableData); 	
						}
					}
				}
				Protoplasm.use('timepicker').transform('.timepicker', {use24hrs:true});
			}

			/**
			*  	copyFirstRow(no_dates,no_time) fn. copies the value from the first TimePicker, and insert it to the other same class elements.
			**/
		
			function copyFirstRow(no_dates,no_time)
			{
				var timeArray=new Array();
				for(var i=1;i<=no_time;i++)
				{
					return_value=document.getElementsByName("1."+i);
					timeArray[i]=return_value[0].value;
				}
					
				for(var i=2;i<=no_dates;i++)
					for(var j=1;j<=no_time;j++)
					{
						return_value=document.getElementsByName(i+"."+j);
						return_value[0].value=timeArray[j];
					}
				return ;
			}
			
			/*
			*	Function to check if there were no collisions in time, triggered on the submission of the form
			*/
			
			function checkTimeColl(no_dates,no_time)			//Etwas funktioniert nicht gut					
			{
				/* Creating and filling timeArray */
				var timeArray=new Array();
				for(var i=0;i<no_dates;i++)
					for(var j=0;j<no_time;j++)				
						timeArray[i*no_time+j]=document.getElementsByName("1."+j)[0].value;   //i*no_dates+j indexing is equal to a 2dim array
						
				/* In the same row ie. for the same date the same time value shouldn't be given */
				for(var i=0;i<no_dates;i++)
					for(var j=0;j<no_time-1;j++)
						for(var k=j+1;k<no_time;k++)
							if(timeArray[i*no_time+j]==timeArray[i*no_time+k])
							{
								alert("A "+i+". sor "+j+". eleme egyezik a sor "+k+". elemével!" );
								return 1;
							}
			}

		</script>
		<?php
			function genTableContent($str1,$str2)
			{
				for($i=1;$i<=$nodates;$i++)
				{
					echo $str1 . $i . $str2;
				}
				return 0;
			}
			
			$notime=3;                               			//Initializing a variable for the number of columns in the "timetable"
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
			
			for($i=1;$i<=$nodates;$i++)
			{
				$datum=$_POST[$i];
				
				$parancs="INSERT INTO sz_idopont (szavazas_id, idopont_d) 
						VALUES (".$sz_id.",".$datum.")";							
				if(!mysqli_query($kapcsolat,$parancs))	
					echo "Nem lehet query-t menedzselni az adatbázison: ".mysqli_error($kapcsolat);
			}
			
			mysqli_close($kapcsolat);
		?>
	</head>

	<body>
		<h2>Időpontok</h2>

		<p>Ezen az oldalon megadhatja a dátumokhoz tartozó időpontokat is.</p>
		<?php
			/*  Initializing the JS n variable instead of $notime, that will be used by the incrementation of the column number and by the functions
					This way the $notime variable's value will be always the default '3'	
					I have also made the sending the var from PHP to JS: $nodates ->  s nd.*/
			echo "<script>var nd=".$nodates.";"; 	
			echo "var nt=".$notime.";</script>"; 	?>
			<form id="form_idopontok" action="beallitasok.php" method="POST" onsubmit="return checkTimeColl(nd,nt)">
				<table class="table table-striped" border="1">
					<tr id="new_time0"><th></th>
					<?php
						for($i=1;$i<=$notime;$i++) 							//Default number is three
							echo "<th>" . $i . ". időpont</th>";  
					
						for($j=1;$j<=$nodates;$j++)
						{          				
							echo "<tr  id='new_time".$j."'><td><b>" . $_POST[$j] ."</b></td>";						 //The format of the date written out's to be changed!!
							for($k=1;$k<=$notime;$k++) { 									
									//Default number is three
								echo '<td><div class="input-group bootstrap-timepicker timepicker col-xs-4">';
								echo '<input id="timepicker" name="'.$j.'.'.$k.'" class="form-control" data-template="modal" data-minute-step="1" data-modal-backdrop="true" type="text"/>';	//Is it fitting by space??
						echo '</div></td>';
}
							echo "</tr>";
						}
					?>
					<tr><td></td><td colspan="3"><button type="button" id="time_add" onclick="addOnClick(nd,3,nt); nt+=3;">Időpontot hozzáad</button></td></tr>
					<tr><td></td><td colspan="3"><button type="button" id="time_insert" onclick="copyFirstRow(nd,nt)">Első sor másolása és beillesztése</button></td></tr> 
					<input type="hidden" name="nTime" value="<script>nt</script>"/>
							
				</table>
				<br/>
				<button type="button"class="btn btn-primary" onclick="window.location.replace('napok.php')">Előző</button>				
				<input type="submit" class="btn btn-primary" id="ment" value="Következő"/>
				
			</form>


	</body>
</html>	
