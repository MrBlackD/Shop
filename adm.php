<?php
	session_start();
	//Проверка входа админа
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
	if(isset($_POST['id'])){
		$id= mysql_real_escape_string($_POST['id']);
		$name=mysql_real_escape_string($_POST['name']);
		$price=mysql_real_escape_string($_POST['price']);
		$color=mysql_real_escape_string($_POST['color']);
		$tags=mysql_real_escape_string($_POST['tags']);
		$for=mysql_real_escape_string($_POST['for']);
	}
	//Обработчик формы изменения товара
	if(isset($_GET['edit'])){
		if(isset($_POST['img'])){
			$img=$_POST['img'];
		}else{
			$img=$_FILES['img']['name'];
			// Если файл загружен успешно, перемещаем его
			// из временной директории в конечную
			if(is_uploaded_file($_FILES["img"]["tmp_name"]))
				move_uploaded_file($_FILES["img"]["tmp_name"], "./img/".$_FILES["img"]["name"]);
			else
				die("Ошибка загрузки файла");
		}
		$query=mysql_query("UPDATE shop SET `name`='$name', `price`='$price', `color`='$color', `tags`='$tags', `for`='$for', img='$img' WHERE `id`='$id'");
		if($query)
			echo "Товар успешно обновлён в базе данных<br>";
		else
			echo "Ошибка при обновлении товара в базе данных<br>".mysql_error();
	}
	
	//Обработчик формы добавления товара
	if(isset($_GET['add'])){
		$img=mysql_real_escape_string($_FILES['img']['name']);
		// Если файл загружен успешно, перемещаем его
		// из временной директории в конечную
		if(is_uploaded_file($_FILES["img"]["tmp_name"]))
			move_uploaded_file($_FILES["img"]["tmp_name"], "./img/".$_FILES["img"]["name"]);
		else
			die("Ошибка загрузки файла");
		$desc=mysql_query("INSERT INTO shop (`name`,`price`,`color`,`tags`,`for`,`img`,`stock`) VALUES ('$name','$price','$color','$tags','$for','$img',1)");

	}
	
	//Обработчик формы изменения статуса товара
	if(isset($_GET['stock'])){
		if($_POST['choose']!="del"){
			$stock=mysql_real_escape_string($_POST['choose']);
			echo $stock;
			$query=mysql_query("UPDATE shop SET `stock`='$stock' WHERE `id`='$id'");
			if($query)
				echo "Статус товара успешно обновлён в базе данных<br>";
			else
				echo "Ошибка при обновлении статуса товара в базе данных<br>".mysql_error();
		}else{
			$query=mysql_query("DELETE FROM shop WHERE `id`='$id'");
			if($query)
				echo "Товар успешно удалён в базе данных<br>";
			else
				echo "Ошибка при удаленнии товара в базе данных<br>".mysql_error();
		}
	}
	
	//Достаём из базы товар с определённым id
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$q=mysql_query("SELECT * FROM shop WHERE id='$id' ORDER BY id DESC");
	}elseif(isset($_GET['cat'])){//Достаём из базы товары определённой категории
		$cat=$_GET['cat'];
		$q=mysql_query("SELECT * FROM shop WHERE tags LIKE '$cat' ORDER BY id DESC");
	}else{
		$q=mysql_query("SELECT * FROM shop ORDER BY id DESC");//Достаём из базы весь товар
	}
	
	
	//Формируем список категорий на основе поля tags
	$tags=array();
	$q1=mysql_query("SELECT tags FROM shop");
	while($res=mysql_fetch_assoc($q1))
		if(!in_array($res['tags'],$tags))
			$tags[]=$res['tags'];
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
		<div id="all">
			<div id="main">
				<div id="top"><h1 id="title"><a href='index.php'>Iphone accessories</a></h1></div>
				<div id="left">
					<ul id="menu">
						<li><a href="add.php">Добавить товар</a></li>
						<?php
						
							echo "<li><a href='adm.php'>Все товары</a></li>";
							for($i=0;$i<count($tags);$i++)
								echo "<li><a href='?cat=".htmlspecialchars($tags[$i])."'>".htmlspecialchars($tags[$i])."</a></li>";
						?>
					</ul>			
				</div>
				<div id="content">
					<?php
						while($items=mysql_fetch_assoc($q))
						{
							echo "
								<a href='action.php?id=".htmlspecialchars($items['id'])."'>
								<div class='item'>
									<div class='shad'></div>
									<img class='pic' src='img/".htmlspecialchars($items['img'])."'>
									<div class='desc'>Номер товара: #".htmlspecialchars($items['id']).
									"</br>Название: ".htmlspecialchars($items['name']).
									"</br>Цвет: ".htmlspecialchars($items['color']).
									
									"</br>Для: ".htmlspecialchars($items['for']).
									"</br>Цена: ".htmlspecialchars($items['price']).
									"</br>В наличии:";
							if((htmlspecialchars($items['stock']))==1)
								echo "Да";
							else
								echo "Нет";
							echo "</div>
								</div>
								</a>";
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>