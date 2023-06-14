<?php
require_once("settings.php");
include ('utils.php');
printHeader('Кормушка', '', array('https://fonts.googleapis.com/css?family=Open+Sans', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css', './style.css'));
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



<?php

function printLine($index_arr_header, $i_header, $header, $level) {
    global $acc;?>
    <div class="accordion__item js-accordion-item">
        <div class="accordion-header <?=($level%2 == 0 && $level != 4) ? "accordion-subheader" : ""?> js-accordion-header">
            <?php
            printHeadLine($index_arr_header, $i_header, $header, $level);
            printModalChooseDiscipline($index_arr_header, $i_header);
            printModalDisciplineList($index_arr_header, $i_header);
            ?>
        </div>
        <?php
        $par_id = $header['id'];
        $result_sub = pg_query($acc, "SELECT * FROM section WHERE level = $level+1 AND parent_id = $par_id order by id");
        $array_sub = pg_fetch_all($result_sub);
        $i_sub = 0;
        $index_arr_sub = array();
        if ($array_sub) {?>
            <div class="accordion-body js-accordion-body">
                <div class="accordion js-accordion w-100">
                    <?php 
                    foreach ($array_sub as $sub){
                        array_push($index_arr_sub, $sub['id']);
                        ?>
                        
                                <?php
                                printLine($index_arr_sub, $i_sub, $sub, $level+1);
                                ?>
                            
                        <?php 
                        $i_sub += 1;  
                    }?>
                </div>
            </div>
        <?php }?>
    </div>
<?php
}

function printHeadLine($index_arr_header, $i_header, $header, $level) {
    ?>
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
<?php } 

function printModalChooseDiscipline($index_arr_header, $i_header) {
    global $acc;?>
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
<?php
}

function printModalDisciplineList($index_arr_header, $i_header) {
    global $acc;?>
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
<?php 
}


$result_header = pg_query($acc, "SELECT * FROM section WHERE level = 1 order by id");
$array_header = pg_fetch_all($result_header);
?>

<div class="accordion js-accordion w-100">
    <form method="GET" action="update_percentage.php" style="display: none;" id="form-addDiscipline">
        <input type="hidden" name="add" value="true"/>
        <input type="hidden" id="input-discipline" name="id_discipline" value=""/>
        <input type="hidden" id="input-line" name="id_line" value=""/>
    </form>
    <form method="REMOVE" action="update_percentage.php" style="display: none;" id="form-removeDiscipline">
        <input type="hidden" name="remove" value="true"/>
        <input type="hidden" id="remove-discipline" name="id_discipline" value=""/>
        <input type="hidden" id="remove-line" name="id_line" value=""/>
    </form>
        <?php
        $i_header = 0;
        $index_arr_header = array();
        foreach ($array_header as $index => $header) {
            array_push($index_arr_header, $header['id']);
            printLine($index_arr_header, $i_header, $header, 1);
            $i_header += 1; 
        }?>
</div>

<?php printFooter(); ?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script  src="./script.js"></script>  

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
    function addDiscipline(line_id, discipline_id) {
        var formData = new FormData();
        formData.append('line_id', line_id);
        formData.append('discipline_id', discipline_id);
        formData.append('add-discipline', true);

        $.ajax({
            type: "POST",
            url: 'swebook_action.php#content',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            dataType : 'html',
            success: function(response) {
                response = JSON.parse(response);
                $(`#${className}` + headerId).text(response + '%');
            },
            complete: function() {
            }
        });
    }
    function removeDisc(line_id, discipline_id){
        document.getElementById("remove-discipline").value = discipline_id;
        document.getElementById("remove-line").value = line_id;
        document.getElementById("form-removeDiscipline").submit();
    }
    function updatePercentage(headerId, className) {
        $.ajax({
            url: 'update_percentage.php',
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