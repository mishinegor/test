<?php

function show_table () {
    $ads = $_SESSION['ads'];

    if(!empty($ads)) {
        echo '
                    <h2>Ваши объявления: </h2>
    
                    <div id="ad_container">
                                            
                    <table>
                        <tr class="caption">'
            . '<td>Название</td>'
            . '<td>Цена</td>'
            . '<td>Имя владельца</td>'
            . '<td>Удалить</td>';

        echo '</tr>';

        foreach ($ads as $key => $val) {
            echo '<tr>'
                .'<td><a href="?id='.$key.'&&show=1">'.$val['name_ad'].'</a></td>'
                .'<td>'.$val['price'].'</td>'
                .'<td>'.$val['name'].'</td>'
                .'<td><a href="?id='.$key.'&&del=1">Удалить'.'</a></td>';
            echo '</tr>';
        }
        echo '</table>
              </div><!--End ad_container -->';
    }
}

function save_button() {
    $ads = $_SESSION['ads'];
    $save_button ='<input type="submit" class="buttons" name="save" value="Сохранить обявление">'; //Кнопка "Сохранить объявление"
    echo (!empty($ads) ?  $save_button : '');
}


function get_item($item) {
    $show_param = $_GET['show'];
    if(isset($show_param)){
        echo $item;
    }
}

function get_result($result) {
    $show_param = $_GET['show'];
    if(isset($show_param) && isset($result) && $result='on'){
        echo 'checked';
    };
}

function select_option($items, $selected_item) {
    foreach ($items as $item_id => $val) {
        $selected = ($selected_item == $item_id ?  'selected':'');
        echo '<option data-coords=",," '.$selected.' value="'.$item_id.'">'.$val.'</option>';
    }
}


 ?>
