﻿<?php
    error_reporting( E_ERROR );
    session_start();
    $id = uniqid(); //генерируем у никальный id обявления

    if(isset($_POST['add'])) {
        $_SESSION['ads'][$id]=$_POST;
    }

    if (isset($_GET['del'])) { //Удаление записи
        unset($_SESSION['ads'][$_GET['id']]);
    }


    var_dump($_GET);
    var_dump($_POST);
    var_dump(($_SESSION['ads']));
    //session_unset();

?>
<!doctype html>
<html lang="en-ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Задание 6 Форма отправки объявления</title>
</head>
<body>
<div class="container">
    <h1>Подайте объявление:</h1>
    <form  method="post" id="add">
        <fieldset class="radio">
            <label><input name="subject[0]=on" type="radio" >Частное лицо</label>
            <label><input name="subject[0]=off" type="radio">Компания</label>
        </fieldset>

        <fieldset class="contacts_email">
            <label>Ваше имя <input name="name" type="text" placeholder="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['name']: " ");?>" required></label><br/>
            <label>Ваш email <input name="email" type="email"  placeholder="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['email']: " ");?>" required></label><br/>
            <label id="checkbox"><input name="confirm_rss" type="checkbox">Я хочу получать вопросы по объявлению на email</label><br/>
        </fieldset>

        <fieldset class="contacts_location">
            <label>Ваш телефон <input name="phone" type="text" placeholder="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['phone']: " ");?>" required></label><br/>
            <label>Ваш город
                <select  name="cities">
                    <option disabled>Выберите ваш город</option>
                    <option selected value="Новосибирск">Новосибирск</option>
                    <option  value="Москва">Москва</option>
                    <option value="Минск">Минск</option>
                </select>
            </label><br/>
            <label>Категория товара
                <select  name="cat" required>
                    <option disabled>Выберите категорию</option>
                    <option selected value="Бытовая техника" >Бытовая техника</option>
                    <option  value="Тоывры для дома">Тоывры для дома</option>
                    <option value="Компьютерная техника">Компьютерная техника</option>
                </select>
            </label><br/>
        </fieldset>

        <fieldset class="section_ad">
            <label>Заголовок обявления<input name="name_ad" type="text" placeholder="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['name_ad']: " ");?>" required></label><br/>
            <p>Текст объявления</p>
            <label><textarea name="ad" id="" cols="50" rows="10" placeholder="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['ad']: " ");?>" required></textarea></label><br/>
            <label id="price">Цена <input name="price" type="text" size="5" placeholder="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['price']: " ");?>"> <span>руб</span></label><br/>
        </fieldset>
        <input type="submit" value="Добавить объявление" class="buttons" name="add">
        <p id="notice">*Все поля обязательны для заполнения</p>
    </form>

    <h2>Ваши объявления: </h2>

    <div id="ad_container">


            <?php

            if(isset($_SESSION['ads'])) {
                echo '<table>
                    <tr class="caption">'
                    . '<td>Название</td>'
                    . '<td>Цена</td>'
                    . '<td>Имя владельца</td>'
                    . '<td>Удалить</td>';

                echo '</tr>';

                foreach ($_SESSION['ads'] as $key => $val) {
                    echo '<tr>'
                        .'<td><a href="?show_id='.$key.'">'.$val['name_ad'].'</a></td>'
                        .'<td>'.$val['price'].'</td>'
                        .'<td>'.$val['name'].'</td>'
                        .'<td><a href="?id='.$key.'">Удалить'.'</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            ?>
    </div><!--End ad_container -->
</div> <!--End container -->

</body>
</html>