<?php
include ('utils.php');
printHeader('Кормушка', '', array('https://fonts.googleapis.com/css?family=Open+Sans', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css', './style.css'));

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<?php
$DB_CONNECTION_STRING = "host=localhost port=5432 dbname=acc user=postgres password=qazxsw";
$acc = pg_connect($DB_CONNECTION_STRING);
if (!$acc) 
{
    echo "Ошибка подключения к БД";
    http_response_code(500);
    exit;
}
$result_header = pg_query($acc, "SELECT * FROM section WHERE level = 1 order by id");
$array_header = pg_fetch_all($result_header);
?>
<div class="accordion js-accordion w-100">
<?php
?>
<form method="GET" action="settings.php" style="display: none;" id="form-addDiscipline">
    <input type="hidden" name="add" value="true"/>
    <input type="hidden" id="input-discipline" name="id_discipline" value=""/>
    <input type="hidden" id="input-line" name="id_line" value=""/>
</form>
<form method="REMOVE" action="settings.php" style="display: none;" id="form-removeDiscipline">
    <input type="hidden" name="remove" value="true"/>
    <input type="hidden" id="remove-discipline" name="id_discipline" value=""/>
    <input type="hidden" id="remove-line" name="id_line" value=""/>
</form>
<?php
$i_header = 0;
$index_arr_header = array();
foreach ($array_header as $header)
{
    array_push($index_arr_header, $header['id'])
    ?>
  <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header">
        <div style="display: flex; justify-content:space-between; align-items: center;" onclick="updatePercentage(<?=$header['id']?>, 'btn-header')">
            <p style="margin: 0; padding: 0;"><?=$header['name']?></p>
            <div>
                <button id="button-show-<?=$index_arr_header[$i_header]?>" data-target="#modal-show-<?=$index_arr_header[$i_header]?>"
                        style="float: right; margin: 5px; cursor: pointer; color: white"
                        type="button" class="btn btn-warning btn-show">Посмотреть дисциплины
                </button>
                <button id="button<?=$index_arr_header[$i_header]?>" data-target="#modal<?=$index_arr_header[$i_header]?>"
                        style="float: right; margin: 5px; cursor: pointer;"
                        type="button" class="btn btn-primary btn-add">Добавить дисциплину
                </button>
                <button id="btn-header<?=$header['id']?>" style="float: right; margin: 5px; color: white;"
                        type="button" class="btn btn-warning btn-show">
                    <?= ($header['status_prc']) ? $header['status_prc'] : 0?>%
                </button>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="modal<?=$index_arr_header[$i_header]?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Выберите дисциплину:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-target="#modal<?=$index_arr_header[$i_header]?>"
                              style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                display: flex; justify-content: center;" class="close">&times;
                        </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $res = pg_query($acc, "SELECT * FROM section_tag WHERE section_id = $index_arr_header[$i_header]");
                        $arr = pg_fetch_all($res);
                        $result = pg_query($acc, "SELECT id, name FROM tag");
                        $array = pg_fetch_all($result);
                        ?>
                        <?php foreach($array as $id=>$value):?>
                            <?php $found = false; ?>
                            <?php foreach($arr as $item): ?>
                                <?php if ($item['tag_id'] == $value['id']): ?>
                                    <?php $found = true; ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (!$found): ?>
                                <button type="button" class="btn btn-outline-success disc"
                                        onclick="addDiscLineId(<?=$index_arr_header[$i_header]?>, <?=$value['id']?>)">
                                    <?= $value['name'] ?>
                                </button>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-show-display" tabindex="-1" role="dialog" id="modal-show-<?=$index_arr_header[$i_header]?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-show-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Список дисциплин:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-target="#modal-show-<?=$index_arr_header[$i_header]?>"
                              style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                display: flex; justify-content: center;" class="close">&times;
                        </span>
                        </button>
                    </div>
                    <div class="modal-body modal-show-discipline">
                        <?php
                        $result_tag_id = pg_query($acc, "SELECT tag_id FROM section_tag WHERE section_id = $index_arr_header[$i_header]");
                        $array_tag_id = pg_fetch_all($result_tag_id);
                        ?>
                        <?php foreach($array_tag_id as $id=>$value):?>
                            <button type="button" class="btn btn-outline-success disc" onclick="removeDisc(<?=$index_arr_header[$i_header]?>, <?=$value['tag_id']?>)">
                                <?php
                                $tag_id = $value['tag_id'];
                                $result_tag = pg_query($acc, "SELECT * FROM tag WHERE id = $tag_id");
                                $array_tag = pg_fetch_assoc($result_tag);
                                ?>
                                <?= $array_tag['name'] ?>
                            </button>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-body js-accordion-body">
      <div class="accordion js-accordion w-100">
        <?php
        $par_id = $header['id'];
        $result_sub = pg_query($acc, "SELECT * FROM section WHERE level = 2 AND parent_id = $par_id order by id");
        $array_sub = pg_fetch_all($result_sub);
        $i_sub = 0;
        $index_arr_sub = array();
        foreach ($array_sub as $sub)
        {
            array_push($index_arr_sub, $sub['id'])
            ?>
            <div class="accordion__item js-accordion-item w-100">
                <div class="accordion-header js-accordion-header w-100">
                    <div style="display: flex; justify-content:space-between; align-items: center;"  onclick="updatePercentage(<?=$sub['id']?>, 'btn-sub')">
                        <p style="margin: 0; padding: 0;"><?=$sub['name']?></p>
                        <div>
                            <button id="button-show-<?=$index_arr_sub[$i_sub]?>" data-target="#modal-show-<?=$index_arr_sub[$i_sub]?>"
                                    style="float: right; margin: 5px; cursor: pointer; color: white"
                                    type="button" class="btn btn-warning btn-show">Посмотреть дисциплины
                            </button>
                            <button id="button<?=$index_arr_sub[$i_sub]?>" data-target="#modal<?=$index_arr_sub[$i_sub]?>"
                                    style="float: right; margin: 5px; cursor: pointer;"
                                    type="button" class="btn btn-primary btn-add">Добавить дисциплину
                            </button>
                            <button id="btn-sub<?=$sub['id']?>" style="float: right; margin: 5px; color: white;"
                                    type="button" class="btn btn-warning btn-show">
                                <?=($sub['status_prc']) ? $sub['status_prc'] : 0?>%
                            </button>
                        </div>
                    </div>
                    <div class="modal" tabindex="-1" role="dialog" id="modal<?=$index_arr_sub[$i_sub]?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Выберите дисциплину:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span data-target="#modal<?=$index_arr_sub[$i_sub]?>"
                                          style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                            display: flex; justify-content: center;" class="close">&times;
                                    </span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $res = pg_query($acc, "SELECT * FROM section_tag WHERE section_id = $index_arr_sub[$i_sub]");
                                    $arr = pg_fetch_all($res);
                                    $result = pg_query($acc, "SELECT id, name FROM tag");
                                    $array = pg_fetch_all($result);
                                    ?>
                                    <?php foreach($array as $id=>$value):?>
                                        <?php $found = false; ?>
                                        <?php foreach($arr as $item): ?>
                                            <?php if ($item['tag_id'] == $value['id']): ?>
                                                <?php $found = true; ?>
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php if (!$found): ?>
                                            <button type="button" class="btn btn-outline-success disc"
                                                    onclick="addDiscLineId(<?=$index_arr_sub[$i_sub]?>, <?=$value['id']?>)">
                                                <?= $value['name'] ?>
                                            </button>
                                        <?php endif; ?>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal modal-show-display" tabindex="-1" role="dialog" id="modal-show-<?=$index_arr_sub[$i_sub]?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-show-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Список дисциплин:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-target="#modal-show-<?=$index_arr_sub[$i_sub]?>"
                              style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                display: flex; justify-content: center;" class="close">&times;
                        </span>
                                    </button>
                                </div>
                                <div class="modal-body modal-show-discipline">
                                    <?php
                                    $result_tag_id = pg_query($acc, "SELECT tag_id FROM section_tag WHERE section_id = $index_arr_sub[$i_sub]");
                                    $array_tag_id = pg_fetch_all($result_tag_id);
                                    ?>
                                    <?php foreach($array_tag_id as $id=>$value):?>
                                        <button type="button" class="btn btn-outline-success disc" onclick="removeDisc(<?=$index_arr_sub[$i_sub]?>, <?=$value['tag_id']?>)">
                                            <?php
                                            $tag_id = $value['tag_id'];
                                            $result_tag = pg_query($acc, "SELECT * FROM tag WHERE id = $tag_id");
                                            $array_tag = pg_fetch_assoc($result_tag);
                                            ?>
                                            <?= $array_tag['name'] ?>
                                        </button>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="accordion-body js-accordion-body w-100">
            <?php
            $sub_id = $sub['id'];
            $result_sub0 = pg_query($acc, "SELECT * FROM section WHERE level = 3 AND parent_id = $sub_id order by id");
            $array_sub0 = pg_fetch_all($result_sub0);
            $i_sub0 = 0;
            $index_arr_sub0 = array();
            foreach ($array_sub0 as $sub0)
            {
                array_push($index_arr_sub0, $sub0['id']);
                $sub0_id = $sub0['id'];
                $result_sub1 = pg_query($acc, "SELECT * FROM section WHERE level = 4 AND parent_id = $sub0_id order by id");
                $array_sub1 = pg_fetch_all($result_sub1);

                $tmp_arr_sub1 = array();
                $index_arr = array();

                foreach ($array_sub1 as $sub1)
                {
                    $row = '<tr><td style="border-bottom: 1px solid black;">'.$sub1['name'].'</td>';
                    $row .= '<td style="border-bottom: 1px solid black;"></td>';
                    $row .= '</tr>';
                    array_push($tmp_arr_sub1, $row);
                    array_push($index_arr, $sub1['id']);
                }
                ?>
                <div class="accordion__item js-accordion-item">
                    <div class="accordion-header accordion-subheader js-accordion-header">
                        <div style="display: flex; justify-content:space-between; align-items: center;">
                            <p style="margin: 0; padding: 0;"><?=$sub0['name']?></p>
                            <?php
                            $cnt = 0;
                            $cnt1 = 0;
                            $res = 0;
                            foreach($index_arr as $i)
                            {
                                $cnt1 += 1;
                                $query_find = "SELECT * FROM section_tag WHERE section_id = $1";
                                $res_find = pg_query_params($acc, $query_find, array($i));
                                if (pg_num_rows($res_find) != 0) {
                                    $cnt += 1;
                                }
                            }
                            if ($cnt1 != 0) {
                                $res = intval(($cnt / $cnt1) * 100);
                            }
                            else {
                                $res = 0;
                            }
                            $query = "UPDATE section SET status_prc = $1 WHERE id = $2";
                            $result = pg_query_params($acc, $query, array($res, $sub0['id']));
                            ?>
                            <div>
                                <button id="button-show-<?=$index_arr_sub0[$i_sub0]?>" data-target="#modal-show-<?=$index_arr_sub0[$i_sub0]?>"
                                        style="float: right; margin: 5px; cursor: pointer; color: white"
                                        type="button" class="btn btn-warning btn-show">Посмотреть дисциплины
                                </button>
                                <button id="button<?=$index_arr_sub0[$i_sub0]?>" data-target="#modal<?=$index_arr_sub0[$i_sub0]?>"
                                        style="float: right; margin: 5px; cursor: pointer;"
                                        type="button" class="btn btn-primary btn-add">Добавить дисциплину
                                </button>
                                <button id="btn-sub0<?=$sub0['id']?>" style="float: right; margin: 5px; color: white;"
                                        type="button" class="btn btn-warning btn-show">
                                    <?=($res) ? $res : 0?>%
                                </button>
                            </div>
                            <div class="modal" tabindex="-1" role="dialog" id="modal<?=$index_arr_sub0[$i_sub0]?>">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Выберите дисциплину:</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span data-target="#modal<?=$index_arr_sub0[$i_sub0]?>"
                                                      style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                                        display: flex; justify-content: center;" class="close">&times;
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $res = pg_query($acc, "SELECT * FROM section_tag WHERE section_id = $index_arr_sub0[$i_sub0]");
                                            $arr = pg_fetch_all($res);
                                            $result = pg_query($acc, "SELECT id, name FROM tag");
                                            $array = pg_fetch_all($result);
                                            ?>
                                            <?php foreach($array as $id=>$value):?>
                                                <?php $found = false; ?>
                                                <?php foreach($arr as $item): ?>
                                                    <?php if ($item['tag_id'] == $value['id']): ?>
                                                        <?php $found = true; ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (!$found): ?>
                                                    <button type="button" class="btn btn-outline-success disc"
                                                            onclick="addDiscLineId(<?=$index_arr_sub0[$i_sub0]?>, <?=$value['id']?>)">
                                                        <?= $value['name'] ?>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal modal-show-display" tabindex="-1" role="dialog" id="modal-show-<?=$index_arr_sub0[$i_sub0]?>">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-show-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Список дисциплин:</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span data-target="#modal-show-<?=$index_arr_sub0[$i_sub0]?>"
                                                      style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                                        display: flex; justify-content: center;" class="close">&times;
                                                </span>
                                            </button>
                                        </div>
                                        <div class="modal-body modal-show-discipline">
                                            <?php
                                            $result_tag_id = pg_query($acc, "SELECT tag_id FROM section_tag WHERE section_id = $index_arr_sub0[$i_sub0]");
                                            $array_tag_id = pg_fetch_all($result_tag_id);
                                            ?>
                                            <?php foreach($array_tag_id as $id=>$value):?>
                                                <button type="button" class="btn btn-outline-success disc" onclick="removeDisc(<?=$index_arr_sub0[$i_sub0]?>, <?=$value['tag_id']?>)">
                                                    <?php
                                                    $tag_id = $value['tag_id'];
                                                    $result_tag = pg_query($acc, "SELECT * FROM tag WHERE id = $tag_id");
                                                    $array_tag = pg_fetch_assoc($result_tag);
                                                    ?>
                                                    <?= $array_tag['name'] ?>
                                                </button>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $i = 0;
                        ?>
                        <div class="accordion-body__contents" style="display: none">
                            <table style="width: 100%;">
                                <?php foreach($tmp_arr_sub1 as $b): ?>
                                    <tr>
                                        <td><?= $b ?></td>
                                        <td>
                                            <button id="button-show-<?=$index_arr[$i]?>" data-target="#modal-show-<?=$index_arr[$i]?>" 
                                                    style="float: right; margin: 5px; cursor: pointer; color: white"
                                                    type="button" class="btn btn-warning btn-show">Посмотреть дисциплины
                                            </button>
                                            <button id="button<?=$index_arr[$i]?>" data-target="#modal<?=$index_arr[$i]?>" 
                                                    style="float: right; margin: 5px; cursor: pointer;"  
                                                    type="button" class="btn btn-primary btn-add">Добавить дисциплину
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal" tabindex="-1" role="dialog" id="modal<?=$index_arr[$i]?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Выберите дисциплину:</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span data-target="#modal<?=$index_arr[$i]?>" 
                                                            style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                                                display: flex; justify-content: center;" class="close">&times;
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $res = pg_query($acc, "SELECT * FROM section_tag WHERE section_id = $index_arr[$i]");
                                                    $arr = pg_fetch_all($res);
                                                    $result = pg_query($acc, "SELECT id, name FROM tag");
                                                    $array = pg_fetch_all($result);
                                                    ?>
                                                    <?php foreach($array as $id=>$value):?>
                                                        <?php $found = false; ?>
                                                        <?php foreach($arr as $item): ?>
                                                            <?php if ($item['tag_id'] == $value['id']): ?>
                                                                <?php $found = true; ?>
                                                                <?php break; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php if (!$found): ?>
                                                            <button type="button" class="btn btn-outline-success disc" 
                                                                    onclick="addDiscLineId(<?=$index_arr[$i]?>, <?=$value['id']?>)">
                                                                <?= $value['name'] ?>
                                                            </button>
                                                        <?php endif; ?>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal modal-show-display" tabindex="-1" role="dialog" id="modal-show-<?=$index_arr[$i]?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-show-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Список дисциплин:</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span data-target="#modal-show-<?=$index_arr[$i]?>" 
                                                            style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                                                display: flex; justify-content: center;" class="close">&times;
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="modal-body modal-show-discipline">
                                                    <?php 
                                                    $result_tag_id = pg_query($acc, "SELECT tag_id FROM section_tag WHERE section_id = $index_arr[$i]");
                                                    $array_tag_id = pg_fetch_all($result_tag_id);
                                                    ?>
                                                    <?php foreach($array_tag_id as $id=>$value):?>
                                                        <button type="button" class="btn btn-outline-success disc" onclick="removeDisc(<?=$index_arr[$i]?>, <?=$value['tag_id']?>)">
                                                            <?php
                                                            $tag_id = $value['tag_id'];
                                                            $result_tag = pg_query($acc, "SELECT * FROM tag WHERE id = $tag_id");
                                                            $array_tag = pg_fetch_assoc($result_tag);
                                                            ?>
                                                            <?= $array_tag['name'] ?>
                                                        </button>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i += 1;?>
                                <?php endforeach;?>
                            </table>
                        </div>
                        <script>
                            if (typeof buttons === "undefined"){
                                const buttons = document.querySelectorAll("[data-target]");
                                var tmp_btn = null;
                                buttons.forEach(function(btn) {
                                    btn.onclick = function() {
                                        const modal = document.querySelector(btn.getAttribute('data-target'));
                                        modal.style.display = "block";
                                        btn.classList.add('pressed');
                                        tmp_btn = btn;
                                        disableOtherButtons();
                                    }
                                });
                                const disableOtherButtons= () => {
                                    buttons.forEach(function(btn){
                                        if (btn !== tmp_btn)
                                        {
                                            btn.classList.add('disabled');
                                        }
                                    })
                                }
                                const close = document.querySelectorAll(".close");
                                close.forEach(function(btn) {
                                    btn.onclick = function() {
                                        const modal = document.querySelector(btn.getAttribute('data-target'));
                                        modal.style.display = "none";
                                        tmp_btn.classList.remove('pressed');
                                        activeOtherButtons();
                                    }
                                });
                                const activeOtherButtons= () => {
                                    buttons.forEach(function(btn){
                                        if (btn !== tmp_btn)
                                        {
                                            btn.classList.remove('disabled');
                                        }
                                    })
                                }
                            }
                            function addDiscLineId(line_id, discipline_id){
                                document.getElementById("input-discipline").value = discipline_id;
                                document.getElementById("input-line").value = line_id;
                                document.getElementById("form-addDiscipline").submit();
                            }
                            function removeDisc(line_id, discipline_id){
                                document.getElementById("remove-discipline").value = discipline_id;
                                document.getElementById("remove-line").value = line_id;
                                document.getElementById("form-removeDiscipline").submit();
                            }
                            function updatePercentage(headerId, className) {
                                $.ajax({
                                    url: 'settings.php',
                                    method: 'POST',
                                    data: { headerId: headerId },
                                    success: function (response) {
                                    $(`#${className}` + headerId).text(response + '%');
                                    },
                                    error: function (xhr, status, error) {
                                    console.log(error);
                                    }
                                });
                                }
                        </script>
                        <style>
                            .btn-add.disabled{
                                pointer-events: none;
                                opacity: 0.5;
                            }
                            .btn-show.disabled{
                                pointer-events: none;
                                opacity: 0.5;
                            }
                            .accordion__item > .accordion-header:before {
                                top: 14px;
                            }
                            .modal-dialog {
                                color: black;
                            }
                        </style>
                </div><!-- end of sub accordion item -->
                <?php
                $i_sub0 += 1;
            }
                    ?>
            </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <?php
        $i_sub += 1;
        }
        ?>
        </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
</div><!-- end of accordion item -->
<?php
    $i_header += 1;
}
?>
</div><!-- end of accordion -->
<?php
printFooter();
?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script  src="./script.js"></script>  
<!-- partial -->