<?php
    error_reporting( E_ERROR );


    include('functions.php');
     $data = array();
     global $id; //id объявления
    $id = $_GET['show'];
    $button_value="Добавить объявление";


    if(isset($_POST['add'])) { // Добавление записи
        if(isset($_COOKIE['ads'])) {
            $data = unserialize($_COOKIE['ads']);
        }

        if(!empty($_POST['id']) && $data['ads'][$_POST['id']]){
            $edition_ad = array_replace($data['ads'][$_POST['id']], $_POST);
            $data['ads'][$_POST['id']] = $edition_ad;
            unset($_GET['show']);
        } else {
            $data['ads'][]=$_POST;
        }
        $string_data = serialize($data);
        setcookie('ads', $string_data, time()+3600*24*7);

    } else {
        if (isset($_GET['show'])){
            $button_value="Сохранить объявление";
        }
        $data = unserialize($_COOKIE['ads']);
    }

    if (isset($_GET['del']) && isset($data['ads'][$_GET['id']])) { //Удаление записи
        unset($data['ads'][$_GET['id']]);
        $string_data = serialize($data);
        setcookie('ads', $string_data, time()+3600*24*7);
    }

    var_dump($data);
    var_dump($_POST);



    //Параметры GET
    $ads = $data['ads'];
    $show_param = $_GET['show'];
    $name = $data['ads'][$_GET['id']]['name'];
    $email = $data['ads'][$_GET['id']]['email'];
    $radio_private = $data['ads'][$_GET['id']]['private'];
    $radio_corp = $data['ads'][$_GET['id']]['corp'];
    $checkbox_confirm = $data['ads'][$_GET['id']]['confirm_rss'];
    $phone = $data['ads'][$_GET['id']]['phone'];
    $city = $data['ads'][$_GET['id']]['city'];
    $cat = $data['ads'][$_GET['id']]['cat'];
    $name_ad=$data['ads'][$_GET['id']]['name_ad'];
    $ad_text = $data['ads'][$_GET['id']]['ad'];
    $price = $data['ads'][$_GET['id']]['price'];

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
            <label><input name="private" type="radio" <?php get_result($radio_private, $show_param); ?>>Частное лицо</label>
            <label><input name="corp" type="radio" <?php get_result($radio_corp, $show_param); ?>>Компания</label>
        </fieldset>

        <fieldset class="contacts_email">
            <label>Ваше имя <input name="name" type="text" value="<?php get_item($name); ?>" required></label><br/>
            <label>Ваш email <input name="email" type="email"  value="<?php get_item($email); ?>" required></label><br/>
            <label id="checkbox"><input name="confirm_rss" type="checkbox" <?php get_result($checkbox_confirm, $show_param); ?>>Я хочу получать вопросы по объявлению на email</label><br/>
        </fieldset>

        <fieldset class="contacts_location">
            <label>Ваш телефон <input name="phone" type="text" value="<?php get_item($phone); ?>" required></label><br/>
            <label>Ваш город
                <select  name="city">
                    <option disabled>Выберите ваш город</option>
                    <?php select_option($cities, $city) ?>
                </select>
            </label><br/>
            <label>Категория товара
                <select  name="cat" required>
                    <option disabled>Выберите категорию</option>
                    <?php select_option($categories, $cat) ?>
                </select>
            </label><br/>
        </fieldset>

        <fieldset class="section_ad">
            <label>Заголовок обявления<input name="name_ad" type="text" value="<?php get_item($name_ad); ?>" required></label><br/>
            <p>Текст объявления</p>
            <label><textarea name="ad" id="" cols="50" rows="10"  required> <?php get_item($ad_text); ?> </textarea></label><br/>
            <label id="price">Цена <input name="price" type="text" size="5" value="<?php get_item($price); ?>"> <span>руб</span> </label><br/>
        </fieldset>
        <input type="submit" value="<?php echo $button_value ?>" class="buttons" name="add">
        <input type="hidden"  name="id" value="<?php print $id; ?>">
        <p id="notice">*Все поля обязательны для заполнения</p>
    </form>

    <?php
        include('show_table.php');
        show_table ($ads);
    ?>
</div> <!--End container -->

</body>
</html>