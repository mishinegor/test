<?php
    function calc_discount($bd)
    { //Функция подсчёта общей стоимости со скидкой скидкой
        global $total_coast_discount; // Общая стоимость со скидкой

        foreach ($bd as $key => $val) {
            $total_coast_discount += $val['стоимость со скидкой'];
        }

    }
?>