<?php

error_reporting( E_ERROR );

$project_root = $_SERVER['DOCUMENT_ROOT'];
$smarty_dir = $project_root. '/smarty/';

// put full path to Smarty.class.php
require( $smarty_dir.'libs/Smarty.class.php');
include('mysql_conection.php');

include('ad.php');
include('ads_store.php');
include('data_store.php');

include('functions.php');

// SMARTY

$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->debugging = true;

$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';


$data_store = DataStore::instance();
$ads_store= AdsStore::instance();


if(isset($_POST['add'])) { // Добавление записи
    if (isset($_GET['del'])) {
        unset($_GET['del']);
    }
        $warnings = $data_store->getWarnings();

   if ($warnings['status'] === true) {
        $ad = new Ads($_POST);
       $ads_store->insertItem($db, $ad);
    }
}

if (isset($_GET['del'])) { //Удаление записи
    $ads_store->delItem($db);
}

$data_store->showAd($ads_store);
$ads_store->getAds($db);
$data_store->writeDataStore($data_store);
$data_store->getWarningsMassages();
$ads_store->writeAds();


$smarty->display('index.tpl');
?>