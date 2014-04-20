<?php
	include("connect.php");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$q=mysql_query("SELECT * FROM shop WHERE id='$id' ORDER BY id DESC");
	}elseif(isset($_GET['cat'])){
		$cat=$_GET['cat'];
		$q=mysql_query("SELECT * FROM shop WHERE tags LIKE '$cat' ORDER BY id DESC");
	}else{
		$q=mysql_query("SELECT * FROM shop ORDER BY id DESC");
	}
	
	
	
	$tags=array();
	$q1=mysql_query("SELECT tags FROM shop");
	while($res=mysql_fetch_assoc($q1))
		if(!in_array($res['tags'],$tags))
			$tags[]=$res['tags'];
	
	
   //htmlspecialchars
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
						<?php
							echo "<li><a href='index.php'>Все товары</a></li>";
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
								</div>";
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>