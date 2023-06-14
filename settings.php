<?php
	$DB_CONNECTION_STRING = "host=localhost port=5432 dbname=acc user=postgres password=qazxsw";
  session_start();
		
	// подключение к БД
    $acc = pg_connect($DB_CONNECTION_STRING);
	if (!$acc) {
		echo "Ошибка подключения к БД";
		http_response_code(500);
		exit;
	}

    if(isset($_GET['add'])) {
        $id_tag = $_GET['id_discipline'];
        $id_sect = $_GET['id_line'];


        $query_find = "SELECT * FROM section_tag WHERE section_id = $1 AND tag_id = $2";
        $res_find = pg_query_params($acc, $query_find, array($id_sect, $id_tag));
        if (pg_num_rows($res_find) == 0) {
            $query = "INSERT INTO section_tag (section_id, tag_id) VALUES ($1, $2)";
            $res = pg_query_params($acc, $query, array($id_sect, $id_tag));
        }
        header("Location: index.php");
        exit;
    }

    if(isset($_GET['remove'])) {
        $id_tag = $_GET['id_discipline'];
        $id_sect = $_GET['id_line'];


        $query = "DELETE FROM section_tag WHERE section_id = $1 AND tag_id = $2";
        $res = pg_query_params($acc, $query, array($id_sect, $id_tag));

        header("Location: index.php");
        exit;
    }

    $headerId = $_POST['headerId'];
    $startTime = time();
    for ($i = 1; $i <= 10; $i++){
        $query_find = "SELECT * FROM section WHERE parent_id = $1";
        $res_find = pg_query_params($acc, $query_find, array($headerId));
        $result_array = pg_fetch_all($res_find);

        $cnt = 0;
        $cnt1 = 0;
        foreach ($result_array as $i) {
            $cnt1 += 1;
            if ($i['status_prc'] != 0) {
                $cnt += 1;
            }
        }

        if ($cnt1 != 0) {
            $res = intval(($cnt / $cnt1) * 100);
        } else {
            $res = 0;
        }

        $query = "UPDATE section SET status_prc = $1 WHERE id = $2";
        $result = pg_query_params($acc, $query, array($res, $headerId));
        if($startTime > 60) break;
    }

    echo $res;

?>