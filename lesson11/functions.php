<?php

function validate_input($data_input) {
    $data_input = trim($data_input);
    $data_input = stripslashes($data_input);
    $data_input = htmlspecialchars($data_input);
    return $data_input;
}

function myLogger($db, $sql, $caller)
{
    // Находим контекст вызова этого запроса.
    $tip = "at ".@$caller['file'].' line '.@$caller['line'];
    // Печатаем запрос (конечно, Debug_HackerConsole лучше).
    echo "<xmp title=\"$tip\">";
    print_r($sql);
    echo "</xmp>";
}


function get_item($item) {
    $show_param = $_GET['show'];
    if(isset($show_param)){
        return $item;
    }
}

function get_result($result, $show_param) {
    if(isset($show_param) && isset($result) && $result='on'){
        return 'checked';
    };
}

function select_option($items, $selected_item)
{
    foreach ($items as $item_id => $val) {
       if($selected_item == $item_id){
            return  $item_id;
       }
    }
}
 ?>
