<?php
$err='';
session_start();
setcookie("tickets","",time()-3600,"/");
setcookie("nowId","",time()-3600,"/");
$_SESSION['city'] = "Сингапур";
if(isset($_POST['submit'])){
	if ($_POST['input_of_from']!='' and $_POST['input_of_where']!='' and $_POST['calendarfrom']!=''){
		setcookie('latlanghome',$_POST['latit']);
		setcookie('latlangwhere',$_POST['lang']);
		setcookie('datehome',$_POST['calendarfrom']);
		header("Location:choose_Tickets.php");
	}
}
?>
		<title>Main Window</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDcK1XpUdsDXdhA6YyY-sCHFNYypzVZmY&callback=initialize"></script>
		<LINK REL="stylesheet" HREF = "style.css">
		<link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
	<body>
		<div class="main_header">
			<a class="main_header_name" href="index.php">Sparta travel</a>
		</div>
		<form method="POST" id='itsForm'>
			<div class="main_desition">
				Откуда:
				<input class="input_of_from" name="input_of_from" id="input_of_from" placeholder="Откуда вы" title="Выберите место на карте" required onkeypress="return false;" autocomplete="off"></input>
			</div>
			<div class="main_desition">
				Куда:
				<input class="input_of_from" name="input_of_where" id="input_of_where" placeholder="Куда вы" title="Выберите место на карте" required onkeypress="return false;" autocomplete="off"></input>
				Туда:
				<input type="date" name="calendarfrom" class="dateCl" required>
				<input type="submit" name="submit" value="Найти аэропорт" class="btn_from">
			</div>
			<div id="map-canvas"></div>
			<input type="text" class="invis" id="latit" name="latit">
			<input type="text" class="invis" id="lang" name="lang">
		</form>
		<script src="script.js">
		</script>
	</body>
</html>
