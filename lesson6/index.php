<?php
    error_reporting( E_ERROR );
    session_start();


    if(isset($_POST['add'])) {
            $_SESSION['ads'][]=$_POST;
    }

    if (isset($_GET['del'])) { //Удаление записи
        unset($_SESSION['ads'][$_GET['id']]);
    }

    // обработка select cities
        $cities=[
            '543644'=>'Новосибирск',
            '543645'=>'Москва',
            '543646'=>'Минск'
        ];

    // обработка select categories

    $categories=[
        '543655'=>'Бытовая техника',
        '543659'=>'Товары для дома',
        '543660'=>'Коампьютерная техника'
    ];

    var_dump($_SESSION);
    var_dump($_POST);


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
            <label><input name="private" type="radio" <?php echo ($_SESSION['ads'][$_GET['show_id']]['private']=="on" ?  'checked':''); ?>>Частное лицо</label>
            <label><input name="corp" type="radio" <?php echo ($_SESSION['ads'][$_GET['show_id']]['corp']=="on" ?  'checked':''); ?>>Компания</label>
        </fieldset>

        <fieldset class="contacts_email">
            <label>Ваше имя <input name="name" type="text" value="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['name']: " ");?>" required></label><br/>
            <label>Ваш email <input name="email" type="email"  value="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['email']: " ");?>" required></label><br/>
            <label id="checkbox"><input name="confirm_rss" type="checkbox" <?php echo ($_SESSION['ads'][$_GET['show_id']]['confirm_rss']=="on" ?  'checked':''); ?>>Я хочу получать вопросы по объявлению на email</label><br/>
        </fieldset>

        <fieldset class="contacts_location">
            <label>Ваш телефон <input name="phone" type="text" value="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['phone']: " ");?>" required></label><br/>
            <label>Ваш город
                <select  name="city">
                    <option disabled>Выберите ваш город</option>
                    <?php foreach ($cities as $city_id => $city) {
                        $selected = ($_SESSION['ads'][$_GET['show_id']]['city']==$city_id ?  'selected':'');
                        echo '<option data-coords=",," '.$selected.' value="'.$city_id.'">'.$city.'</option>';
                    }

                    ?>
                </select>
            </label><br/>
            <label>Категория товара
                <select  name="cat" required>
                    <option disabled>Выберите категорию</option>
                    <?php foreach ($categories as $cat_id => $cat) {
                        $selected = ($_SESSION['ads'][$_GET['show_id']]['cat']==$cat_id ?  'selected':'');
                        echo '<option data-coords=",," '.$selected.' value="'.$cat_id.'">'.$cat.'</option>';
                    }
                    ?>
                </select>
            </label><br/>
        </fieldset>

        <fieldset class="section_ad">
            <label>Заголовок обявления<input name="name_ad" type="text" value="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['name_ad']: " ");?>" required></label><br/>
            <p>Текст объявления</p>
            <label><textarea name="ad" id="" cols="50" rows="10" value="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['ad']: " ");?>" required></textarea></label><br/>
            <label id="price">Цена <input name="price" type="text" size="5" value="<?php echo (isset($_GET['show_id']) ? $_SESSION['ads'][$_GET['show_id']]['price']: " ");?>"> <span>руб</span></label><br/>
        </fieldset>
        <input type="submit" value="Добавить объявление" class="buttons" name="add">
        <p id="notice">*Все поля обязательны для заполнения</p>
    </form>

    <?php

            if(!empty($_SESSION['ads'])) {
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

                foreach ($_SESSION['ads'] as $key => $val) {
                    echo '<tr>'
                        .'<td><a href="?show_id='.$key.'">'.$val['name_ad'].'</a></td>'
                        .'<td>'.$val['price'].'</td>'
                        .'<td>'.$val['name'].'</td>'
                        .'<td><a href="?id='.$key.'&&del=1">Удалить'.'</a></td>';
                    echo '</tr>';
                }
                echo '</table>
          </div><!--End ad_container -->';
            }
    ?>
</div> <!--End container -->

</body>
</html>