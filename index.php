<?php
include ('utils.php');
printHeader('Кормушка', '', array('https://fonts.googleapis.com/css?family=Open+Sans', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css', './style.css'));

?>



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
                    <!-- Добавляем индекс в конец id и data-target -->
                    
                        <button id="button<?=$index_arr[$i]?>" data-target="#modal<?=$index_arr[$i]?>" 
                                style="float: right; transition: background-color 1s;
                                       border: none; color: white; margin: 5px; border-radius: 5px; cursor: pointer;" 
                                type="button" class="btn-add">Добавить дисциплину
                        </button>
                    
                    <button id="button-show-<?=$index_arr[$i]?>" data-target="#modal-show-<?=$index_arr[$i]?>" 
                            style="float: right; transition: background-color 1s;
                                   border: none; color: white; margin: 5px; border-radius: 5px; cursor: pointer;" 
                            type="button" class="btn-show">Посмотреть дисциплины
                    </button>
                </td>
            </tr>
            <!-- Добавляем индекс в конец id и data-target и скрываем модальное окно с помощью класса modal-display -->
            <div class="modal-display" id="modal<?=$index_arr[$i]?>" style="display: none; position: fixed; right: 30px; 
                         z-index: 100; background-color: #acaeb8; width: 500px; height: 60%; bottom: 50px;
                         border: grey 1px solid; border-radius: 5px; "> 
                <div class="modal-content">
                    <div style='display: flex; justify-content:space-between;'>
                        <h4 style='font-size:25px; margin: 0 auto;'>Выберите дисциплину:</h4>
                        <span data-target="#modal<?=$index_arr[$i]?>" 
                            style="background-color: red; width: 25px; height: 25px; cursor: pointer; align-items:center; color: #a82c2c;
                                   border-radius: 5px; float: right; font-weight: bold; font-size: 32px; display: flex; justify-content: center;" 
                            class="close">&times;
                        </span>
                    </div>
                    <div class="modal-discipline" style='overflow:auto; display: flex; flex-wrap: wrap; gap: 10px;
                                                         padding: 10px;'>
                        <?php
                            $DB_CONNECTION_STRING = "host=127.0.0.1 port=5432 dbname=acc user=postgres password=qazxsw"; 
    
                            // подключение к БД
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
                                <span style='background-color: #9ea82c; border: #424520 1px solid; cursor: pointer;  
                                             border-radius: 5px; min-width: 30px; font-size: 20px; padding: 5px;'
                                             onmouseover="this.style.backgroundColor = '#e7f73d'" 
                                             onmouseout="this.style.backgroundColor = '#9ea82c'" class='disc' data-id='<?=$id?>' onclick="addDiscLineId(<?=$index_arr[$i]?>, <?=$value['id']?>)">
                                             <?= $value['name'] ?> 
                                </span>
                            <?php endforeach;?>
                    </div>
                </div>
            </div>
            <!-- Добавляем индекс в конец id и data-target и скрываем модальное окно с помощью класса modal-display -->
            <div class="modal-show-display" id="modal-show-<?=$index_arr[$i]?>" style="display: none; position: fixed; right: 30px; 
                         z-index: 100; background-color: #acaeb8; width: 500px; height: 60%; bottom: 50px;
                         border: grey 1px solid; border-radius: 5px;"> 
                <div class="modal-show-content">
                    <span data-target="#modal-show-<?=$index_arr[$i]?>" 
                    style="background-color: red; width: 25px; height: 25px; cursor: pointer; align-items:center; color: #a82c2c;
                           border-radius: 5px; float: right; font-weight: bold; font-size: 32px; display: flex; justify-content: center;" 
                          class="close">&times;</span>
                    <div class="modal-show-discipline">
                        
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
                // Получаем модальное окно по data-target
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
                // Получаем модальное окно по data-target
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
</script>

<style>
    .btn-add.pressed {
        background-color: #141414;
    }
    .btn-add{
        background-color: #3F51B5;
    }
    .btn-add:hover{
        background-color: #7584d5;
    }
    .btn-add.disabled{
        pointer-events: none;
        opacity: 0.5;
    }
    .btn-show.pressed {
        background-color: #141414;
    }
    .btn-show{
        background-color: #cde95d;
    }
    .btn-show:hover{
        background-color: #cfff11;
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
    
// подключение к БД
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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script><script  src="./script.js"></script>  

<!-- partial -->

