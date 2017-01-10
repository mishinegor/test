<?php
    error_reporting( E_ERROR );

    session_start();

    require_once ('functions.php');


// Валидация поле price
    $price = $_POST['price'];

    if(isset($_POST['add']) && !isset($_SESSION['ads'][$_GET['id']])) { // Добавление записи

        if(is_numeric($price) && !empty($price)){
            $_SESSION['ads'][]=$_POST;
        } else {
            $warning = '<p id="notice">*Неправильно заполнено поле цена</p>';
        }
    }

    if(isset($_POST['save'])) {// Редактирование записи
        if(is_numeric($price) && !empty($price)){
            $edition_ad = array_replace($_SESSION['ads'][$_GET['id']], $_POST);
            $_SESSION['ads'][$_GET['id']] = $edition_ad;
            unset($_GET['show'], $_POST['save']);
        } else {
            $warning = '<p id="notice">*Неправильно заполнено поле цена</p>';
        }
    }


    if (isset($_GET['del'])) { //Удаление записи
        unset($_SESSION['ads'][$_GET['id']]);
        unset($_GET['del']);
    }


// массив select cities
        $cities=[
            '543644'=>'Новосибирск',
            '543645'=>'Москва',
            '543646'=>'Минск'
        ];

    // массив select categories

    $categories=[
        '543655'=>'Бытовая техника',
        '543659'=>'Товары для дома',
        '543660'=>'Коампьютерная техника'
    ];



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
            <label><input name="private" type="radio" <?php get_result($_SESSION['ads'][$_GET['id']]['private']); ?>>Частное лицо</label>
            <label><input name="corp" type="radio" <?php get_result($_SESSION['ads'][$_GET['id']]['corp']); ?>>Компания</label>
        </fieldset>

        <fieldset class="contacts_email">
            <label>Ваше имя <input name="name" type="text" value="<?php get_item($_SESSION['ads'][$_GET['id']]['name']); ?>" required></label><br/>
            <label>Ваш email <input name="email" type="email"  value="<?php get_item($_SESSION['ads'][$_GET['id']]['email']); ?>" required></label><br/>
            <label id="checkbox"><input name="confirm_rss" type="checkbox" <?php get_result($_SESSION['ads'][$_GET['id']]['confirm_rss']); ?>>Я хочу получать вопросы по объявлению на email</label><br/>
        </fieldset>

        <fieldset class="contacts_location">
            <label>Ваш телефон <input name="phone" type="text" value="<?php get_item($_SESSION['ads'][$_GET['id']]['phone']); ?>" required></label><br/>
            <label>Ваш город
                <select  name="city">
                    <option disabled>Выберите ваш город</option>
                    <?php select_option($cities, $_SESSION['ads'][$_GET['id']]['city']) ?>
                </select>
            </label><br/>
            <label>Категория товара
                <select  name="cat" required>
                    <option disabled>Выберите категорию</option>
                    <?php select_option($categories, $_SESSION['ads'][$_GET['id']]['cat']) ?>
                </select>
            </label><br/>
        </fieldset>

        <fieldset class="section_ad">
            <label>Заголовок обявления<input name="name_ad" type="text" value="<?php get_item($_SESSION['ads'][$_GET['id']]['name_ad']); ?>" required></label><br/>
            <p>Текст объявления</p>
            <label><textarea name="ad" id="" cols="50" rows="10"  required> <?php get_item($_SESSION['ads'][$_GET['id']]['ad']); ?> </textarea></label><br/>
            <label id="price">Цена <input name="price" type="text" size="5" value="<?php get_item($_SESSION['ads'][$_GET['id']]['price']); ?>"> <span>руб</span> <?php echo $warning;?> </label><br/>
        </fieldset>
        <input type="submit" value="Добавить объявление" class="buttons" name="add">
        <?php
         save_button();
        ?>
        <p id="notice">*Все поля обязательны для заполнения</p>
    </form>

    <?php
        show_table ();
    ?>
</div> <!--End container -->

</body>
</html>