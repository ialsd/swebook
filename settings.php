<?php
	$DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=accelerator user=accelerator password=123456"; 
  session_start();
		
	// подключение к БД
	$dbconnect = pg_connect($DB_CONNECTION_STRING);
	if (!$dbconnect) {
		echo "Ошибка подключения к БД";
		http_response_code(500);
		exit;
	}
?>