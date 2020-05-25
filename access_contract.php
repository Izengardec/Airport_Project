<html>
<head>
<title>Main Window</title>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <LINK REL="stylesheet" HREF = "style.css">
  <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
</head>
<body>
  <?php
    $placesTmp = split(' ',$_POST['now_tickets']);
    $places=array();
    $query=
    for ($i=0;$i<count($placesTmp);$i++){
      if (strlen($placesTmp[$i])>1){
        $places= $placesTmp[$i];
      }
    }
    unset($placesTmp);
  ?>
  <div class="main_header">
    <div class="main_header_name">Sparta travel</div>
    <ul class='button_menu' style="text-align: left;">
      <li class="menu_buttons">Статистика</li>
      <li class="menu_buttons">Что-то</li>
      <li class="menu_buttons">3-ий пункт</li>
    </ul>
  </div>
  <div>

  </div>
</body>
</html>
