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

$cities = getCities($db);
$categories = getCategories($db);

$rss_confirm=[
    'checked' =>'Я хочу получать вопросы по объявлению на email'
];

$business_type=[
    'private' =>'Частное лицо',
    'corp' =>'Компания'
];
$warnings = [
    1 => 'Не удалось добавить объявление',
    2 => 'Не удалось редактировать объявление',
    3 => 'Неправильно заполнено поле email',
    4 => 'Неправильно заполнено поле телефон',
    5 => 'Неправильно заполнено поле цена',
];

$data = getAds($db);

if(isset($_POST['add'])) { // Добавление записи
    if(isset($_GET['del'])){
        unset($_GET['del']);
    }

    $validate_data = [
        'type' => validate_input($_POST['type']),
        'name' => validate_input($_POST['name']),
        'email' => validate_input($_POST['email']),
        'confirm_rss' => validate_input($_POST['confirm'][0]),
        'phone' => validate_input($_POST['phone']),
        'city_id' => validate_input($_POST['city']),
        'category_id' => validate_input($_POST['cat']),
        'name_ad' => validate_input($_POST['name_ad']),
        'ad_text' => validate_input($_POST['ad_text']),
        'price' => validate_input($_POST['price']),
        'id' => validate_input($_POST['id']),
    ];
        $validate_email = filter_var($validate_data['email'], FILTER_VALIDATE_EMAIL);
        $validate_phone = filter_var($validate_data['phone'], FILTER_VALIDATE_INT);
        $validate_price = filter_var($validate_data['price'], FILTER_VALIDATE_INT);

    if(isset($_GET['show'])){
        $edition_ad = array_replace($data['ads'][$validate_data['id']], $validate_data);
        $data['ads'][$validate_data['id']] = $edition_ad;
        if(isset($data['ads'][$validate_data['id']]) && $validate_email && $validate_phone && $validate_price){
            updateItem($db, $validate_data, $id);
            header('location: index.php');
        } else {
            check_data($validate_data['email'], $validate_email, $warnings[3]);
            check_data($validate_data['phone'], $validate_phone, $warnings[4]);
            check_data($validate_data['price'], $validate_price, $warnings[5]);
        }


    } else {
        if(!empty($validate_data) && $validate_email && $validate_phone && $validate_price) {
                insertItem($db, $validate_data);
            } else {
                 check_data($validate_data['email'], $validate_email, $warnings[3]);
                 check_data($validate_data['phone'], $validate_phone, $warnings[4]);
                 check_data($validate_data['price'], $validate_price, $warnings[5]);
            }
        }
    }
if (isset($_GET['show'])){
    $button_value="Сохранить объявление";
}



if (isset($_GET['del']) && isset($data['ads'][$id])) { //Удаление записи
    delItem($db, $id);
}
$data = getAds($db);

$smarty_data=[
    'button_value' => $button_value,
    'show_param' => $show_param,
    'cat'=> $categories,
    'cities' => $cities,
    'rss_confirm'=> $rss_confirm,
    'business_type' => $business_type,
    'alert' => $alert

];

// SMARTY

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = true;

$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';


$smarty->assign('ads', $data['ads']);
$smarty->assign('smarty_data', $smarty_data);
$smarty->assign('var_array', $data['ads'][$show_param]);

$smarty->display('index.tpl');
?>