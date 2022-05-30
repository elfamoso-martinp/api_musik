<?php

//Chaine de connexion sql server
function connectSqlsrv() {
	$sql_dsn ="mysql:host=localhost;dbname=musik;charset=UTF8";
	$sql_username ="root";
	$sql_password="root";

	try{
		$cnx = new PDO($sql_dsn, $sql_username, $sql_password);
	}
	catch (Exception $e){
		echo ($e->getMessage());
	}

	return $cnx;
}

//Chaine de connexion mysql
function connectMySQL() {
	$sql_dns ="mysql:Server=localhost;dbname=locdvd";
	$sql_username ="root";
	$sql_password="";

	try{
		$cnx = new PDO($sql_dns, $sql_username, $sql_password );
	}
	catch (Exception $e){
		echo ($e->getMessage());
	}
	return $cnx;
}

?>