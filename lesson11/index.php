<?php

error_reporting( E_ERROR );

$project_root = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $project_root. '/smarty/';

// put full path to Smarty.class.php
require( $smarty_dir.'libs/Smarty.class.php');
include('mysql_conection.php');
include('ad.php');
include('show_ads.php');
include('functions.php');





$show_data = new ShowAds();

if(isset($_POST['add'])) { // Добавление записи
    if (isset($_GET['del'])) {
        unset($_GET['del']);
    }
    $new_ad = new Ad();
    $warnings = $new_ad->validationForm($_POST);

    if ($new_ad->warnings['status'] === true) {
        if (isset($_GET['show'])) {
            $new_ad->updateItem($db);
            header('location: index.php');
        } else {
            if (!empty($new_ad->validate_data)) {

                $new_ad->insertItem($db);
            }
        }
    }
}   else {
        $show_data->ad = $_POST;
    }


if (isset($_GET['del'])) { //Удаление записи
    $show_data->delItem($db);
}

$data = $show_data->getAds($db);
$show_data->ad = $data['ads'][$show_data->getShowparam()];


$smarty_data=[
    'button_value' => $show_data->getButtonValue(),
    'show_param' => $show_data->show_param,
    'cat'=> $show_data->getCategories($db),
    'cities' => $show_data->getCities($db),
    'rss_confirm'=> $show_data->getCheckbox($db),
    'business_type' => $show_data->getBusinessType($db),
    'alert' =>  $new_ad->warnings['message']

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
$smarty->assign('ad', $show_data->ad);

$smarty->display('index.tpl');
?>