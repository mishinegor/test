<?php
// Запмсь в файл
error_reporting( E_ERROR );

$project_root = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $project_root. '/smarty/';

// put full path to Smarty.class.php
require( $smarty_dir.'libs/Smarty.class.php');
include('mysql_conection.php');
include('functions.php');

$show_param = filter_var($_GET['show'], FILTER_SANITIZE_URL);
$id = filter_var($_GET['id'], FILTER_SANITIZE_URL);
$button_value="Добавить объявление";

    getCities($db);
    getCategories($db);

 $rss_confirm=[
        'checked' =>'Я хочу получать вопросы по объявлению на email',
    ];

$business_type=[
    'private' =>'Частное лицо',
    'corp' =>'Компания'
];

if(isset($_POST['add'])) { // Добавление записи
    if(isset($_GET['del'])){
        unset($_GET['del']);
    }

    $validate_data = [
        'type' => validate_input($_POST['type']),
        'name' => validate_input($_POST['name']),
        'email' => validate_input($_POST['email']),
        'confirm_rss' => validate_input($_POST[$confirm[0]]),
        'phone' => validate_input($_POST['phone']),
        'city' => validate_input($_POST['city']),
        'cat' => validate_input($_POST['cat']),
        'name_ad' => validate_input($_POST['name_ad']),
        'ad_text' => validate_input($_POST['ad_text']),
        'price' => validate_input($_POST['price']),
        'id' => validate_input($_POST['id']),
    ];

    if(isset($_GET['show'])){
        $edition_ad = array_replace($data['ads'][$validate_data['id']], $validate_data);
        $data['ads'][$validate_data['id']] = $edition_ad;
            updateItem($db, $validate_data, $id);
        header('location: index.php');

    } else {
        if(isset($validate_data)) {
            insertItem($db, $validate_data);
        }
    }
}
if (isset($_GET['show'])){
    $button_value="Сохранить объявление";
}

if (isset($_GET['del'])) { //Удаление записи
        delItem($db, $id);
}

getAds($db);

// SMARTY

    $smarty = new Smarty();
    $smarty->compile_check = true;
    $smarty->debugging = true;

    $smarty->template_dir = $smarty_dir.'templates';
    $smarty->compile_dir = $smarty_dir.'templates_c';
    $smarty->cache_dir = $smarty_dir.'cache';
    $smarty->config_dir = $smarty_dir.'configs';


    $smarty->assign('ads', $data['ads']);
    $smarty->assign('button_value', $button_value);
    $smarty->assign('show_param', $show_param);
    $smarty->assign('cat', $categories);
    $smarty->assign('cities', $cities);
    $smarty->assign('rss_confirm', $rss_confirm);
    $smarty->assign('business_type', $business_type);
    $smarty->assign('var_array', $data['ads'][$show_param]);

    $smarty->display('index.tpl');
?>