<?php

function get_item($item) {
    $show_param = $_GET['show'];
    if(isset($show_param)){
        echo $item;
    }
}

function get_result($result, $show_param) {
    if(isset($show_param) && isset($result) && $result='on'){
        echo 'checked';
    };
}

function select_option($items, $selected_item)
{
    foreach ($items as $item_id => $val) {
        $selected = ($selected_item == $item_id ? 'selected' : '');
        echo '<option data-coords=",," ' . $selected . ' value="' . $item_id . '">' . $val . '</option>';
    }
}
 ?>
