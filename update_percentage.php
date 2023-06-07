<?php
$DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=acc user=postgres password=qazxsw";
$acc = pg_connect($DB_CONNECTION_STRING);
if (!$acc) {
    echo "Ошибка подключения к БД";
    http_response_code(500);
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
