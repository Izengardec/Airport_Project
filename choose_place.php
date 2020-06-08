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

    $query="SELECT * FROM `planescheme` WHERE NameOfPlane='".$_GET['plane']."' ORDER BY numRow";
    setcookie("nowId",$_GET['id']);
    $result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
?>
<title>Main Window</title>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <LINK REL="stylesheet" HREF = "style.css">
  <LINK REL="stylesheet" HREF = "style_place.css">
  <link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
</head>
<body onload="loadPage()">
  <div class="main_header">
    <div class="main_header_name">Sparta travel</div>
  </div>
  <div class="chooser_tic">
  <?php
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
                  if (this.className!='occupied' && this.className!='my_place'){
                    document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(".$row2[3].")+Number(arr[1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+arr[1]+' руб.'
                    this.className='my_place';
                    var elem = document.createElement('p');
                    elem.id=this.id+'_place';
                    elem.className='choosing_place';
                    elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                    document.getElementById('info').appendChild(elem);
                    document.getElementById(elem.id).addEventListener('click',function(){
                      document.getElementById('".$row2[2]."_".$row2[1]."').className='seat';
                      document.getElementById('info').removeChild(document.getElementById(elem.id));
                      var str=document.getElementById('now_tickets').value.split(' ');
                      var tmpStr='';
                      for (var i=0;i<str.length;i++){
                        if (str[i]!='".$row2[2]."_".$row2[1]."'){
                          tmpStr+=str[i];
                        }
                      }
                      document.getElementById('now_tickets').value=tmpStr;
                      str=this.innerHTML.split(' ');
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(arr[1])-Number(str[str.length-1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                    });
                }
              });</script>";
        } else if ($row2[4]==2){
            echo "<div class='business' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
            echo "<script>
              document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                if (this.className!='occupied' && this.className!='my_place'){
                  document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                  var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                  arr[1] = Number(".$row2[3].")+Number(arr[1]);
                  document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                  this.className='my_place';
                  var elem = document.createElement('p');
                  elem.id=this.id+'_place';
                  elem.className='choosing_place';
                  elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                  document.getElementById('info').appendChild(elem);
                  document.getElementById(elem.id).addEventListener('click',function(){
                    document.getElementById('".$row2[2]."_".$row2[1]."').className='business';
                    document.getElementById('info').removeChild(document.getElementById(elem.id));
                    var str=document.getElementById('now_tickets').value.split(' ');
                    var tmpStr='';
                    for (var i=0;i<str.length;i++){
                      if (str[i]!='".$row2[2]."_".$row2[1]."')
                        tmpStr+=str[i]+' ';
                    }
                    document.getElementById('now_tickets').value=tmpStr;
                    str=this.innerHTML.split(' ');
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(arr[1])-Number(str[str.length-1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                  });
              }
            });</script>";
        } else if ($row2[4]==3){
            echo "<div class='first_class' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
            echo "<script>
              document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                if (this.className!='occupied' && this.className!='my_place'){
                  document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                  var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                  arr[1] = Number(".$row2[3].")+Number(arr[1]);
                  document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                  this.className='my_place';
                  var elem = document.createElement('p');
                  elem.id=this.id+'_place';
                  elem.className='choosing_place';
                  elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                  document.getElementById('info').appendChild(elem);
                  document.getElementById(elem.id).addEventListener('click',function(){
                    document.getElementById('".$row2[2]."_".$row2[1]."').className='first_class';
                    document.getElementById('info').removeChild(document.getElementById(elem.id));
                    var str=document.getElementById('now_tickets').value.split(' ');
                    var tmpStr='';
                    for (var i=0;i<str.length;i++){
                      if (str[i]!='".$row2[2]."_".$row2[1]."')
                        tmpStr+=str[i]+' ';
                    }
                    document.getElementById('now_tickets').value=tmpStr;
                    str=this.innerHTML.split(' ');
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(arr[1])-Number(str[str.length-1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                  });
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
                    if (this.className!='occupied' && this.className!='my_place'){
                      document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(".$row2[3].")+Number(arr[1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                      this.className='my_place';
                      var elem = document.createElement('p');
                      elem.id=this.id+'_place';
                      elem.className='choosing_place';
                      elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                      document.getElementById('info').appendChild(elem);
                      document.getElementById(elem.id).addEventListener('click',function(){
                        document.getElementById('".$row2[2]."_".$row2[1]."').className='seat';
                        document.getElementById('info').removeChild(document.getElementById(elem.id));
                        var str=document.getElementById('now_tickets').value.split(' ');
                        var tmpStr='';
                        for (var i=0;i<str.length;i++){
                          if (str[i]!='".$row2[2]."_".$row2[1]."')
                            tmpStr+=str[i]+' ';
                        }
                        document.getElementById('now_tickets').value=tmpStr;
                        str=this.innerHTML.split(' ');
                        var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                        arr[1] = Number(arr[1])-Number(str[str.length-1]);
                        document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                      });
                  }
                });</script>";
          } else if ($row2[4]==2){
              echo "<div class='business' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
              echo "<script>
                document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                  if (this.className!='occupied' && this.className!='my_place'){
                    document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(".$row2[3].")+Number(arr[1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                    this.className='my_place';
                    var elem = document.createElement('p');
                    elem.id=this.id+'_place';
                    elem.className='choosing_place';
                    elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                    document.getElementById('info').appendChild(elem);
                    document.getElementById(elem.id).addEventListener('click',function(){
                      document.getElementById('".$row2[2]."_".$row2[1]."').className='business';
                      document.getElementById('info').removeChild(document.getElementById(elem.id));
                      var str=document.getElementById('now_tickets').value.split(' ');
                      var tmpStr='';
                      for (var i=0;i<str.length;i++){
                        if (str[i]!='".$row2[2]."_".$row2[1]."')
                          tmpStr+=str[i]+' ';
                      }
                      document.getElementById('now_tickets').value=tmpStr;
                      str=this.innerHTML.split(' ');
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(arr[1])-Number(str[str.length-1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                    });
                }
              });</script>";
          } else if ($row2[4]==3){
              echo "<div class='first_class' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
              echo "<script>
                document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                  if (this.className!='occupied' && this.className!='my_place'){
                    document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                    var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                    arr[1] = Number(".$row2[3].")+Number(arr[1]);
                    document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                    this.className='my_place';
                    var elem = document.createElement('p');
                    elem.id=this.id+'_place';
                    elem.className='choosing_place';
                    elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                    document.getElementById('info').appendChild(elem);
                    document.getElementById(elem.id).addEventListener('click',function(){
                      document.getElementById('".$row2[2]."_".$row2[1]."').className='first_class';
                      document.getElementById('info').removeChild(document.getElementById(elem.id));
                      var str=document.getElementById('now_tickets').value.split(' ');
                      var tmpStr='';
                      for (var i=0;i<str.length;i++){
                        if (str[i]!='".$row2[2]."_".$row2[1]."')
                          tmpStr+=str[i]+' ';
                      }
                      document.getElementById('now_tickets').value=tmpStr;
                      str=this.innerHTML.split(' ');
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(arr[1])-Number(str[str.length-1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                    });
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
                      if (this.className!='occupied' && this.className!='my_place'){
                        document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                        var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                        arr[1] = Number(".$row2[3].")+Number(arr[1]);
                        document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                        this.className='my_place';
                        var elem = document.createElement('p');
                        elem.id=this.id+'_place';
                        elem.className='choosing_place';
                        elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                        document.getElementById('info').appendChild(elem);
                        document.getElementById(elem.id).addEventListener('click',function(){
                          document.getElementById('".$row2[2]."_".$row2[1]."').className='seat';
                          document.getElementById('info').removeChild(document.getElementById(elem.id));
                          var str=document.getElementById('now_tickets').value.split(' ');
                          var tmpStr='';
                          for (var i=0;i<str.length;i++){
                            if (str[i]!='".$row2[2]."_".$row2[1]."')
                              tmpStr+=str[i]+' ';
                          }
                          document.getElementById('now_tickets').value=tmpStr;
                          str=this.innerHTML.split(' ');
                          var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                          arr[1] = Number(arr[1])-Number(str[str.length-1]);
                          document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                        });
                    }
                  });</script>";
            } else if ($row2[4]==2){
                echo "<div class='business' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
                echo "<script>
                  document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                    if (this.className!='occupied' && this.className!='my_place'){
                      document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(".$row2[3].")+Number(arr[1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                      this.className='my_place';
                      var elem = document.createElement('p');
                      elem.id=this.id+'_place';
                      elem.className='choosing_place';
                      elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';
                      document.getElementById('info').appendChild(elem);
                      document.getElementById(elem.id).addEventListener('click',function(){
                        document.getElementById('".$row2[2]."_".$row2[1]."').className='business';
                        document.getElementById('info').removeChild(document.getElementById(elem.id));
                        var str=document.getElementById('now_tickets').value.split(' ');
                        var tmpStr='';
                        for (var i=0;i<str.length;i++){
                          if (str[i]!='".$row2[2]."_".$row2[1]."')
                            tmpStr+=str[i]+' ';
                        }
                        document.getElementById('now_tickets').value=tmpStr;
                        str=this.innerHTML.split(' ');
                        var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                        arr[1] = Number(arr[1])-Number(str[str.length-1]);
                        document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                      });
                  }
                });</script>";
            } else if ($row2[4]==3){
                echo "<div class='first_class' id='".$row2[2]."_".$row2[1]."' data-title='Место ".$row2[2]." ".$row2[1]." Стоимость:".$row2[3]."'></div>";
                echo "<script>
                  document.getElementById('".$row2[2]."_".$row2[1]."').addEventListener('click',function(){
                    if (this.className!='occupied' && this.className!='my_place'){
                      document.getElementById('now_tickets').value+='".$row2[2]."_".$row2[1]." ';
                      var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                      arr[1] = Number(".$row2[3].")+Number(arr[1]);
                      document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                      this.className='my_place';
                      var elem = document.createElement('p');
                      elem.id=this.id+'_place';
                      elem.className='choosing_place';
                      elem.innerHTML='Место ".$row2[2]." ".$row2[1]." Стоимость: ".$row2[3]."';

                      document.getElementById('info').appendChild(elem);
                      document.getElementById(elem.id).addEventListener('click',function(){
                        document.getElementById('".$row2[2]."_".$row2[1]."').className='first_class';
                        document.getElementById('info').removeChild(document.getElementById(elem.id));
                        var str=document.getElementById('now_tickets').value.split(' ');
                        var tmpStr='';
                        for (var i=0;i<str.length;i++){
                          if (str[i]!='".$row2[2]."_".$row2[1]."')
                            tmpStr+=str[i]+' ';
                        }
                        document.getElementById('now_tickets').value=tmpStr;
                        str=this.innerHTML.split(' ');
                        var arr=document.getElementById('sum_tickets').innerHTML.split(' ');
                        arr[1] = Number(arr[1])-Number(str[str.length-1]);
                        document.getElementById('sum_tickets').innerHTML='Итого: '+ arr[1] +' руб.';
                      });
                  }
                });

                </script>";
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
      <h2 align='center'>Обозначение мест</h2>
      <?php
        $query="SELECT `type`,`NameTicket`,`Discribtion`  FROM `tickets`,`ttypeoftickets` WHERE  type=idType and idFlight=".$_GET['id']." GROUP BY `type`,`NameTicket`,`Discribtion`;";
        $result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
        for ($i=0; $i < mysqli_num_rows($result); $i++) {
          $row=mysqli_fetch_row($result);
          if ($row[0]==1){
           echo "<div><div class='example_cube' style='background-color: gray;' align='center'> &nbsp</div>&nbsp".$row[1]." ".$row[2]."</div>";
         }
         if ($row[0]==2){
          echo "<div><div class='example_cube' style='background-color: #008000;' align='center'>&nbsp</div>&nbsp".$row[1]." ".$row[2]."</div>";
        }
        if ($row[0]==3){
         echo "<div><div class='example_cube' style='background-color: blue;' align='center'>&nbsp</div>&nbsp".$row[1]." ".$row[2]."</div>";
       }
        }
        echo "<div><div class='example_cube' style='background-color: red;' align='center'>&nbsp</div>&nbspЗанято</div>";
        echo "<div><div class='example_cube' style='background-color: Goldenrod;' align='center'>&nbsp</div>&nbspВыбрано вами</div>";
      ?>
      <h2 align='center'>Выбранные билеты</h2>
      <form action='access_contract.php' method='post'>
        <input type='submit' name='sub_btn' value='Подвердить выбор'>
        <input type='hidden' id='now_tickets' name='now_tickets' value='' required>

        <div id ='sum_tickets' class='sum_tickets' name='sum_tickets'>Итого: 0 руб.<div>
        </form>
    </div>
  </div>
  </div>
  <?php
    mysqli_close($link);
    mysqli_close($link2);
  ?>
  <script>
   function loadPage() {
     document.getElementById('now_tickets').value = '';
   }
  </script>
</body>
</html>
