<?php

error_reporting( E_ERROR );

$project_root = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $project_root. '/smarty/';

// put full path to Smarty.class.php
require( $smarty_dir.'libs/Smarty.class.php');
include('mysql_conection.php');

include('ads.php');
include('data_store.php');

include('functions.php');

$main = DataStore::instance();

if(isset($_POST['add'])) { // Добавление записи
    if (isset($_GET['del'])) {
        unset($_GET['del']);
    }

    $warnings = $main->getWarnings();

    if ($warnings['status'] === true) {
        $new_ad = new Ads($_POST);
        $new_ad->insertItem($db);
        }
    }
    else {
        $main->ad = $_POST;
    }

if (isset($_GET['del'])) { //Удаление записи
    $main->delItem($db);
}
$main->getAds($db);

if($main->getShowparam()){
    $main->ad = $main->data['ads'][$main->getShowparam()];
}


$smarty_data=[
    'button_value' => $main->getButtonValue(),
    'show_param' => $main->show_param,
    'cat'=> $main->getCategories($db),
    'cities' => $main->getCities($db),
    'rss_confirm'=> $main->getCheckbox($db),
    'business_type' => $main->getBusinessType($db),
    'alert' =>  $warnings['message']
];

// SMARTY

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = true;

$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';


$smarty->assign('ads', $main->data['ads']);
$smarty->assign('smarty_data', $smarty_data);
$smarty->assign('ad', $main->ad);

$smarty->display('index.tpl');
?>