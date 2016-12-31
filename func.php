<?php
    function calc_discount($bd)
    { //Функция подсчёта общей стоимости со скидкой скидкой
        global $total_coast_discount; // Общая стоимость со скидкой
        static $discount_price_local;

        foreach ($bd as $key => $val) {
            $discount_price_local=$val['стоимость со скидкой'];
            $total_coast_discount += $discount_price_local;
        }

    }
?>