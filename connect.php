﻿<?php 
	//Aдрес сервера MySQL
	$dblocation="localhost";
	//Имя базы данных на хостинге или локальной машине
	$dbname="database";
	//Имя пользователя базы данных
	$dbuser="root";
	//его пароль
	$dbpasswd="";
	//устанавливаем соединение с базой данных
	$dbcnx=@mysql_connect($dblocation, $dbuser, $dbpasswd);
	if(!$dbcnx) {
		exit("<p>В настоящий момент сервер базы данных не доступен, поэтому корректное отбражение страницы невозможно</p>");
	}
	//выбираем базу данных
	if(!@mysql_select_db($dbname, $dbcnx))
	{
		exit("<p>В настоящий момент база данных не доступна, поэтому корректное отбражение страницы невозможно </p>");
	}
		mysql_query('SET NAMES cp1251',$dbcnx);          
		mysql_query('SET CHARACTER SET cp1251',$dbcnx);  
		mysql_query('SET COLLATION_CONNECTION="cp1251_general_ci"',$dbcnx);
?>