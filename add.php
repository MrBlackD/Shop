<?php
	session_start();
	if((!isset($_POST['login'])||!isset($_POST['pass']))&&(!isset($_SESSION['login'])||!isset($_SESSION['pass']))){
		include("enter.php");
		die();
	}
	include("options.php");
	if(($_POST['login']!=$login||$_POST['pass']!=$pass)&&($_SESSION['login']!=$login||$_SESSION['pass']!=$pass)){
		include("enter.php");
		die();
	}else{
		if(!isset($_SESSION['login'])&&!isset($_SESSION['pass'])){
			$_SESSION['login']=$_POST['login'];
			$_SESSION['pass']=$_POST['pass'];
		}
	}
	include("connect.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Shop</title>
		<meta charset="utf-8">
		<script src="js/script.js"></script>
		<link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<p>Форма добавления товара</p>
		<form action="adm.php?add=1" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']) ?>">
			<label>Название:<br><input type="text" name="name"></label><br>
			<label>Цена:<br><input type="text" name="price"></label><br>
			<label>Цвет:<br><input type="text" name="color"></label><br>
			<label>Для:<br><input type="text" name="for"></label><br>
			<label>Теги(через запятую):<br><input type="text" name="tags"></label><br>
			<label >Изображение: <br><br><input type='file' name='img'></label><br>
			<input type="submit" value="Закончить"><br>
		</form>
	</body>
</html>