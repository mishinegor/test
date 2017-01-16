<?php

    function save_button($ads) {

        $save_button ='<input type="submit" class="buttons" name="save" value="Сохранить обявление">'; //Кнопка "Сохранить объявление"
        echo (!empty($ads) ?  $save_button : '');
    }

    function show_table ($ads) {

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
