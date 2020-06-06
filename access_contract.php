<?php
  $placesTmp = split(' ',$_POST['now_tickets']);
  $places=array();

  $send_it="";//хранит id выбранных билетов
  $query="SELECT * FROM `tickets` WHERE ";
  $query2="SELECT SUM(`cost`) FROM `tickets` WHERE";
  for ($i=0;$i<count($placesTmp);$i++){//отсекаем пробелы которые могли прийти с прошлой формы
    if (strlen($placesTmp[$i])>1){
      $places[]= $placesTmp[$i];
    }
  }
  for ($i=0;$i<count($places);$i++){
    $tmp= split('_',$places[$i]);
    if ($i!=count($places)-1){
      $query2.=" col='".$tmp[0]."' and row=".$tmp[1]." or ";
      $query.=" col='".$tmp[0]."' and row=".$tmp[1]." or ";
    }else {
      $query2.=" col='".$tmp[0]."' and row=".$tmp[1]."";
      $query.=" col='".$tmp[0]."' and row=".$tmp[1]."";
    }
  }
  $query.=" AND idFlight =".$_COOKIE['nowId'].";";
  $query2.=" AND idFlight =".$_COOKIE['nowId'].";";
  require_once 'connection.php';
  $link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
  mysqli_set_charset($link,"utf8");
  $result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
  $link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link2));
  mysqli_set_charset($link2,"utf8");
  $result2=mysqli_query($link2,$query2)or die("Ошибка запроса".mysqli_error($link2));
  $sum_tick=mysqli_fetch_row($result2);
  for ($i=0; $i < mysqli_num_rows($result); $i++) {
    $row=mysqli_fetch_row($result);
    $send_it.=$row[0]." ";
  }
  setcookie("tickets",$send_it);
  mysqli_data_seek($result,0);
?>
<title>Main Window</title>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <LINK REL="stylesheet" HREF = "style.css">
  <LINK REL="stylesheet" HREF = "access_style.css">
  <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
</head>
<body>

  <div class="main_header">
    <div class="main_header_name">Sparta travel</div>
    <ul class='button_menu' style="text-align: left;">
      <li class="menu_buttons">Статистика</li>
      <li class="menu_buttons">Что-то</li>
      <li class="menu_buttons">3-ий пункт</li>
      <li class="menu_buttons">Авторизация</li>
    </ul>
  </div>
  <div class="place_form">
    <div style="width: 50%;display: inline-grid;">
    <?php
    echo "<p class=''>Заказ на сумму: ".$sum_tick[0]."руб.</p>";
    for ($i=0; $i < mysqli_num_rows($result); $i++) {
      $row=mysqli_fetch_row($result);
      echo "<p class=''>Билет ".$row[0]." ".$row[3]." ".$row[2]." ".$row[4]." руб.</p>";
    }
    echo $send_it;

    echo "</div>";?>

    <form class="form_class" method="post" action="check_List.php">
      <p align='center'>Данные</p>
      <div id='serial_par' class='sel'>
        <input type="text" id='serial' name='serial' class='input_place' placeholder="Серия паспорта" pattern="[0-9]{4}" title='Серия паспорта должен содержать 4 цифры.' maxlength="4" required>
      </div>
      <div id='numb_par' class='sel'>
        <input type="text" id='numb' name='numb' class='input_place' placeholder="Номер паспорта" pattern="[0-9]{6}" title='Код паспорта должен содержать 6 цифр.' maxlength="6" required>
      </div>
      <div id='code_card_par' class='sel'>
        <input type="text" id='code_card' class='input_place' placeholder="Код карты" pattern="[0-9]{16}" title='Код карты должен содержать 16 цифр.' maxlength="16" required>
      </div>
      <div id='CVC_par' class='sel'>
        <input type="text" id='CVC' class='input_place' placeholder="CVC" pattern="[0-9]{3}" title='CVC должен содержать 3 цифры.' maxlength="3" required>
      </div>
      <div id='month_par' class='sel'>
        <input type="text" id='month' class='input_place' placeholder="Месяц" pattern="[0-1][0-9]" title='Всего 12 месяцев в году.' maxlength="2" required>
      </div>
      <div id='year_par' class='sel'>
        <input type="text" id='year' class='input_place' placeholder="Год" pattern="[0-9]{2}" title='Нужно ввести 2 последние цифры года.' maxlength="2" required>
      </div>
      <input type='submit' id='finish_btn' lign='center' class='finish_btn' value="Подтвердить заказ">
    </form>
  </div>
  <script>
  function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}
    var finish_btn=document.getElementById('finish_btn');
    finish_btn.addEventListener('click',function(){
      var ar=document.getElementsByClassName('input_place');
      for (var i = 0; i < ar.length; i++) {
        if (document.getElementById(ar[i].id+'_par').getElementsByTagName('span').length!=0){
        document.getElementById(ar[i].id+'_par').removeChild(document.getElementById(ar[i].id+'_par').lastChild);
      }
        console.log(ar.length);
        if (ar[i].value==""){
          if (document.getElementById(ar[i].id+'_par').getElementsByTagName('span').length!=0){
          document.getElementById(ar[i].id+'_par').removeChild(document.getElementById(ar[i].id+'_par').lastChild);
        }
          var span = document.createElement('span');
          span.innerHTML = 'Поле не заполнено';
          span.className = 'mistake';
          insertAfter(span, ar[i]);
        } else if (ar[i].value.length!=ar[i].maxLength) {
          if (document.getElementById(ar[i].id+'_par').getElementsByTagName('span').length!=0){
          document.getElementById(ar[i].id+'_par').removeChild(document.getElementById(ar[i].id+'_par').lastChild);
        }
          var span = document.createElement('span');
          span.innerHTML = 'В поле должно быть '+ar[i].maxLength+' символов';
          span.className = 'mistake';
          insertAfter(span, ar[i]);
        }


      }


     });
  </script>
    <?php
      mysqli_close($link);
    ?>
</body>

</html>
