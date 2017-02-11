<?php
// Запмсь в файл
error_reporting( E_ERROR );



include('functions.php');

$show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
$id = filter_var($_GET['id'], FILTER_SANITIZE_URL);

$button_value="Добавить объявление";

include('mysql_conection.php');

mysqli_set_charset($db, 'utf8');

    $cities_query = mysqli_query($db, 'select * from cities') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db));// вывод городов из БД
    $cities_result = mysqli_fetch_all($cities_query, MYSQLI_ASSOC);
    foreach($cities_result as $key => $val) {
        $cities[$val['id']] = $val['city_name'];
    }

    $cat_query = mysqli_query($db, 'select * from categories') or die( "Невозвожно выполнить запрос, код ошибки :".mysqli_error($db)); // вывод категорий из БД
    $cat_result = mysqli_fetch_all($cat_query, MYSQLI_ASSOC);
    foreach($cat_result as $key => $val) {
        $categories[$val['id']] = $val['category'];
    }


    $extract_sql = "SELECT ads.id, ads.name, email, confirm_rss, phone, city_name, categories.category, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)";

    $validate_data = [
    'name' => validate_input($_POST['name']),
    'email' => validate_input($_POST['email']),
    'phone' => validate_input($_POST['phone']),
    'name_ad' => validate_input($_POST['name_ad']),
    'ad' => validate_input($_POST['ad']),
    'price' => validate_input($_POST['price'])
    ];

    $add_query = mysqli_prepare($db, "INSERT INTO ads ( PRIVATE, CORP, NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($add_query, 'ssssssiissi', $_POST['private'], $_POST['corp'], $validate_data['name'], $validate_data['email'], $_POST['confirm_rss'], $validate_data['phone'],$_POST['city'], $_POST['cat'], $validate_data['name_ad'], $validate_data['ad'], $validate_data['price']);


    $del_query = mysqli_prepare($db, "DELETE FROM ads WHERE id = ?");
    mysqli_stmt_bind_param($del_query, 'i', $id);


if(isset($_POST['add'])) { // Добавление записи
    if(isset($_GET['del'])){
        unset($_GET['del']);
    }

    if(isset($_GET['show'])){
        $edition_ad = array_replace($data['ads'][$_POST['id']], $_POST);
        $data['ads'][$_POST['id']] = $edition_ad;
        $update_query = mysqli_prepare($db, "UPDATE  ads SET ID = ?, PRIVATE = ?, CORP = ?, NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?, CATEGORY = ?, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?");
        mysqli_stmt_bind_param($update_query, 'issssssiissii', $id ,$_POST['private'], $_POST['corp'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'],$_POST['city'], $_POST['cat'], $validate_data['name_ad'], $validate_data['ad'], $validate_data['price'], $_POST['id']);

        mysqli_stmt_execute($update_query);
        header('location: index.php');

    } else {
        if($add_query) {
            mysqli_stmt_execute($add_query);
        }
    }
}
if (isset($_GET['show'])){
    echo "1";
    $button_value="Сохранить объявление";
}

if (isset($_GET['del'])) { //Удаление записи
    if($del_query) {
        mysqli_stmt_execute($del_query);
    }
}

$data_query = mysqli_query($db,  $extract_sql); // вывод обявлений из БД
$data_result = mysqli_fetch_all($data_query, MYSQLI_ASSOC);
foreach ($data_result as $key => $val) {
    $data['ads'][$val['id']]=$val;
}

$var_array =[
    'name' => get_item($data['ads'][$id]['name']),
    'email' => get_item($data['ads'][$id]['email']),
    'radio_private' => get_result($data['ads'][$id]['private'], $show_param),
    'radio_corp' => get_result($data['ads'][$id]['corp'], $show_param),
    'checkbox_confirm' => get_result($data['ads'][$id]['confirm_rss'], $show_param),
    'phone' => get_item($data['ads'][$id]['phone']),
    'city_id' => select_option($cities, $data['ads'][$id]['city_name']),
    'cat_id' => select_option($cities, $data['ads'][$id]['category']),
    'name_ad' =>  get_item($data['ads'][$id]['name_ad']),
    'ad_text' =>  get_item($data['ads'][$id]['ad_text']),
    'price' => get_item($data['ads'][$id]['price']),
    'show_param' => $show_param,
    'button_value' => $button_value
];

//Массив переменных

// SMARTY

    $project_root = $_SERVER['DOCUMENT_ROOT'];
    $smarty_dir = $project_root. '/smarty/';

    // put full path to Smarty.class.php
    require( $smarty_dir.'libs/Smarty.class.php');

    $smarty = new Smarty();
    $smarty->compile_check = true;
    $smarty->debugging = true;

    $smarty->template_dir = $smarty_dir.'templates';
    $smarty->compile_dir = $smarty_dir.'templates_c';
    $smarty->cache_dir = $smarty_dir.'cache';
    $smarty->config_dir = $smarty_dir.'configs';


    $smarty->assign('ads', $data['ads']);
    $smarty->assign('cat', $categories);
    $smarty->assign('cities', $cities);
    $smarty->assign('var_array', $var_array);



    $smarty->display('index.tpl');
?>