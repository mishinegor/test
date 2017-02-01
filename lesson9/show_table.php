<?php

    function show_table ($ads) {

        if(!empty($ads)) {
            echo '        
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
                    .'<td><a href="?id='.$key.'&show='.$key.'">'.$val['name_ad'].'</a></td>'
                    .'<td>'.$val['price'].'</td>'
                    .'<td>'.$val['name'].'</td>'
                    .'<td><a href="?id='.$key.'&del=1">Удалить'.'</a></td>';
                echo '</tr>';

            }
            echo '</table>
                  </div><!--End ad_container -->';
        }
    }
