<?php
require_once 'connection.php';
$query="SELECT * FROM `users` WHERE serial=".$_POST['serial']." and number=".$_POST['numb'].";";
$link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
mysqli_set_charset($link,"utf8");
$result=mysqli_query($link,$query)or die("Ошибка запроса1".mysqli_error($link));
$idTics=split(' ',$_COOKIE['tickets']);
if (mysqli_num_rows($result)!=0)//Если такой пользователь уже есть
{
  $idUsr=mysqli_fetch_row($result);
  $query="UPDATE `tickets` SET `ocuppied`=1,`idUser`=".$idUsr[0]." WHERE";
  $query.=" id=".$idTics[0]." ";

  for ($i=1; $i < count($idTics)-1; $i++) {
    $query.=" or id=".$idTics[$i];
  }
}
else {//если пользователь новый
  $query="INSERT INTO `users`(`serial`, `number`, `typeUser`) VALUES (".$_POST['serial'].",".$_POST['numb'].",1);";
  $result=mysqli_query($link,$query)or die("Ошибка запроса2".mysqli_error($link));
  $query="SELECT `idUser`FROM `users`ORDER BY `users`.`idUser` DESC LIMIT 1 ";
  $result=mysqli_query($link,$query)or die("Ошибка запроса3".mysqli_error($link));
  $idUsr=mysqli_fetch_row($result);
  $query="UPDATE `tickets` SET `ocuppied`=1,`idUser`=".$idUsr[0]." WHERE";
  $query.=" id=".$idTics[0]." ";
  for ($i=1; $i < count($idTics)-1 ; $i++) {
    $query.=" or id=".$idTics[$i];
  }
}
$link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
mysqli_set_charset($link2,"utf8");
$result2=mysqli_query($link2,$query)or die("Ошибка запроса4".mysqli_error($link2));
$query="SELECT * FROM `tickets` WHERE `idUser`=".$idUsr[0].";";
$result2=mysqli_query($link2,$query)or die("Ошибка запроса5".mysqli_error($link2));

 ?>
<html>
<head>
<title>Main Window</title>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <LINK REL="stylesheet" HREF = "style.css">
  <LINK REL="stylesheet" HREF = "style_check_list.css">
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
  <div class="big_form">
    <form method='post' action='index.php']>
      Ваши билеты на данный рейс:
      <?php
        for ($i=0; $i <mysqli_num_rows($result2) ; $i++) {
          $row=mysqli_fetch_row($result2);
          echo "<p>".$row[0].$row[3].$row[2]."</p><br>";
        }
      ?>
      <input type='submit' value='Вернуться'>
    </form>
  </div>

</body>
</html>
