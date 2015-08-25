<!--Style-ban a formázást légyszíves!! Emellett a mysqli_array_sz_idopont($sz_id,$kapcsolat) körül problémák adódtak.-->

<!DOCTYPE html>
<html>
	<head>
		<title>Pseudo Doodle - Szavazás</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> <!-- This is responsible for the mobile friendliness -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

		<!-- Data-tables bootstrap plugin - CSS -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/jq-2.1.4,pdfmake-0.1.18,dt-1.10.8,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,fc-3.1.0,fh-3.0.0,sc-1.3.0/datatables.min.css"/>

		<!-- Data-tables bootstrap plugin - JavaScript -->
		<script type="text/javascript" src="https://cdn.datatables.net/r/bs/jq-2.1.4,pdfmake-0.1.18,dt-1.10.8,b-1.0.1,b-colvis-1.0.1,b-flash-1.0.1,b-html5-1.0.1,b-print-1.0.1,fc-3.1.0,fh-3.0.0,sc-1.3.0/datatables.min.js"></script>

		<!--
		<link rel="stylesheet" type="text/css" href="/bootstrap/dist/css/bootstrap.min.css">	
		<script type="text/javascript" src="/bootstrap/dist/js/bootstrap.js"></script>
		<script type="text/javascript" src="/bootstrap/dist/js/npm.js"></script>
		-->
		
		<style>
			table.table_title
			{
				padding:1px; float:right; color:gray;
			}
			h2.1
			{
				align:right
			}
			.img.yes
			{
				width:165px; height:165px; background:url("yn.jpg") 0 0;
			}
			.img.no
			{
				width:145px; height:165px; background:url("yn.jpg") -145px 0;
			}
		</style>
				
		<script type="text/javascript">

			function YNINBCheckAndPressed(i,j,eredmenym) 		//paraméter címszerint kell átadni talán, hogy bele tudjunk tenni dolgokat!!
			{   
				var bcgColorYes=0x3DDE14;
				var bcgColorINB=0xF8F818;
				var bcgColorNo=0xFE3838;
				
				for(var k=0;k<3;k++)
				{
					if (eredmenym[i*k]==1 && k==j)
						eredmenym[i*j]=0;
					else if (eredmenym[i*k]==1 && k!=j)
					{
						eredmenym[i*j]=1;
						eredmenym[i*k]=0;
					}
					else if (eredmenym[i*k]==0 && k==j)
						eredmenym[i*k]=0;
				}
				
				switch (j)
				{
					case 0: document.getElementById('yes.'+k+'.').style="backgroundcolor: bcgColorYes";
					case 1: document.getElementById('ifneedbe.'+k+'.').style="backgroundcolor: bcgColorINB";
					case 2: document.getElementById('no.'+k+'.').style="backgroundcolor: bcgColorNo";
				}
				
			}

			function changeCheckboxStlye(i)
			{
				document.getElementById(i).disabled='true';
			}

			function validateEmailAddr()
			{
				var x=document.forms["szavazas"]["sz_email"].value;
				if ( x=="" )
				{
					alert("Hiányos az űrlap! Töltsd ki a 'Email-cím' mezőt!");
					return false;
				}
				var atpos=x.indexOf("@");					//Doesn't work at the moment!
				var dotpos=x.lastIndexOf(".");
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
				{
					alert("Nem érvényes az emailcím!");
					return false;
				}
			}
			
			/************************************************************************
			/* Grafikusan a szép kép betétele a cellákba! CSS-sel.*/
			/* function loadYes(szid) 		/*Balról 165x165*/
			/* {  
			/*	var img=document.createElement("img");
			/*	var source=document.createAttribute("src");
			/*	source.value="alpha.png";
			/*	img.setAttributeNode(source);
			/*	var id=document.createAttribute("id");
			/*	id.value="img.yes";
			/*	img.setAttributeNode(id);
			/*	var element=document.getElementById("eredmeny.szid");  //reméljük felismeri a változót
			/*			element.appendChild(source);
			/*			element.appendChild(id);	
			/* }
			/*
			/* function loadNo(szid) 			/*Jobbról: 145x165*/
			/* {	
			/*	var img=document.createElement("img")
			/*	var source=document.createAttribute("src");
			/*	source.value="alpha.png";
			/*	img.setAttributeNode(source);
			/*	var id=document.createAttribute("id");
			/*	id.value="img.no";
			/*	img.setAttributeNode(id);
			/*	var element=document.getElementById("eredmeny.szid");  //reméljük felismeri a változót
			/*		element.appendChild(source);
			/*		element.appendChild(id);	
			/* }
			/*
			**************************************************************************/

			function deleteSure()
			{
				return confirm("Biztosan törlöd a szavazást?");
			}
			
		</script>

		<?php 
			/* Decoding the $sz_id var from URL */
			$sz_id=($_GET["szid"]+3)/2;
			
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
			
			global $kapcsolat;
			$kapcsolat=mysqli_connect($db_info["localhost"],$db_info["username"],$db_info["password"], $db_info["database_name"]);
			if(!$kapcsolat)
				die("Nem lehet kapcsolodni a MySQL kiszolgalohoz: ".mysqli_connect_error());
			
			/** 
			*	This function returns a return value of the query below -> i.e. all the contents of a table which refers to this poll.
			*	Since not only once I use this functionality, a function was to be created for it!
			**/
			function mysqli_array_sz_idopont($sz_id,$kapcsolat)
			{									
				$parancs="SELECT * FROM sz_idopont WHERE szavazas_id=".$sz_id." ORDER BY idopont_d, idopont_t";
				return mysqli_query($kapcsolat,$parancs);
			}
		
			$parancs="SELECT * FROM szavazas WHERE id=$sz_id";
			$array_szavazas=mysqli_query($kapcsolat,$parancs);
			$array_szavazas_fetched=mysqli_fetch_array($array_szavazas);
			
			if($array_szavazas_fetched==NULL)
			{ 
				echo "<script>document.write('A megadott szavazás hiányzik!');</script>"; 
				exit;
			}
			
			/*Beállítások MAKRÓkkal való életbeléptetése*/
			if(($array_szavazas_fetched['beallitasok']<<3)/8) define('YNINB',1);  
			(($array_szavazas_fetched['beallitasok']<<2)/8)?define('IP_TYPE','radio'):define('IP_TYPE','checkbox'); 
			if(($array_szavazas_fetched['beallitasok']<<1)/8) define('PERDATE',1);  
			if($array_szavazas_fetched['beallitasok']/8) define('EMAIL',1);

			//A COUNT lekérdezésekhez nem szükséges mysqli_fetch_array()-t használni
			$parancs="SELECT COUNT('id') FROM szavazo WHERE szavazasok_id=$sz_id";
			$db_szavazo=mysqli_query($kapcsolat,$parancs);
			
			/* Counting the number of dates in the to be form */
			$query="SELECT COUNT('idopont_d') FROM sz_idopont WHERE szavazas_id=$sz_id";
			$db_date_ertek_uf=mysqli_query($kapcsolat,$query);
			$db_date_ertek=mysqli_fetch_row($db_date_ertek_uf);
			
			/* Counting the number of time values in the to be form per date */
			$all_the_data=mysqli_array_sz_idopont($sz_id,$kapcsolat);				//Use this for creating the table header
			echo $all_the_data['idopont_d'];
			$db_t_acc a= new Array();
			$prev_date=-1;
			foreach(mysqli_fetch_assoc($all_the_data) as $row)
			{
				$j=0;
				if($prev_date==-1 || $prev_date==$row['idopont_d'])             //If it's a new date value or the value hasn't changed at all -> incr. $j
					$j++;
				else 
				{
					$db_t_acc[] = $j;				//Sets the next value of the accumulator
					$j=1;							//else if a new date value occurs first the counter is set to '1'
				}
				$prev_date=$row['idopont_d'];			//presets the $prev_date var. for the next turn in the loop
			}
			$db_t_acc[]= $j;				//Sets the last value of the accumulator
			
		?>

	</head>

	<body>
		<?php 
			$parancs="SELECT COUNT('idopont_d') FROM sz_idopont WHERE szavazasok_id=$sz_id";
			$db_idopont=mysqli_query($kapcsolat,$parancs);
			
			$inditas_datum=strtotime($array_szavazas_fetched["inditas_datum"]);
			$szavazas_kora_ts=time()-$inditas_datum;   //Timestamp kivonás
			$array_sk=getdate($szavazas_kora_ts);
			$timestamp=getdate(time()-$array_szavazas_fetched["inditas_datum"]);
			//define ('TESZT',1);
			if(defined('TESZT'))
			{
				echo $inditas_datum."           ";
				$t_y=$timestamp['year']-1970;
				echo $t_y." éve, ";
				echo $timestamp['mon'].". hónap, ";
				echo $timestamp['mday'].". nap, ";	
				echo $timestamp['hours']." óra, ";
				echo $timestamp['minutes']." perc ";
			}
		
		echo( '<h2 id="h2.1">'.$array_szavazas_fetched["cim"].'</h2><br>');
		
		?>
		
		<!-- Header-->
		<table class="table" id="table_title">  
		<tr>
			<td>kezdeményezte:......<b><?php echo $array_szavazas_fetched["nev"]?>    </b></td>			
			<td>résztvevők száma:...<?php if($db_szavazo)echo '<b>'.$db_szavazo.'</b>'; else echo '<b>0</b>';?></td>
			<td>amióta létezik:..... 
				<?php
					if($array_sk['year']!==0)
					{
						$ask=$array_sk['year']-1970;
						echo $ask." éve";
					}
					if($array_sk['mon']!==0)
					{
						$ask=$array_sk['mon']-1;
						echo ", ".$ask." hónapja";
					}
					if($array_sk['mday']!==0)
					{
						$ask=$array_sk['mday']-1;
						echo ", ".$ask." napja";	
					}
					if($array_sk['hours']!==0)
					{
						$ask=$array_sk['hours']-1;
						echo ", ".$ask." órája";
					}
					if($array_sk['minutes']!==0)
					{
						$ask=$array_sk['minutes']-1;
						echo ", ".$ask." perce";
					}
				?>
			</td>
		</tr>
		</table>

		<!-- Poll -->
		<br/><br/>
		<table class="table table-stripeds"border="1">
			<tr>
				<td></td>
				<td colspan="3"></td>
			</tr>
			
			<!-- Year and the name of the month written out -->
			<tr>
				<td></td>
				<?php
					$array_sz_idopont_peld=new Array();
					$array_sz_idopont_peld=mysqli_array_sz_idopont($sz_id,$kapcsolat);	//All included from sz_idopont table
					$date_ts=-1;
					$time_ts=-1;
	//				$j=0;
					foreach(mysqli_fetch_assoc($array_sz_idopont_peld) as $i)
					{
						/* Strtodate -> timestamp algebra -> gettime function */
						if($date_ts!=strtotime($i['idopont_d']) && $time_ts!=strtotime($i['idopont_t']))
						{
							$date_ts=strtotime($i['idopont_d']);
							$time_ts=strtotime($i['idopont_t']);
						}
						else
							continue;    //Intended to be a loop command
						
						$datetime_ts=$date_ts+$time_ts;
						$dyear=getdate($datetime_ts['year']);
						$dmonth=getdate($datetime_ts['month']);
						print "<td colspan='".$db_date_ertek[0]."'>".$dyear." ".$dmonth."</td>";
//						$j++;
					}
				
				function sz_idopontDTSCalculator($sz_id,$kapcsolat)
				{
					$array_sz_idopont_peld=mysqli_array_sz_idopont($sz_id,$kapcsolat);	//All included from sz_idopont table
					$date_ts=-1;
					$time_ts=-1;
					$datetime_ts=array();
					foreach(mysqli_fetch_assoc($array_sz_idopont_peld) as $i)
					{
						/* Strtodate -> timestamp algebra -> gettime function */
						if($date_ts!=strtotime($i['idopont_d']) && $time_ts!=strtotime($i['idopont_t']))
						{
							$date_ts=strtotime($i['idopont_d']);
							$time_ts=strtotime($i['idopont_t']);
						}
						else
							continue;    //Intended to be a loop command
						
						$datetime_ts[]=$date_ts+$time_ts;
					}
					$datetime_ts[]=0;			//If it isn't terminated with NULL.
					return $datetime_ts;        //Pointer is given back
				}
				
				/**
				*	$date string and $time string is given to this function.
				*	it calculates the timestamp of them and in the end the value of the two adde is returned
				**
				function genericDTStampCalculator($date,$time)
				{
					$date_ts=strtotime($date);
					$time_ts=strtotime($time);
					return $date_ts+$time_ts;
				}*/
				?>
			</tr>
			<!-- Days written out -->
			<tr>
				<td><?php print $db_szavazo;?></td>
				<?php
				$datetime_array=array();
				$datetime_array=sz_idopontDTSCalculator($sz_id,$kapcsolat);                       //As a pointer it is recieved
				
				for($i=0;$datetime_array[$i]!=NULL;$i++)
				{
					$sum=0;
					$k=0;
					if($i!=0)
					{
						while ($k==$i)
						{
							$sum+=$db_t_acc[$i]*$i;
						}
					}
					$date_ts=getdate($datetime_array[$sum]);
					print "<td class='th_day' colspan='$db_t_acc[$i]'>" . $date_ts['mday'] . "</td>";
				}
			echo "</tr>";
			/* Hours written out */
			echo "<tr>";
				for($i=0;$datetime_array[$i]!=NULL;$i++)
				{
					$date_ts=getdate($datetime_array[$i]);
					print "<td class='th_time'>" . $date_ts['hours'] . ":" . $date_ts['minutes'] . "</td>";		
				}
			?>
			</tr>
			<?php
				$parancs="
					SELECT valasztott_idopont.szavazas_id, valasztott_idopont.szavazo_id, valasztott_idopont.idopont_d, valasztott_idopont.idopont_t, szavazo.nev
					FROM valasztott_idopont
					LEFT JOIN szavazo
					ON szavazo.id=valasztott_idopont.szavazo_id";
				$result = mysqli_query($kapcsolat,$parancs);
				
				$szavazo_id=-1;			// Initializing with '-1' for the first person
				
				/* Here is the loading of the poll */
				
				/* Table header */
				print "<tr>";
					foreach(mysqli_fetch_array($result) as $row)  //Miért array type a $row
					{
						$row=mysqli_fetch_assoc($row);
						if($row['szavazas_id']!=$sz_id)                  //A kettőnek mindig egyeznie kell, mert így tudjuk az adott szavazás adatait elérni.
							continue;
						
						if($szavazo_id==-1)							//First person's name to be written out -> as none of the old are to be closed and none of the news are to be opened
							print "<td id='eredmeny.$szavazo_id'>" . $row['nev'] . "</td>";   
						if($row['szavazo_id']!=$szavazo_id)
						{
							$szavazo_id=$row['szavazo_id'];
							print "</tr><tr><td id='eredmeny.$szavazo_id'>" . $row['nev'] . "</td>";	//Új sor nyitása: ha változott a szavazo_id, akkor megváltozott a név is -> ezzel kezdem a sort
						}
						
						$flag=0;
						$array_sz_idopont_peld=mysqli_array_sz_idopont($sz_id,$kapcsolat);
						$aszid=mysqli_fetch_assoc($array_sz_idopont_peld);
						for($j=0;$aszid[$j]!=NULL;$j++)
							if($row['idopont_d']==$aszid[$j]['idopont_d'] &&
											$row['idopont_t']==$aszid[$j]['idopont_t'])
							{
								loadYes($szavazo_id);   						
								$flag=1;
							}
						if($flag==0)
							loadNo($szavazo_id);  
					}
			?>
			</tr>

			<form class="form-inline" id="szavazas"  action="koszonjuk.html" onsubmit="validateEmailAddr()" method="POST">
			<?php
				/*Form betöltése opciónként*/
					print "<tr>
						<td><input class='form-control' type='text' name='nev' value='Név'/></div></td>";
					/* A szavazás eredményének tárolására */
					$eredmenym= new Array('0','0','0',		
							      '0','0','0',
							      '0','0','0');
					
					/****
					*  YesNoIfNeedBe option esetén - 
					*  YNINBCheckAndPressed.apply(this, new Array ($i,0,$eredmenym));
					*	This should be done!
					****/
					if(defined("YNINB"))
					{		
						for($i=0;$i<3;$i++)
						{
							for($j=0;$j<$db_date_ertek;$j++)
							{
								$k=$i*$j;
								switch ($i)
								{
									case 0:	print "<td class='success'><a onclick='YNINBCheckAndPressed.apply(this, new Array ($i,0,$eredmenym))'>Yes</a><input type='hidden' value='$eredmenym[$k]' name='yes$j' id='yninb$i.$j.'></td/>"; break;			//'yes$j'
									case 1: print "<td class='warning'><a onclick='YNINBCheckAndPressed.apply(this, new Array ($i,1,$eredmenym))'>(Yes)</a><input type='hidden' value='$eredmenym[$k]' name='ifneedbe$j' id='yninb$i.$j.'/></td>"; break;    //'ifneedbe$j'
									case 2: print "<td class='danger'><a onclick='YNINBCheckAndPressed.apply(this, new Array ($i,2,$eredmenym))'>No</a><input type='hidden' value='$eredmenym[$k]' name='no$j' id='yninb$i.$j.'/></td>"; break; 			//'no$j'
								}
							}
						}
					}
					/*Milyen legyen az input type attribútuma: egyet lehessen kiválasztani, vagy többet is egy felhasználónak?*/
					else if(defined('IP_TYPE'))
					{
						for($i=0;$i<$db_date_ertek;$i++)
							print "<td><div class='inline-".IP_TYPE."><input type='".IP_TYPE."' name='$i' class='ch/rdb'/></div></td>";
					}
					
					else if (defined('PERDATE'))		//Minden szavazó az aktuális témához tartozó összes dátumát lekérdezi, és csak akkor enged felvenni új szavazatot, ha még nem szavaztak erre
					{	
						for($i=0;$i<$db_date_ertek;$i++)
							print "<td><div class='checkbox-inline'><input type='checkbox' name='$i' class='perdate_ch'/></td>";
						
						/* The two different query results, which are to be compared below */
						$result=mysqli_query($kapcsolat,"SELECT idopont_d, idopont_t 
														FROM valasztott_idopont WHERE szavazas_id=$sz_id ORDER BY idopont_d, idopont_t");
						$dates_existing=mysqli_array_sz_idopont($sz_id,$kapcsolat);
						
						$n=count($result);
						$valasztott_dates=array($n);
						$i=0;
						foreach($dates_existing as $exists)
						{
							$exists=mysqli_fetch_assoc($exists);
							foreach($result as $chosen)
							{
								$chosen=mysqli_fetch_assoc($chosen);
								if($dates_existing['idopont_d']==$chosen['idopont_d'] && $dates_existing['idopont_t']==$chosen['idopont_t'])
								{
									/* Nem választhatják kétszer ua.-t a dátumot */
									changeCheckboxStyle($i);  
									// Létezők közül melyik került át a választott táblába -> $i.-ikhez tartozó Checkbox disabled-dé tétele!
									$valasztott_dates[$i]=1;
								}
								else $valasztott_dates[$i]=0;
							}
							$i++;
						}
					}
					print "</tr>";
					
					/*A legvégére egy emailcím megadását kéri, amennyiben a szavazásban ezt kérik*/
					if(defined('EMAIL'))
					{ 
						print "<tr><td><input type='text' class='form-control' id='sz_email' name='sz_email'/></td>";
					}
			?>
			</tr>
			
			<tr>
				<td></td>
				<?php
				
					/*Összeszámolja, hogy a választott dátumokból mennyi van!*/
					$counted_chosen_d=mysqli_query($kapcsolat,"SELECT COUNT	(DISTINCT idopont_id) 
																FROM valasztott_idopont WHERE valasztott_idopont.szavazas_id=$sz_id 
																ORDER BY idopont_d, idopont_t" ); 								
					
					/*Ha választotta valaki a megfelelő dátumot, akkor kiírja mennyien tették meg ezt, ha pedig nem, 0-t ír be a cellába*/
					for($i=0;$i<$db_idopont;$i++)
					{
						if($valasztott_dates[$i])			   //Miért nem $counted_chosen_d ????
						{
							$dates_sum=mysqli_fetch_field($counted_chosen_d);			 	//One filed per row!
							print "<td>".$dates_sum."</td>";
						}
						else if(!$valasztott_dates[$i])
							print "<td>0</td>";
					}
				?>
			</tr>
		</table>

				<input type="hidden" name="sz_id" value="<?php print $sz_id ?>"/>
				<br/><input type="submit" class="btn btn-primary" id="mentes" value="Mentés"/>
			</form>

		<form id='delete' action='deleted.php' method="GET">
			<input type="hidden" name="nev_deleted" value="<?php $array_fetched=mysqli_fetch_assoc($array_szavazas); print ($array_fetched['nev']); ?>"/>
			<input type="hidden" name="szavazas_id" value="<?php print ($sz_id*2-3); ?>"/>    <!-- Which $szid used? -->
			<button class="btn btn-warning" onclick="deleteSure()">Törlöm a szavazást</button>
		</form>
		<?php
			mysqli_close($kapcsolat);
		?>

	</body>
</html>
