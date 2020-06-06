	<?php
	require_once 'connection.php';
	$link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
	mysqli_set_charset($link,"utf8");
	$query="SELECT * FROM `airports`";
	$result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
	function calc_dist($lath1,$lan1,$lath2,$lan2){
	$EARTH_RADIUS=6372795;
	$lat1 = $lath1 * M_PI / 180;
	$lat2 = $lath2 * M_PI / 180;
	$long1 = $lan1 * M_PI / 180;
	$long2 = $lan2 * M_PI / 180;

	// косинусы и синусы широт и разницы долгот
	$cl1 = cos($lat1);
	$cl2 = cos($lat2);
	$sl1 = sin($lat1);
	$sl2 = sin($lat2);
	$delta = $long2 - $long1;
	$cdelta = cos($delta);
	$sdelta = sin($delta);

	// вычисления длины большого круга
	$y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
	$x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;
	$ad = atan2($y, $x);
	$dist = $ad * $EARTH_RADIUS;
	return $dist;
	}
	$homeLath=0;
	$homelang=0;
	$tmps=explode(" ", $_COOKIE['latlanghome']);
	$tmps2=explode(" ", $_COOKIE['latlangwhere']);

	$homeLath=(float)$tmps[0];
	$homelang=(float)$tmps[1];

	$whereLath=(float)$tmps2[0];
	$wherelang=(float)$tmps2[1];

	$big_nameairport;
	$big_nameairport2;

	$minco=500000;
	$array = array();
	$nameairport=array();
	$info= array();
	$array2 = array();
	$nameairport2=array();
	$info2= array();

	if($result)
	{
		$rows = mysqli_num_rows($result);
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			$row = mysqli_fetch_row($result);
			$tmpDoub=calc_dist($homeLath,$homelang,$row[4],$row[5]);
			if ($tmpDoub<$minco){
				$info[]=$row[6];
				$big_nameairport.="'".$row[2]."',";
				$nameairport[]=$row[2];
				$tmpDoub/=1000;
			$tmpDoub *= 100;
			if ($tmpDoub >= 0)
				$tmpDoub = floor($tmpDoub);
			else
				$tmpDoub = ceil($tmpDoub);
			$tmpDoub /= 100;
			$array[]=$tmpDoub;
			}
			$tmpDoub=calc_dist($whereLath,$wherelang,$row[4],$row[5]);
			if ($tmpDoub<$minco){
				$info2[]=$row[6];
				$big_nameairport2.="'".$row[2]."',";
				$nameairport2[]=$row[2];
				$tmpDoub/=1000;
			$tmpDoub *= 100;
			if ($tmpDoub >= 0)
				$tmpDoub = floor($tmpDoub);
			else
				$tmpDoub = ceil($tmpDoub);
			$tmpDoub /= 100;
			$array2[]=$tmpDoub;
			}
		}
		while (count($array)==0){
			$minco+=200000;
			mysqli_data_seek($result,0);
			$rows = mysqli_num_rows($result);
				for ($i = 0 ; $i < $rows ; ++$i)
				{
					$row = mysqli_fetch_row($result);
					$tmpDoub=calc_dist($homeLath,$homelang,$row[4],$row[5]);
						if ($tmpDoub<$minco){
							$info[]=$row[6];
							$big_nameairport.="'".$row[2]."',";
							$nameairport[]=$row[2];
							$tmpDoub/=1000;
						$tmpDoub *= 100;
						if ($tmpDoub >= 0)
							$tmpDoub = floor($tmpDoub);
						else
							$tmpDoub = ceil($tmpDoub);
						$tmpDoub /= 100;
						$array[]=$tmpDoub;
						}
				}
		}
		$minco=500000;
		while (count($array2)==0){
			$minco+=200000;
			mysqli_data_seek($result,0);
			$rows = mysqli_num_rows($result);
				for ($i = 0 ; $i < $rows ; ++$i)
				{
					$row = mysqli_fetch_row($result);
					$tmpDoub=calc_dist($whereLath,$wherelang,$row[4],$row[5]);
					if ($tmpDoub<$minco){
						$info2[]=$row[6];
						$big_nameairport2.="'".$row[2]."',";
						$nameairport2[]=$row[2];
						$tmpDoub/=1000;
					$tmpDoub *= 100;
					if ($tmpDoub >= 0)
						$tmpDoub = floor($tmpDoub);
					else
						$tmpDoub = ceil($tmpDoub);
					$tmpDoub /= 100;
					$array2[]=$tmpDoub;
					}
			}
		}
		$minco=500000;
	}
	?>
	<title>Main Window</title>
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDcK1XpUdsDXdhA6YyY-sCHFNYypzVZmY&callback=initialize"></script>
		<LINK REL="stylesheet" HREF = "style.css">
		<LINK REL="stylesheet" HREF = "style_for_tickets.css">
		<link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
	<body>
		<div class="main_header">
			<div class="main_header_name">Sparta travel</div>
			<ul class='button_menu' style="text-align: left;">
				<li class="menu_buttons">Статистика</li>
				<li class="menu_buttons">Что-то</li>
				<li class="menu_buttons">3-ий пункт</li>
			</ul>
		</div>
		<?php
		$big_nameairport=substr($big_nameairport,0,-1);
		$big_nameairport2=substr($big_nameairport2,0,-1);
		$query="SELECT * FROM `flights` WHERE airportFrom in (SELECT CodeAirport FROM `airports` WHERE Name IN (".$big_nameairport.")) and airportWhere in (SELECT CodeAirport FROM `airports`  WHERE Name IN (".$big_nameairport2.")) AND DateDeparture>='".$_COOKIE['datehome']." 00:00:00' AND DateDeparture<='".$_COOKIE['datehome']." 23:59:59'";
		$result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
			if(mysqli_num_rows($result)!=0)
				{
				$rows = mysqli_num_rows($result);
				echo "<div class='big_tickets_div'>";
				for ($i = 0 ; $i < $rows ; ++$i)
					{
						$row = mysqli_fetch_row($result);
						echo "<div class='variant_tickets' id='btn_".($row[0])."'>"."<img class='img_airlines' align='top' src=\"images\\".$row[4].".png\" alt=\"Картинка отсутствует\" /><p class='text_about_ticket'>".$row[1]." - ".$row[2]."<br>Дата отправки: ".$row[3]."</p></div>
						<script>
							document.getElementById('btn_".$row[0]."').addEventListener('click',function(){
								location.href = \"http://airport/choose_place.php?id=".$row[0]."&plane=".$row[5]."\";
							});
						</script>";
				}
				}
				echo "</div>";
				mysqli_close($link);
		?>

		</body>
		</html>
