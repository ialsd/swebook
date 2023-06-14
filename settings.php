<?php
	$DB_CONNECTION_STRING = "host=localhost port=5432 dbname=swebook user=swebook password=123456";
  session_start();
		
	// подключение к БД
    $acc = pg_connect($DB_CONNECTION_STRING);
	if (!$acc) {
		echo "Ошибка подключения к БД";
		http_response_code(500);
		exit;
	}
?>