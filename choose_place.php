<?php
  require_once 'connection.php';
  $link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
  mysqli_set_charset($link,"utf8");
  $link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link2));
  mysqli_set_charset($link2,"utf8");
  $name_col= array('A','B','C','D','E','F','G','H','K','L');
  $query="SELECT * FROM `planes` WHERE NameOfPlane='".$_GET['plane']."'";
  $result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
  $row = mysqli_fetch_row($result);
  $max_Col= array($row[1],$row[2],$row[3]);
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
    $query="SELECT * FROM `planescheme` WHERE NameOfPlane='".$_GET['plane']."' ORDER BY numRow";
    $result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
    $rows = mysqli_num_rows($result);
    echo "<div class='plane_scheme'>";
    for ($i = 0 ; $i < $rows ; ++$i)
      {
        $row = mysqli_fetch_row($result);
        echo "<div class='row_t'>";
        $query2="SELECT `id`, `row`, `col`, `cost`, `type`, `NameTicket`, `Discribtion`, `ocuppied` FROM `tickets`,`ttypeoftickets` WHERE row=".($i+1)." and type=idType and idFlight=".$_GET['id']." ORDER BY `tickets`.`col` ASC";
        $result2=mysqli_query($link2,$query2)or die("Ошибка запроса".mysqli_error($link2));
        for ($j=0;$j<$row[2];$j++){
          $row2 = mysqli_fetch_row($result2);
          if ($row2[7]==0){
            if ($row2[4]==1){
              echo "<div class='seat' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
              echo "<script>
                document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                  if (this.className!='occupied'){
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(".$row2[3].")+Number(arr[1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+arr[1]+' руб.'
                    this.className='my_place';
                    var elem = document.createElement('p');
                    elem.id=this.id+'_place';
                    elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                    document.getElementById('info').appendChild(elem);
                }
              });</script>";
        } else if ($row2[4]==2){
            echo "<div class='business' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
            echo "<script>
              document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                if (this.className!='occupied'){
                  var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                  arr[1] = Number(".$row2[3].")+Number(arr[1]);
                  document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                  this.className='my_place';
                  var elem = document.createElement('p');
                  elem.id=this.id+'_place';
                  elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                  document.getElementById('info').appendChild(elem);
              }
            });</script>";
        } else if ($row2[4]==3){
            echo "<div class='first_class' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
            echo "<script>
              document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                if (this.className!='occupied'){
                  var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                  arr[1] = Number(".$row2[3].")+Number(arr[1]);
                  document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                  this.className='my_place';
                  var elem = document.createElement('p');
                  elem.id=this.id+'_place';
                  elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                  document.getElementById('info').appendChild(elem);
              }
            });</script>";
      }
    } else {
      echo "<div class='occupied' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
    }
        }

        if($row[2]<$max_Col[0]){
          for ($j=$row[2];$j<$max_Col[0];$j++){
            echo "<div class='freespace'></div>";
          }
        }

        if ($row[3]!=0){
          echo "<div class='freespace'></div>";
          for ($j=0;$j<$row[3];$j++){
            $row2 = mysqli_fetch_row($result2);
            if ($row2[7]==0){
              if ($row2[4]==1){
                echo "<div class='seat' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
                echo "<script>
                  document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                    if (this.className!='occupied'){
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(".$row2[3].")+Number(arr[1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                      this.className='my_place';
                      var elem = document.createElement('p');
                      elem.id=this.id+'_place';
                      elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                      document.getElementById('info').appendChild(elem);
                  }
                });</script>";
          } else if ($row2[4]==2){
              echo "<div class='business' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
              echo "<script>
                document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                  if (this.className!='occupied'){
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(".$row2[3].")+Number(arr[1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                    this.className='my_place';
                    var elem = document.createElement('p');
                    elem.id=this.id+'_place';
                    elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                    document.getElementById('info').appendChild(elem);
                }
              });</script>";
          } else if ($row2[4]==3){
              echo "<div class='first_class' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
              echo "<script>
                document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                  if (this.className!='occupied'){
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(".$row2[3].")+Number(arr[1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                    this.className='my_place';
                    var elem = document.createElement('p');
                    elem.id=this.id+'_place';
                    elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                    document.getElementById('info').appendChild(elem);
                }
              });</script>";
        }
      } else {
        echo "<div class='occupied' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
      }
          }

          if($row[3]<$max_Col[1]){
            for ($j=$row[3];$j<$max_Col[1];$j++){
              echo "<div class='freespace'></div>";
            }
          }

          if ($row[4]!=0){
            echo "<div class='freespace'></div>";
            if($row[4]<$max_Col[2]){
              for ($j=$row[4];$j<$max_Col[2];$j++){
                echo "<div class='freespace'></div>";
              }
            }
            for ($j=0;$j<$row[4];$j++){
              $row2 = mysqli_fetch_row($result2);
              if ($row2[7]==0){
                if ($row2[4]==1){
                  echo "<div class='seat' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
                  echo "<script>
                    document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                      if (this.className!='occupied'){
                        var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                        arr[1] = Number(".$row2[3].")+Number(arr[1]);
                        document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                        this.className='my_place';
                        var elem = document.createElement('p');
                        elem.id=this.id+'_place';
                        elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                        document.getElementById('info').appendChild(elem);
                    }
                  });</script>";
            } else if ($row2[4]==2){
                echo "<div class='business' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
                echo "<script>
                  document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                    if (this.className!='occupied'){
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(".$row2[3].")+Number(arr[1]);
                      var a=1+1;
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                      this.className='my_place';
                      var elem = document.createElement('p');
                      elem.id=this.id+'_place';
                      elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                      document.getElementById('info').appendChild(elem);
                  }
                });</script>";
            } else if ($row2[4]==3){
                echo "<div class='first_class' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
                echo "<script>
                  document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                    if (this.className!='occupied'){
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(".$row2[3].")+Number(arr[1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.'
                      this.className='my_place';
                      var elem = document.createElement('p');
                      elem.id=this.id+'_place';
                      elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."';
                      document.getElementById('info').appendChild(elem);
                  }
                });</script>";
          }
        } else {
          echo "<div class='occupied' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
        }
            }



        }
      }
        echo "</div>";
    }
    echo "</div>";
  ?>
    <div class='info' id ='info'>
      <h2 align='center'>Выбранные билеты</h2>
      <div id ='sum_tickets'>Итого: 0 руб.<div>
    </div>
  </div>
  <?php
   ?>
</body>
</html>
