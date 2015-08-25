<!DOCTYPE>
<html>
	<head>
		<title>Pseudo Doodle - Általános</title>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
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
		<script type="text/javascript">
			function validateFormController(id){
				var x=document.forms["alForm"][id].value;
				if ( x=="" )
				{
					$("#"+id).parent().parent().setAttribute("class","form-group has-warning");
					return false;
				}
			}

				function validateEmailAddress(){
				var x=document.forms["alForm"]["email"].value;

				var atpos=x.indexOf("@");					
				var dotpos=x.lastIndexOf(".");
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
				{
					$("#email").parent().parent().attr("class","form-group has-alert has-feedback");
					return false;
				}
				/* Only numbers, English characters and '.' is accepted in email addresses */	
				for(var i=0;i<x.length;i++)
					if(					// => if((<'0' || >'9') && (<'a' || >'z') && !='.' && !='@')
					(x.charCodeAt(i)<48 || x.charCodeAt(i)>57) && (x.charCodeAt(i)<97 || x.charCodeAt(i)>122) && x.charCodeAt(i)!=46 && x.charCodeAt(i)!=64)
					{
						alert("Nem érvényes az emailcím!");
						return false;
					}
			}
			
			function charLimit(event){
				var x=event.currentTarget;
				if(x.value.length>=256)
					alert("Kérlek rövidítsd le a leírást a megadott hosszúságra!");		
			}
	
		</script>
	</head>

	<body>
		<h2>Esemény ütemezése</h2>
		<br/>
		<form id="alForm" name="alForm" action="napok.php" method="POST">
			<div class="form-group">
				<label for="cim">Szavazás címe</label>
				<div class="col-xs-4">
					<input type="text" class="form-control" id="cim" name="cim" onblur="validateFormController($(this).attr('id'))" placeholder="Cím"/>
				</div>
			</div>
			<div class="form-group">
				<label for="nev">Szavazást indító neve</label>
				<div class="col-xs-4">
					<input type="text" class="form-control" id="nev" name="nev" onblur="validateFormController($(this).attr('id'))"placeholder="Név"/>
				</div>
			</div>
			<div class="form-group">
				<label for="email">Szavazást indító email címe</label>
				<div class="col-xs-4">
					<input type="text" onblur="return validateForm()" class="form-control" id="email" name="email" onblur="validateFormController($(this).attr('id'))" placeholder="A Te emailcímed"/>
				</div>
			</div>
			<div class="form-group">
				<label for="hely">Hely <span class="option">(opcionális)</span></label>
				<div class="col-xs-4">
					<input type="text" class="form-control" id="hely" name="hely" placeholder="Esemény helye"/>
				</div>
			</div>
			<div class="form-group">
				<label for="leiras">Esemény leírása <span class="option">(opcionális, max. 255 karakter)</span></label>
				<div class="col-xs-5">
					<textarea class="form-control" id="leiras" name="leiras" rows="3" placeholder="Írd le miben fog állni az esemény!"></textarea>	<!--Does the maxlength peoperty work right?-->
				</div>
			</div>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<input type="submit" class="btn btn-primary close" data-dismiss="alert" onmousedown="validateEmailAddress()" aria-label="Close" id="ment" value="Következő"/> 
		</form>
		<!--Ide be lehetne tenni egy footert-->
	<br/>
	<br/>
	<?php
		echo( password_hash("root"));
	?>
	</body>
</html>	
