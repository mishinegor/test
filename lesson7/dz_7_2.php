<?php
  // Запмсь в файл
    error_reporting( E_ERROR );
    $filename = 'test.html';

    include('functions.php');

    $show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_URL);

    $button_value="Добавить объявление";


    if(file_exists($filename) && is_writable($filename)) {
        $data_temp = file_get_contents($filename);
        $data = unserialize($data_temp);
    } else {
        die ("Файл". $filename ."недоступен");
    }

if(isset($_POST['add'])) { // Добавление записи
        if(isset($_GET['del'])){
            unset($_GET['del']);
        }

        if(isset($_GET['show']) && isset($data['ads'][$_POST['id']])){
            $edition_ad = array_replace($data['ads'][$_POST['id']], $_POST);
            $data['ads'][$_POST['id']] = $edition_ad;
            header('location: dz_7_2.php');

        } else {
            $data['ads'][]=$_POST;
        }
    }
        if (isset($_GET['show'])){
            $button_value="Сохранить объявление";
    }


    if (isset($_GET['del']) && isset($data['ads'][$_GET['id']])) { //Удаление записи
        unset($data['ads'][$_GET['id']]);
    }

    extract($data['ads'][$id]);

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

    $string_data = serialize($data);
    file_put_contents($filename, $string_data);
    $data_temp = file_get_contents($filename);
    $data_raw= unserialize($data_temp);
    $data['ads']= array_filter($data_raw['ads']);




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
            <label><textarea name="ad" id="" cols="40" rows="10"  required> <?php get_item($ad); ?> </textarea></label><br/>
            <label id="price">Цена <input name="price" type="text" size="5" value="<?php get_item($price); ?>"> <span>руб</span> </label><br/>
        </fieldset>
        <input type="submit" value="<?php echo $button_value ?>" class="buttons" name="add">
        <input type="hidden"  name="id" value="<?php print $show_param; ?>">
        <p id="notice">*Все поля обязательны для заполнения</p>
    </form>

    <?php
        include('show_table.php');
        show_table ($data['ads']);
    ?>
</div> <!--End container -->
</body>
</html>