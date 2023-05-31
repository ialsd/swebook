<?php

$DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=acc user=postgres password=qazxsw"; 

if(isset($_GET['add'])) {
    $id_tag = $_GET['id_discipline'];
    $id_sect = $_GET['id_line'];

    $acc = pg_connect($DB_CONNECTION_STRING);
    if (!$acc) 
    {
        echo "Ошибка подключения к БД";
        http_response_code(500);
        exit;
    }

    $query_find = "SELECT * FROM section_tag WHERE section_id = $1 AND tag_id = $2";
    $res_find = pg_query_params($acc, $query_find, array($id_sect, $id_tag));
    if (pg_num_rows($res_find) == 0) {
        $query = "INSERT INTO section_tag (section_id, tag_id) VALUES ($1, $2)";
        $res = pg_query_params($acc, $query, array($id_sect, $id_tag));
    }
    header("Location: http://localhost");
    exit;
}

if(isset($_GET['remove'])) {
    $id_tag = $_GET['id_discipline'];
    $id_sect = $_GET['id_line'];

    $acc = pg_connect($DB_CONNECTION_STRING);
    if (!$acc) 
    {
        echo "Ошибка подключения к БД";
        http_response_code(500);
        exit;
    }

    $query = "DELETE FROM section_tag WHERE section_id = $1 AND tag_id = $2";
    $res = pg_query_params($acc, $query, array($id_sect, $id_tag));

    header("Location: http://localhost");
    exit;
}

?>