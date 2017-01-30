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

$string_data = serialize($data);
file_put_contents($filename, $string_data);
$data_temp = file_get_contents($filename);
$data = unserialize($data_temp);

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

//Массив переменных
$var_array =[
    'name' => get_item($data['ads'][$id]['name']),
    'email' => get_item($data['ads'][$id]['email']),
    'radio_private' => get_result($data['ads'][$id]['private'], $show_param),
    'radio_corp' => get_result($data['ads'][$id]['corp'], $show_param),
    'checkbox_confirm' => get_result($data['ads'][$id]['confirm_rss'], $show_param),
    'phone' => get_item($data['ads'][$id]['phone']),
    'city_id' => select_option($cities, $data['ads'][$id]['city']),
    'cat_id' => select_option($cities, $data['ads'][$id]['cat']),
    'name_ad' =>  get_item($data['ads'][$id]['name_ad']),
    'ad_text' =>  get_item($data['ads'][$id]['ad']),
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