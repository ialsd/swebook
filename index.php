<?php
include ('utils.php');
printHeader('Кормушка', '', array('https://fonts.googleapis.com/css?family=Open+Sans', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css', './style.css'));

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<?php
function accStart()
{
?>
<div class="accordion js-accordion">
<?php
}

function accEnd()
{
?>
</div><!-- end of accordion -->
<?php
}

function accHeader($title = "", $body = "")
{
?>
  <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header"><?=$title?></div> 
    <div class="accordion-body js-accordion-body">
<?php
    if ($body <> "")
	{
?>
      <div class="accordion-body__contents">
        <?=$body?>
      </div>
<?php
    }
?>
      <div class="accordion js-accordion">
<?php
}

function accHeaderEnd()
{
?>
      </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
<?php 
}

function accSub($title = "", $body = "")
{
?>
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header"><?=$title?></div> 
           <div class="accordion-body js-accordion-body">
<?php
    if ($body <> "")
	{
?>
             <div class="accordion-body__contents">
               <?=$body?>
             </div>
<?php
    }
}

function accSubEnd()
{
?>
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
<?php
}

function createBtnAdd($i){
    ?>
    <button id="button<?=$i?>" data-target="#modal<?=$i?>" 
            style="float: right; margin: 5px; cursor: pointer;"  
            type="button" class="btn btn-primary btn-add">Добавить дисциплину
    </button>
    <?php
}

function createBtnShow($i){
    ?>
    <button id="button-show-<?=$i?>" data-target="#modal-show-<?=$i?>" 
            style="float: right; margin: 5px; cursor: pointer;" 
            type="button" class="btn btn-warning btn-show">Посмотреть дисциплины
    </button>
    <?php
}

function getDiscipline($i){
    $DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=acc user=postgres password=qazxsw"; 
    $acc = pg_connect($DB_CONNECTION_STRING);
    if (!$acc) 
    {
        echo "Ошибка подключения к БД";
        http_response_code(500);
        exit;
    }
    $result = pg_query($acc, "SELECT id, name FROM tag");
    $array = pg_fetch_all($result);
?>
    <?php foreach($array as $id=>$value):?>
    <button type="button" class="btn btn-outline-success disc" onclick="addDiscLineId(<?=$i?>, <?=$value['id']?>)">
        <?= $value['name'] ?>
    </button>
<?php endforeach;
}

function createModalAdd($i){
    ?>
    <div class="modal" tabindex="-1" role="dialog" id="modal<?=$i?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выберите дисциплину:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-target="#modal<?=$i?>" 
                            style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                display: flex; justify-content: center;" class="close">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php getDiscipline($i);?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function removeDiscipline($i){
    $DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=acc user=postgres password=qazxsw"; 
    $acc = pg_connect($DB_CONNECTION_STRING);
    if (!$acc) 
    {
        echo "Ошибка подключения к БД";
        http_response_code(500);
        exit;
    }
    $result_tag_id = pg_query($acc, "SELECT tag_id FROM section_tag WHERE section_id = $i");
    $array_tag_id = pg_fetch_all($result_tag_id);
    ?>
    <?php foreach($array_tag_id as $id=>$value):?>
        <button type="button" class="btn btn-outline-success disc" onclick="removeDisc(<?=$i?>, <?=$value['tag_id']?>)">
            <?php
            $tag_id = $value['tag_id'];
            $result_tag = pg_query($acc, "SELECT * FROM tag WHERE id = $tag_id");
            $array_tag = pg_fetch_assoc($result_tag);
            ?>
            <?= $array_tag['name'] ?>
        </button>
    <?php endforeach;
}

function createModalShow($i){
    ?>
    <div class="modal modal-show-display" tabindex="-1" role="dialog" id="modal-show-<?=$i?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-show-content">
                <div class="modal-header">
                    <h5 class="modal-title">Список дисциплин:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span data-target="#modal-show-<?=$i?>" 
                            style="width: 25px; height: 25px; cursor: pointer; align-items:center;
                                display: flex; justify-content: center;" class="close">&times;
                        </span>
                    </button>
                </div>
                <div class="modal-body modal-show-discipline">
                    <?php removeDiscipline($i);?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function accSub0($title = "", $body = array(),  $index_arr = array())
{
?>
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header accordion-subheader js-accordion-header"><?=$title?></div>
<?php
    if ($body)
    {
        $i = 0;
?>
        <div class="accordion-body__contents">
            <table style="width: 100%;">
                <?php foreach($body as $b): ?>
                    <tr>
                        <td><?= $b ?></td>
                        <td>
                            <?php createBtnAdd($index_arr[$i]);?>
                            <?php createBtnShow($index_arr[$i]);?>
                        </td>
                    </tr>
                    
                    <?php createModalAdd($index_arr[$i]);?>
                    <?php createModalShow($index_arr[$i]);?>

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
        </style>

<?php
    }
?> 
        </div><!-- end of sub accordion item -->
<?php
}

function line($subj = '', $disc = array())
{
    $disciplines = array(
    'RLS' => 'РЛС',
    'YAMP' => 'Языки и МП',
    'APIS' => 'АПИС'
    );
    $row = '<tr><td style="border-bottom: 1px solid black;">'.$subj.'</td>';
    if(!$disc)
    {
        $row .= '<td style="border-bottom: 1px solid black;"></td>';
    }
    else
    {
        $row .= '<td style="border-bottom: 1px solid black;">';
        foreach($disc as $d)
        {
            if($disciplines[$d])
            {
                $row .= '<span class="Disc Disc--yellow" title="Status: Open">'.$disciplines[$d].'</span>';
            }
        }
        $row .= '</td>';
    }
    $row .= '</tr>';
    return $row;
}

$DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=acc user=postgres password=qazxsw";
$acc = pg_connect($DB_CONNECTION_STRING);
if (!$acc) 
{
    echo "Ошибка подключения к БД";
    http_response_code(500);
    exit;
}

$result_header = pg_query($acc, "SELECT * FROM section WHERE level = 1");
$array_header = pg_fetch_all($result_header);

accStart();
?>

<form method="GET" action="db.php" style="display: none;" id="form-addDiscipline">
    <input type="hidden" name="add" value="true"/>
    <input type="hidden" id="input-discipline" name="id_discipline" value=""/>
    <input type="hidden" id="input-line" name="id_line" value=""/>
</form>

<form method="REMOVE" action="db.php" style="display: none;" id="form-removeDiscipline">
    <input type="hidden" name="remove" value="true"/>
    <input type="hidden" id="remove-discipline" name="id_discipline" value=""/>
    <input type="hidden" id="remove-line" name="id_line" value=""/>
</form>

<?php
foreach ($array_header as $header) 
{
	accHeader($header['name'], '');

    $par_id = $header['id'];
    $result_sub = pg_query($acc, "SELECT * FROM section WHERE level = 2 AND parent_id = $par_id");
    $array_sub = pg_fetch_all($result_sub);

    foreach ($array_sub as $sub)
    {
        accSub($sub['name'], '');

        $sub_id = $sub['id'];
        $result_sub0 = pg_query($acc, "SELECT * FROM section WHERE level = 3 AND parent_id = $sub_id");
        $array_sub0 = pg_fetch_all($result_sub0);

        foreach ($array_sub0 as $sub0)
        {
            $sub0_id = $sub0['id'];
            $result_sub1 = pg_query($acc, "SELECT * FROM section WHERE level = 4 AND parent_id = $sub0_id");
            $array_sub1 = pg_fetch_all($result_sub1);

            $tmp_arr_sub1 = array();
            $index_arr = array();

            foreach ($array_sub1 as $sub1)
            {
                array_push($tmp_arr_sub1, line($sub1['name']));
                array_push($index_arr, $sub1['id']);
            }
            accSub0($sub0['name'], $tmp_arr_sub1, $index_arr);
        }
        accSubEnd();
    }
    accHeaderEnd();
}
accEnd();



printFooter(); 
?>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script  src="./script.js"></script>  

<!-- partial -->

