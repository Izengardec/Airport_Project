<?php
  require_once 'connection.php';
  $link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
  mysqli_set_charset($link,"utf8");
?>
<title>Main Window</title>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDcK1XpUdsDXdhA6YyY-sCHFNYypzVZmY&callback=initialize"></script>
  <LINK REL="stylesheet" HREF = "style.css">
  <LINK REL="stylesheet" HREF = "style_place.css">
  <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
</head>
<body>
  <div class="main_header">
    <div class="main_header_name">Sparta travel</div>
    <ul class='button_menu' style="text-align: left;">
      <li class="menu_buttons">Статистика</li>
      <li class="menu_buttons">Что-то</li>
      <li class="menu_buttons">3-ий пункт</li>
    </ul>
  </div>
  <div class="chooser_tic">
  <?php
    $query="SELECT * FROM `planescheme` WHERE NameOfPlane='".$_GET['plane']."'";
    echo "SELECT * FROM `planescheme` WHERE NameOfPlane='".$_GET['plane']."'";
    $result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
    $rows = mysqli_num_rows($result);
    echo "<div class='plane_scheme'>";
    for ($i = 0 ; $i < $rows ; ++$i)
      {
        $row = mysqli_fetch_row($result);
        echo "<div class='row_t'>";
        for ($j=0;$j<$row[2];$j++){
          echo "<div class='seat'></div>";
        }
        if ($row[3]!=0){
          echo "<div class='freespace'></div>";
          for ($j=0;$j<$row[3];$j++){
            echo "<div class='seat'></div>";
          }
          if ($row[4]!=0){
            echo "<div class='freespace'></div>";
            for ($j=0;$j<$row[4];$j++){
              echo "<div class='seat'></div>";
            }
        }
      }
        echo "</div>";
    }
    echo "</div>";
  ?>
    <div class='info'>
      <h2 align='center'>Информация о местах</h2>
    </div>
  </div>
  <?php
   ?>
</body>
</html>
