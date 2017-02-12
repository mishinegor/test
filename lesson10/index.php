<?php

error_reporting( E_ERROR );

include('mysql_conection.php');

include('functions.php');

$show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
$id = filter_var($_GET['id'], FILTER_SANITIZE_URL);

$button_value="Добавить объявление";


mysqli_set_charset($db, 'utf8');

    $cities_result = $db->select('SELECT *  FROM cities');
    foreach($cities_result as $key => $val) {
        $cities[$val['id']] = $val['city_name'];
    }

    $cat_result = $db->select('SELECT * FROM categories');
    foreach($cat_result as $key => $val) {
        $categories[$val['id']] = $val['category'];
    }


$validate_data = [
    'name' => validate_input($_POST['name']),
    'email' => validate_input($_POST['email']),
    'phone' => validate_input($_POST['phone']),
    'name_ad' => validate_input($_POST['name_ad']),
    'ad' => validate_input($_POST['ad']),
    'price' => validate_input($_POST['price'])
    ];




    $update_query = $db->query("UPDATE  ads SET ID = ?d, PRIVATE = ?, CORP = ?, NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?d, CATEGORY = ?d, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?d",
        $id, $_POST['private'], $_POST['corp'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'],$_POST['city'], $_POST['cat'], $validate_data['name_ad'], $validate_data['ad'], $validate_data['price'], $_POST['id']);

if(isset($_POST['add'])) { // Добавление записи
    if(isset($_GET['del'])){
        unset($_GET['del']);
    }

    if(isset($_GET['show'])){
        $edition_ad = array_replace($data['ads'][$_POST['id']], $_POST);
        $data['ads'][$_POST['id']] = $edition_ad;
        $update_query = $db->query("UPDATE  ads SET ID = ?d, PRIVATE = ?, CORP = ?, NAME = ?, EMAIL = ?, CONFIRM_RSS = ?, PHONE = ?, CITY = ?d, CATEGORY = ?d, NAME_AD = ?, AD_TEXT = ?, PRICE = ? WHERE id=?d",
            $id ,$_POST['private'], $_POST['corp'], $validate_data['name'], $validate_data['email'], $validate_data['confirm_rss'], $validate_data['phone'],$_POST['city'], $_POST['cat'], $validate_data['name_ad'], $validate_data['ad'], $validate_data['price'], $_POST['id']);

        header('location: index.php');

    } else {
        $add_query = $db->query("INSERT INTO ads ( PRIVATE, CORP, NAME, EMAIL, CONFIRM_RSS, PHONE, CITY, CATEGORY, NAME_AD, AD_TEXT, PRICE) VALUES (?, ?, ?, ?, ?, ?, ?d, ?d, ?, ?, ?d)",
            $_POST['private'], $_POST['corp'], $validate_data['name'], $validate_data['email'], $_POST['confirm_rss'], $validate_data['phone'],$_POST['city'], $_POST['cat'], $validate_data['name_ad'], $validate_data['ad'], $validate_data['price']);

    }
}
if (isset($_GET['show'])){
    $button_value="Сохранить объявление";
}

if (isset($_GET['del'])) { //Удаление записи
    $del_query = $db->query("DELETE FROM ads WHERE id = ?d", $id);
}

$data['ads'] = $db->select('SELECT ads.id AS ARRAY_KEY, ads.name, email, confirm_rss, phone, city_name, categories.category, name_ad, ad_text, price 
                    FROM ads LEFT JOIN sellers on (sellers.id=ads.name)LEFT JOIN cities on (cities.id=ads.city) LEFT JOIN categories on (categories.id=ads.category)');

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