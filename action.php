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
	if(!isset($_GET['id']))
		die('Такого товара не обнаружено');
	$id=$_GET['id'];
	$q=mysql_query("SELECT * FROM shop WHERE id='$id'");
	$item=mysql_fetch_assoc($q);
	if(!$item)
		die('Такого товара не обнаружено');
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
		<p>Форма изменения статуса товара</p>
		<form action="adm.php?stock=1" method="POST">
			<input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']) ?>">
			<label><input type="radio" name="choose" <?php if($item['stock']==0) echo "checked"; ?> value="0">Пометить как "нет в наличии"</label><br>
			<label><input type="radio" name="choose" <?php if($item['stock']==1) echo "checked"; ?> value="1">Пометить как "имеется в наличии"</label><br>
			<label><input type="radio" name="choose" value="del">Удалить товар</label><br>
			<input type="submit"value="Закончить"><br>
		</form>
		<hr>
		<p>Форма редактирования товара</p>
		<form action="adm.php?edit=1" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']) ?>">
			<label>Название:<br><input type="text" name="name" value="<?php echo htmlspecialchars($item['name']) ?>"></label><br>
			<label>Цена:<br><input type="text" name="price" value="<?php echo htmlspecialchars($item['price']) ?>"></label><br>
			<label>Цвет:<br><input type="text" name="color" value="<?php echo htmlspecialchars($item['color']) ?>"></label><br>
			<label>Для:<br><input type="text" name="for" value="<?php echo htmlspecialchars($item['for']) ?>"></label><br>
			<label>Теги(через запятую):<br><input type="text" value="<?php echo htmlspecialchars($item['tags']) ?>" name="tags"></label><br>
			<label >Изображение: <br><input id="newimg" type="text" readonly name="img" value="<?php echo htmlspecialchars($item['img']) ?>"></label>
			<label><input type="checkbox" id="change"> изменить </label><br>
			<input type="submit" value="Закончить"><br>
		</form>
	</body>
</html>