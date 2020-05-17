<?php
require_once 'connection.php';
$link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
$query="SELECT password FROM users WHERE login='".$_POST['login']."'";
$erro="";
$result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
if (mysqli_num_rows($result)!=0){
	$row=mysqli_fetch_row($result);
	if ($_POST['pass']==$row[0]){
		setcookie("login",$_POST['login']);
		setcookie("pass",$_POST['pass']);
		header("Location:login.php");
		exit();
	} else if (($_POST['pass']!=$row[0] and $_POST['pass']!="")){
		$erro= "<p>Password is incorrect</p>";
	}
} else if ((mysqli_num_rows($result)==0) &&  ($_POST['login']!="")){
	$erro= "<p>Login is incorrect</p>";
}
mysqli_close($link);
?>
<title>Авторизация</title>
<LINK REL="stylesheet" HREF = "authorization.css">
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css?family=Russo+One&display=swap" rel="stylesheet">
<body>
<div class='leftWall'></div>
<form   method='POST' name='authForm' class='formAuth'>
<input type='text' name='login'>
<input type='password' name='pass'>
<input type='submit'>
<?php
echo $erro;
?>
</form>
<div class='rightWall'></div>
</body>
</html>