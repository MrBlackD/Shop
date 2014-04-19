<?php//htmlspecialchars
	include("connect.php");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$desc=mysql_query("SELECT * FROM shop WHERE id='$id'");
		$res=mysql_fetch_assoc($desc);
		$site_name=$res['title'];
	}
	if(isset($_GET['cat']))
		$cat=$_GET['cat'];
   
?>