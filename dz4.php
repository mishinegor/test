<?php

/*
* Задание Урока 4.
*  Вы проектируете интернет магазин. Посетитель на вашем сайте создал
*  следующий заказ (цена, количество в заказе и остаток на складе генерируются автоматически):
 */
$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
';
$bd=  parse_ini_string($ini_string, true);


/*
 *
 * - Вам нужно вывести корзину для покупателя, где указать:
 * 1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
 * 2) В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, каково общее количество товара, какова общая сумма заказа
 * - Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя о том, что нужного количества товара не оказалось на складе
 * - Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка детская велосипед" в количестве >=3 штук, то на эту позицию ему
 * автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)
 * 3) у каждого товара есть автоматически генерируемый скидочный купон diskont, используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
 * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%
 *
 * В коде должно быть использовано:
 * - не менее одной функции
 * - не менее одного параметра для функции
 * операторы if, else, switch
 * статические и глобальные переменные в теле функции
 *
 */

// Общая сумма заказа и колличество
$total_cost = 0; // Общая стоимость
$total_amount = 0; // Общее колличество
$discount_price=0; // Цена со скидкой
$discount_procent=0;

// Уведамления
    $product=" ";
    $notice=" " ; // Сообщение

foreach ($bd as $key => $val) {
    // Вывод уведамления
    if ($val['осталось на складе'] < $val['количество заказано']) {
        $bd[$key]['наличие товара'] = "Нет в наличии"; // Добавляем  наличие товара в массив $bd
    } else {
        $bd[$key]['наличие товара'] = "Товар в наличии";
    }

    // Подсчёт общего колличества и стоимости
    $total_amount += $val['количество заказано'];
    $bd[$key]['стоимость'] = $val['количество заказано'] * $val['цена'];// Добавляем стоимость в массив $bd
    $total_cost += $val['количество заказано'] * $val['цена'];

    // Скидка для велосипедов 30%
    if ($key == 'игрушка детская велосипед' && $val['количество заказано'] >= 3 && $val['количество заказано'] <= $val['осталось на складе']) {
        $val['diskont'] = 'diskont3';
    };

    switch ($val['diskont']) { // Расчет скидки
        case 'diskont0':
            $discount_procent = 0;
            $discount_price = $val['цена']*1;
            break;
        case 'diskont1':
            $discount_procent = 10;
            $discount_price = $val['цена']*0.9;
            break;
        case 'diskont2':
            $discount_procent = 20;
            $discount_price = $val['цена']*0.8;
            break;
        case 'diskont3':
            $discount_procent = 30;
            $discount_price = $val['цена']*0.7;
            break;
    }

    $bd[$key]['стоимость со скидкой']=$discount_price*$val['количество заказано']; // Добавляем стоимость со скидкой в массив $bd
    $bd[$key]['скидка']=$discount_procent.'%'; // Добавляем скидку в массив $bd
}
function calc_discount($bd) { //Функция подсчёта общей стоимости со скидкой скидкой
    global $total_coast_discount; // Общая стоимость со скидкой

    foreach ($bd as $key => $val) {
        $total_coast_discount+=$val['стоимость со скидкой'];
    }
}
calc_discount($bd);
?>

<!doctype html>
<html lang="ru-en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <title>Корзина товаров</title>
</head>
    <body>
        <div class="container">
            <h1>Мои заказы:</h1>
            <table>
                <tr class="caption">
                    <td>Наименование товара</td>
                    <td>Цена</td>
                    <td>Колличество</td>
                    <td>Стоимость товара</td>
                    <td>Наличие товара</td>
                    <td>Скидка по купону</td>
                    <td>Стоиммость со скидкой</td>
                    <td>Остаток на складе</td>

                </tr>

                <?php
                foreach ($bd as $key => $val) {
                    echo '<tr>'
                        .'<td>'.$key.'</td>'
                        .'<td>'.$val['цена'].'</td>'
                        .'<td>'.$val['количество заказано'].'</td>'
                        .'<td>'.$val['стоимость'].'</td>'
                        .'<td>'.$val['наличие товара'].'</td>'
                        .'<td>'.$val['скидка'].'</td>'
                        .'<td>'.$val['стоимость со скидкой'].'</td>'
                        .'<td>'.$val['осталось на складе'].'</td>';
                    echo '</tr>';
                }
                ?>
            </table>

            <h2>Внимание акция:</h2>
            <p>При покупке 3-х детских велосипедов скидка 30%</p>

            <h2>Итого:</h2>
            <table>
                <tr class="caption">
                    <td>Колличество наименований</td>
                    <td>Общее колличество закаов</td>
                    <td>Общая стоимость заказа</td>
                    <td>Общая стоимость со скидкой</td>
                </tr>

                <?php
                echo '<tr>'
                    .'<td>'.count($bd).'</td>'
                    .'<td>'."$total_amount".'</td>'
                    .'<td>'.$total_cost.'</td>'
                    .'<td>'.$total_coast_discount.'</td>';
                echo '</tr>';
                ?>
            </table>
    </body>
</html>