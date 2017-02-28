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



$cities = getCities($db);
$categories = getCategories($db);
$rss_confirm = getCheckbox($db);
$business_type=getbusiness_type($db);
$data = getAds($db);
$ad = $data['ads'][$show_param];



if(isset($_POST['add'])) { // Добавление записи
    if (isset($_GET['del'])) {
        unset($_GET['del']);
    }
    $validate_data = validate_input($_POST);
    $warnings = validation_form($validate_data);

    if ($warnings['status'] === true) {
        if (isset($_GET['show'])) {
            $edition_ad = array_replace($data['ads'][$validate_data['id']], $validate_data);
            $data['ads'][$validate_data['id']] = $edition_ad;
            if (isset($data['ads'][$validate_data['id']])) {
                updateItem($db, $validate_data, $id);
                header('location: index.php');
            }

        } else {
            if (!empty($validate_data)) {
                insertItem($db, $validate_data);
            }
        }
    } else {
        $ad = $_POST;
    }
}
        if (isset($_GET['show'])) {
            $button_value = "Сохранить объявление";
        } else {
            $button_value = "Добавить объявление";
        }

    if (isset($_GET['del']) && isset($data['ads'][$id])) { //Удаление записи
        delItem($db, $id);
    }

$data = getAds($db);

$alert = $warnings['message']

;

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
$smarty->assign('ad', $ad);

$smarty->display('index.tpl');
?>