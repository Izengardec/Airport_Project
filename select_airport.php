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
		<LINK REL="stylesheet" HREF = "style_airport_varians.css">
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
		<div class='main_form0'>
			<div class='main_form'>
				<?php
				echo "<div class='firsttablo' id='firsttablo'>";
					for ($i=0;$i<count($nameairport);$i++){
							echo "<div class=\"variant_airport_left\" id='variant_airport1_".$i."'>
									<h1>&nbsp".$nameairport[$i]."</h1>
									<h3>Адрес:&nbsp".$info[$i]."</h3>
									<h5>".$array[$i]." КМ до аэропорта</h5>
									</div>
									<script>
									document.getElementById('variant_airport1_".$i."').addEventListener('click',function(){
									var elements =document.getElementById('firsttablo').getElementsByClassName('variant_airport_select');
									if (elements.length!=0){
										elements[0].className='variant_airport_left';
									}
									document.getElementById('variant_airport1_".$i."').classList.add('variant_airport_select');});
									</script>";
					}
				echo "</div>";
				echo "<div class='secondtablo' id='secondtablo'>";
					for ($i=0;$i<count($nameairport2);$i++){
							echo "<div class=\"variant_airport_right\" id='variant_airport2_".$i."'>
									<h1>&nbsp".$nameairport2[$i]."</h1>
									<h3>Адрес:&nbsp".$info2[$i]."</h3>
									<h5>".$array2[$i]." КМ до аэропорта</h5>
									</div>
									<script>
									document.getElementById('variant_airport2_".$i."').addEventListener('click',function(){
									var elements =document.getElementById('secondtablo').getElementsByClassName('variant_airport_select');
									if (elements.length!=0){
										elements[0].className='variant_airport_right';
									}
									document.getElementById('variant_airport2_".$i."').classList.add('variant_airport_select');});
									</script>";
					}
				echo "</div>";
					mysqli_close($link);
				?>
			</div>
			</div>
			<script>
			</script>
		</body>